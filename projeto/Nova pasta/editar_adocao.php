<?php
require "cabecalho.php";
require "conexao.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM adocao WHERE ado_id = ?");
$stmt->execute([$id]);
$adocao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$adocao) {
    header("Location: adocao.php?erro=1");
    exit;
}

$stmt = $pdo->prepare("
    SELECT ani_id, nome, especie
    FROM animal
    WHERE adot_id IS NULL OR ani_id = ?
    ORDER BY nome
");
$stmt->execute([$adocao['ani_id']]);
$animais = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT adot_id, adot_nome FROM adotante ORDER BY adot_nome");
$adotantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ani_id = (int) $_POST["ani_id"];
    $adot_id = (int) $_POST["adot_id"];
    $data = $_POST["data_adocao"];

    try {
        $pdo->beginTransaction();

        if ($ani_id != $adocao['ani_id']) {
            $pdo->prepare("UPDATE animal SET adot_id = NULL WHERE ani_id = ?")
                ->execute([$adocao['ani_id']]);
        }

        $pdo->prepare("UPDATE animal SET adot_id = ? WHERE ani_id = ?")
            ->execute([$adot_id, $ani_id]);

        $stmt = $pdo->prepare("SELECT ong_id FROM animal WHERE ani_id = ?");
        $stmt->execute([$ani_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        $ong_id = $animal['ong_id'];

        $stmt = $pdo->prepare("
            UPDATE adocao
            SET ani_id = ?, adot_id = ?, ong_id = ?, data_adocao = ?
            WHERE ado_id = ?
        ");
        $stmt->execute([$ani_id, $adot_id, $ong_id, $data, $id]);

        $pdo->commit();

        header("Location: adocao.php?edit_ok=1");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: editar_adocao.php?id=" . $id . "&erro=1");
        exit;
    }
}
?>

<h2>Editar Adoção</h2>

<?php if (isset($_GET['erro'])): ?>
<div class="alert alert-danger">Erro ao editar adoção.</div>
<?php endif; ?>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Animal</label>
        <select name="ani_id" class="form-select" required>
            <?php foreach ($animais as $a): ?>
                <option 
                    value="<?= $a['ani_id'] ?>" 
                    <?= $a['ani_id'] == $adocao['ani_id'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($a['nome']) ?> (<?= $a['especie'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Adotante</label>
        <select name="adot_id" class="form-select" required>
            <?php foreach ($adotantes as $ad): ?>
                <option 
                  value="<?= $ad['adot_id'] ?>" 
                  <?= $ad['adot_id'] == $adocao['adot_id'] ? "selected" : "" ?>>
                  <?= htmlspecialchars($ad['adot_nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Data</label>
        <input type="date" name="data_adocao" class="form-control" 
               value="<?= $adocao['data_adocao'] ?>" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="adocao.php" class="btn btn-secondary">Voltar</a>

</form>

<?php require "rodape.php"; ?>
