<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/conexao.php";

$mensagem = "";

/* ============================================
   CANCELAR ADOÇÃO (EXCLUIR E LIBERAR ANIMAL)
   ============================================ */
if (isset($_GET['cancelar'])) {
    $ado_id = (int) $_GET['cancelar'];

    try {
        $pdo->beginTransaction();

        // Descobrir qual animal está ligado a essa adoção
        $stmt = $pdo->prepare("SELECT ani_id FROM adocao WHERE ado_id = ?");
        $stmt->execute([$ado_id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($info) {
            $ani_id = (int) $info['ani_id'];

            // Exclui a adoção
            $stmt = $pdo->prepare("DELETE FROM adocao WHERE ado_id = ?");
            $stmt->execute([$ado_id]);

            // Deixa o animal disponível novamente
            $stmt = $pdo->prepare("UPDATE animal SET adot_id = NULL WHERE ani_id = ?");
            $stmt->execute([$ani_id]);

            $pdo->commit();
            header("Location: adocao.php?cancelar_ok=1");
            exit;
        } else {
            $pdo->rollBack();
            header("Location: adocao.php?cancelar_ok=0");
            exit;
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: adocao.php?cancelar_ok=0");
        exit;
    }
}

/* ============================================
   CARREGAR ANIMAIS DISPONÍVEIS E ADOTANTES
   ============================================ */

// 🔴 AQUI GARANTIMOS QUE SÓ ANIMAIS NÃO ADOTADOS ENTREM NA LISTA
try {
    $sqlAni = "
        SELECT a.ani_id, a.nome AS ani_nome, a.especie, o.ong_nome
          FROM animal a
          JOIN ong o ON o.ong_id = a.ong_id
         WHERE a.adot_id IS NULL
         ORDER BY o.ong_nome, a.nome
    ";
    $stmt = $pdo->query($sqlAni);
    $animais = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $animais = [];
}

try {
    $stmt = $pdo->query("SELECT adot_id, adot_nome FROM adotante ORDER BY adot_nome");
    $adotantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $adotantes = [];
}

/* ============================================
   REGISTRAR NOVA ADOÇÃO
   ============================================ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ani_id      = (int) ($_POST['ani_id'] ?? 0);
    $adot_id     = (int) ($_POST['adot_id'] ?? 0);
    $data_adocao = $_POST['data_adocao'] ?? date('Y-m-d');

    try {
        // Buscar ONG do animal
        $stmt = $pdo->prepare("SELECT ong_id FROM animal WHERE ani_id = ?");
        $stmt->execute([$ani_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            $mensagem = '<p class="text-danger">Animal inválido.</p>';
        } else {
            $ong_id = (int) $animal['ong_id'];

            $pdo->beginTransaction();

            // Inserir adoção
            $stmt = $pdo->prepare("
                INSERT INTO adocao (ani_id, adot_id, ong_id, data_adocao)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$ani_id, $adot_id, $ong_id, $data_adocao]);

            // Atualizar animal com adotante (deixa de ser disponível)
            $stmt = $pdo->prepare("UPDATE animal SET adot_id = ? WHERE ani_id = ?");
            $stmt->execute([$adot_id, $ani_id]);

            $pdo->commit();
            $mensagem = '<p class="text-success">Adoção registrada com sucesso!</p>';
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $mensagem = '<p class="text-danger">Erro ao registrar adoção.</p>';
    }
}

/* ============================================
   LISTAR ADOÇÕES REALIZADAS
   ============================================ */

try {
    $sqlList = "
        SELECT adoc.ado_id,
               adoc.data_adocao,
               ani.nome AS ani_nome,
               ani.especie,
               adt.adot_nome,
               o.ong_nome
          FROM adocao adoc
          JOIN animal   ani ON ani.ani_id   = adoc.ani_id
          JOIN adotante adt ON adt.adot_id  = adoc.adot_id
          JOIN ong      o   ON o.ong_id     = adoc.ong_id
      ORDER BY adoc.data_adocao DESC
    ";
    $stmt = $pdo->query($sqlList);
    $adocoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $adocoes = [];
}

require __DIR__ . "/cabecalho.php";
?>

<h2>Registrar Adoção</h2>

<?php
// Mensagem de criação
if ($mensagem) {
    echo $mensagem;
}

// Mensagem de cancelamento
if (isset($_GET['cancelar_ok'])) {
    if ($_GET['cancelar_ok']) {
        echo '<p class="text-success">Adoção cancelada com sucesso. O animal voltou a ficar disponível.</p>';
    } else {
        echo '<p class="text-danger">Não foi possível cancelar a adoção.</p>';
    }
}

// Mensagem de edição
if (isset($_GET['editar'])) {
    if ($_GET['editar']) {
        echo '<p class="text-success">Adoção atualizada com sucesso.</p>';
    } else {
        echo '<p class="text-danger">Não foi possível atualizar a adoção.</p>';
    }
}
?>

<form method="post" class="mb-4">
    <div class="mb-3">
        <label for="ani_id" class="form-label">Animal</label>
        <select id="ani_id" name="ani_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($animais as $ani): ?>
                <option value="<?= $ani['ani_id'] ?>">
                    <?= htmlspecialchars($ani['ani_nome']) ?> (<?= htmlspecialchars($ani['especie']) ?> - <?= htmlspecialchars($ani['ong_nome']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (empty($animais)): ?>
            <small class="text-muted">Não há animais disponíveis para adoção no momento.</small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="adot_id" class="form-label">Adotante</label>
        <select id="adot_id" name="adot_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($adotantes as $a): ?>
                <option value="<?= $a['adot_id'] ?>"><?= htmlspecialchars($a['adot_nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="data_adocao" class="form-label">Data da adoção</label>
        <input type="date" id="data_adocao" name="data_adocao" class="form-control"
               value="<?= date('Y-m-d') ?>" required>
    </div>
    <button type="submit" class="btn btn-primary" <?= empty($animais) ? 'disabled' : '' ?>>
        Registrar Adoção
    </button>
</form>

<h3>Adoções realizadas</h3>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Animal</th>
            <th>Espécie</th>
            <th>Adotante</th>
            <th>ONG</th>
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adocoes as $ad): ?>
            <tr>
                <td><?= $ad['ado_id'] ?></td>
                <td><?= date('d/m/Y', strtotime($ad['data_adocao'])) ?></td>
                <td><?= htmlspecialchars($ad['ani_nome']) ?></td>
                <td><?= htmlspecialchars($ad['especie']) ?></td>
                <td><?= htmlspecialchars($ad['adot_nome']) ?></td>
                <td><?= htmlspecialchars($ad['ong_nome']) ?></td>
                <td class="no-print d-flex gap-2">
                    <a href="editar_adocao.php?id=<?= $ad['ado_id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="adocao.php?cancelar=<?= $ad['ado_id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Confirma cancelar esta adoção? O animal voltará a ficar disponível.');">
                        Cancelar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require __DIR__ . "/rodape.php";
