<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

$ado_id = (int) ($_GET['id'] ?? 0);

// Carregar adoção atual
try {
    $sql = "
        SELECT adoc.ado_id,
               adoc.ani_id,
               adoc.adot_id,
               adoc.data_adocao,
               ani.nome  AS ani_nome,
               ani.especie,
               adt.adot_nome
          FROM adocao adoc
          JOIN animal   ani ON ani.ani_id  = adoc.ani_id
          JOIN adotante adt ON adt.adot_id = adoc.adot_id
         WHERE adoc.ado_id = ?
         LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ado_id]);
    $ado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ado) {
        echo "<p class='text-danger'>Adoção não encontrada.</p>";
        require __DIR__ . "/rodape.php";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao carregar adoção.</p>";
    require __DIR__ . "/rodape.php";
    exit;
}

// Carregar lista de adotantes para o select
try {
    $stmt = $pdo->query("SELECT adot_id, adot_nome FROM adotante ORDER BY adot_nome");
    $adotantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $adotantes = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_adot_id  = (int) ($_POST['adot_id'] ?? 0);
    $data_adocao   = $_POST['data_adocao'] ?? $ado['data_adocao'];
    $ani_id        = (int) ($_POST['ani_id'] ?? $ado['ani_id']);

    try {
        $pdo->beginTransaction();

        // Atualiza a adoção
        $stmt = $pdo->prepare("
            UPDATE adocao
               SET adot_id = ?, data_adocao = ?
             WHERE ado_id = ?
        ");
        $stmt->execute([$novo_adot_id, $data_adocao, $ado_id]);

        // Garante que o animal está com o adotante correto
        $stmt = $pdo->prepare("UPDATE animal SET adot_id = ? WHERE ani_id = ?");
        $stmt->execute([$novo_adot_id, $ani_id]);

        $pdo->commit();

        header("Location: adocao.php?editar=1");
        exit;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "<p class='text-danger'>Erro ao atualizar a adoção.</p>";
    }
}
?>

<h1>Editar Adoção</h1>

<form method="post">
    <input type="hidden" name="ani_id" value="<?= $ado['ani_id'] ?>">

    <div class="mb-3">
        <label class="form-label">Animal</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($ado['ani_nome']) ?> (<?= htmlspecialchars($ado['especie']) ?>)" disabled>
    </div>

    <div class="mb-3">
        <label for="adot_id" class="form-label">Adotante</label>
        <select id="adot_id" name="adot_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($adotantes as $a): ?>
                <option value="<?= $a['adot_id'] ?>"
                    <?= $a['adot_id'] == $ado['adot_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['adot_nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="data_adocao" class="form-label">Data da adoção</label>
        <input type="date" id="data_adocao" name="data_adocao"
               class="form-control"
               value="<?= htmlspecialchars($ado['data_adocao']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="adocao.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
