<?php
require "cabecalho.php";
require "conexao.php";

if (isset($_GET['ok'])) {
    echo '<div class="alert alert-success">Adoção registrada com sucesso!</div>';
}
if (isset($_GET['cancel_ok'])) {
    echo '<div class="alert alert-success">Adoção cancelada com sucesso. O animal voltou para a lista de disponíveis.</div>';
}
if (isset($_GET['edit_ok'])) {
    echo '<div class="alert alert-success">Adoção editada com sucesso!</div>';
}
if (isset($_GET['erro'])) {
    echo '<div class="alert alert-danger">Erro ao realizar operação.</div>';
}

if (isset($_GET['cancelar'])) {
    $ado_id = (int) $_GET['cancelar'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT ani_id FROM adocao WHERE ado_id = ?");
        $stmt->execute([$ado_id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($info) {
            $ani_id = $info['ani_id'];

            $pdo->prepare("DELETE FROM adocao WHERE ado_id = ?")->execute([$ado_id]);

            $pdo->prepare("UPDATE animal SET adot_id = NULL WHERE ani_id = ?")->execute([$ani_id]);

            $pdo->commit();
            header("Location: adocao.php?cancel_ok=1");
            exit;
        }

        $pdo->rollBack();
        header("Location: adocao.php?erro=1");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: adocao.php?erro=1");
        exit;
    }
}

$stmt = $pdo->query("
    SELECT a.ani_id, a.nome, a.especie, o.ong_nome
    FROM animal a
    JOIN ong o ON o.ong_id = a.ong_id
    WHERE a.adot_id IS NULL
    ORDER BY a.nome
");
$animais = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->query("SELECT adot_id, adot_nome FROM adotante ORDER BY adot_nome");
$adotantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ani_id  = (int) $_POST["ani_id"];
    $adot_id = (int) $_POST["adot_id"];
    $data = $_POST["data_adocao"];

    try {
        $stmt = $pdo->prepare("SELECT ong_id FROM animal WHERE ani_id = ?");
        $stmt->execute([$ani_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            header("Location: adocao.php?erro=1");
            exit;
        }

        $ong_id = $animal['ong_id'];

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO adocao (ani_id, adot_id, ong_id, data_adocao)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$ani_id, $adot_id, $ong_id, $data]);

        $pdo->prepare("UPDATE animal SET adot_id = ? WHERE ani_id = ?")
            ->execute([$adot_id, $ani_id]);

        $pdo->commit();

        header("Location: adocao.php?ok=1");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: adocao.php?erro=1");
        exit;
    }
}

$stmt = $pdo->query("
    SELECT ad.ado_id,
           ad.data_adocao,
           an.nome AS animal,
           an.especie,
           ado.adot_nome AS adotante,
           o.ong_nome
    FROM adocao ad
    JOIN animal an ON an.ani_id = ad.ani_id
    JOIN adotante ado ON ado.adot_id = ad.adot_id
    JOIN ong o ON o.ong_id = ad.ong_id
  ORDER BY ad.data_adocao DESC
");
$adocoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Registrar Adoção</h2>

<form method="POST" class="mb-4">

    <div class="mb-3">
        <label class="form-label">Animal</label>
        <select name="ani_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($animais as $a): ?>
                <option value="<?= $a['ani_id'] ?>">
                    <?= htmlspecialchars($a['nome']) ?> (<?= $a['especie'] ?> - <?= $a['ong_nome'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (empty($animais)): ?>
            <small class="text-muted">Nenhum animal disponível.</small>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Adotante</label>
        <select name="adot_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($adotantes as $ad): ?>
                <option value="<?= $ad['adot_id'] ?>">
                    <?= htmlspecialchars($ad['adot_nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Data</label>
        <input type="date" name="data_adocao" class="form-control"
               value="<?= date('Y-m-d') ?>" required>
    </div>

    <button class="btn btn-primary" <?= empty($animais) ? "disabled" : "" ?>>
        Registrar Adoção
    </button>
</form>

<h2>Adoções Realizadas</h2>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Animal</th>
            <th>Espécie</th>
            <th>Adotante</th>
            <th>ONG</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($adocoes as $ad): ?>
        <tr>
            <td><?= $ad['ado_id'] ?></td>
            <td><?= date('d/m/Y', strtotime($ad['data_adocao'])) ?></td>
            <td><?= htmlspecialchars($ad['animal']) ?></td>
            <td><?= htmlspecialchars($ad['especie']) ?></td>
            <td><?= htmlspecialchars($ad['adotante']) ?></td>
            <td><?= htmlspecialchars($ad['ong_nome']) ?></td>
            <td>
                <a href="editar_adocao.php?id=<?= $ad['ado_id'] ?>" class="btn btn-warning btn-sm">
                    Editar
                </a>

                <a href="adocao.php?cancelar=<?= $ad['ado_id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Cancelar esta adoção? O animal voltará para a lista de disponíveis.');">
                   Cancelar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "rodape.php"; ?>
