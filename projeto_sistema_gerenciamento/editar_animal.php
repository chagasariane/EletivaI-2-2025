<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

$id = (int) $_GET['id'];

// Carregar animal
$stmt = $pdo->prepare("SELECT * FROM animal WHERE ani_id = ?");
$stmt->execute([$id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$animal) {
    echo '<div class="alert alert-danger">Animal não encontrado.</div>';
    require "rodape.php";
    exit;
}

// Carregar ONGs
$stmt = $pdo->query("SELECT * FROM ong ORDER BY ong_nome");
$ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $especie = trim($_POST["especie"]);
    $raca = trim($_POST["raca"]);
    $nome = trim($_POST["nome"]);
    $fase = trim($_POST["fase_vida"]);
    $sexo = trim($_POST["sexo"]);
    $ong_id = (int) $_POST["ong_id"];

    try {
        $stmt = $pdo->prepare("
            UPDATE animal
               SET especie = ?, `raça` = ?, nome = ?, fase_vida = ?, sexo = ?, ong_id = ?
             WHERE ani_id = ?
        ");
        $stmt->execute([$especie, $raca, $nome, $fase, $sexo, $ong_id, $id]);

        header("Location: listar_excluir_animal.php?status=edit_ok");
        exit;

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Erro ao editar o animal.</div>';
    }
}
?>

<h2>Editar Animal</h2>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Espécie</label>
        <select name="especie" class="form-select" required>
            <option value="Cachorro" <?= $animal['especie'] == 'Cachorro' ? 'selected' : '' ?>>Cachorro</option>
            <option value="Gato" <?= $animal['especie'] == 'Gato' ? 'selected' : '' ?>>Gato</option>
            <option value="Outro" <?= $animal['especie'] == 'Outro' ? 'selected' : '' ?>>Outro</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Raça</label>
        <input type="text" name="raca" class="form-control" required value="<?= htmlspecialchars($animal['raça']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($animal['nome']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Fase da vida</label>
        <select name="fase_vida" class="form-select" required>
            <option value="Filhote" <?= $animal['fase_vida'] == 'Filhote' ? 'selected' : '' ?>>Filhote</option>
            <option value="Adulto" <?= $animal['fase_vida'] == 'Adulto' ? 'selected' : '' ?>>Adulto</option>
            <option value="Idoso" <?= $animal['fase_vida'] == 'Idoso' ? 'selected' : '' ?>>Idoso</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Sexo</label>
        <select name="sexo" class="form-select" required>
            <option value="Macho" <?= $animal['sexo'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
            <option value="Fêmea" <?= $animal['sexo'] == 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">ONG Responsável</label>
        <select name="ong_id" class="form-select" required>
            <?php foreach ($ongs as $o): ?>
                <option value="<?= $o['ong_id'] ?>" <?= $o['ong_id'] == $animal['ong_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($o['ong_nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_animal.php" class="btn btn-secondary">Voltar</a>

</form>

<?php require "rodape.php"; ?>
