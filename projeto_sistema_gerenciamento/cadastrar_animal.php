<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

// Carregar ONGs
$stmt = $pdo->query("SELECT * FROM ong ORDER BY ong_nome");
$ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $especie   = trim($_POST["especie"]);
    $raca      = trim($_POST["raca"]);
    $nome      = trim($_POST["nome"]);
    $fase      = trim($_POST["fase_vida"]);
    $sexo      = trim($_POST["sexo"]);
    $ong_id    = (int) $_POST["ong_id"];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO animal (especie, `raça`, nome, fase_vida, sexo, ong_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$especie, $raca, $nome, $fase, $sexo, $ong_id]);

        header("Location: listar_excluir_animal.php?status=cad_ok");
        exit;

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Erro ao cadastrar o animal.</div>';
    }
}
?>

<h2>Cadastrar Animal</h2>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Espécie</label>
        <select name="especie" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outro">Outro</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Raça</label>
        <input type="text" name="raca" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nome do animal (opcional)</label>
        <input type="text" name="nome" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Fase da vida</label>
        <select name="fase_vida" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Filhote">Filhote</option>
            <option value="Adulto">Adulto</option>
            <option value="Idoso">Idoso</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Sexo</label>
        <select name="sexo" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Macho">Macho</option>
            <option value="Fêmea">Fêmea</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">ONG Responsável</label>
        <select name="ong_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($ongs as $o): ?>
                <option value="<?= $o['ong_id'] ?>"><?= htmlspecialchars($o['ong_nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_animal.php" class="btn btn-secondary">Voltar</a>

</form>

<?php require "rodape.php"; ?>
