<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM ong WHERE ong_id = ?");
$stmt->execute([$id]);
$ong = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ong) {
    echo "<div class='alert alert-danger'>ONG não encontrada.</div>";
    require "rodape.php";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $cnpj = trim($_POST["cnpj"]);

    try {
        $stmt = $pdo->prepare("UPDATE ong SET ong_nome = ?, ong_cnpj = ? WHERE ong_id = ?");
        $stmt->execute([$nome, $cnpj, $id]);

        header("Location: listar_excluir_ong.php?status=edit_ok");
        exit;

    } catch (PDOException $e) {
        header("Location: editar_ong.php?id=$id&erro=1");
        exit;
    }
}
?>

<h2>Editar ONG</h2>

<?php if (isset($_GET['erro'])): ?>
<div class="alert alert-danger">Erro ao atualizar ONG. Verifique os dados.</div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nome da ONG</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($ong['ong_nome']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">CNPJ</label>
        <input type="text" name="cnpj" class="form-control" value="<?= htmlspecialchars($ong['ong_cnpj']) ?>" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_ong.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require "rodape.php"; ?>
