<?php
require "cabecalho.php";
require "conexao.php";

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM adotante WHERE adot_id = ?");
$stmt->execute([$id]);
$adotante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$adotante) {
    echo "<div class='alert alert-danger'>Adotante não encontrado.</div>";
    require "rodape.php";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $telefone = trim($_POST["telefone"]);
    $cpf = trim($_POST["cpf"]);

    try {
        $stmt = $pdo->prepare("
            UPDATE adotante
            SET adot_nome = ?, adot_telefone = ?, adot_cpf = ?
            WHERE adot_id = ?
        ");
        $stmt->execute([$nome, $telefone, $cpf, $id]);

        header("Location: listar_excluir_adotante.php?status=edit_ok");
        exit;

    } catch (PDOException $e) {
        header("Location: editar_adotante.php?id=$id&erro=1");
        exit;
    }
}
?>

<h2>Editar Adotante</h2>

<?php if (isset($_GET['erro'])): ?>
<div class="alert alert-danger">Erro ao atualizar adotante. Verifique os dados.</div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input name="nome" type="text" class="form-control"
               value="<?= htmlspecialchars($adotante['adot_nome']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input name="telefone" type="text" class="form-control"
               value="<?= htmlspecialchars($adotante['adot_telefone']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">CPF</label>
        <input name="cpf" type="text" class="form-control"
               value="<?= htmlspecialchars($adotante['adot_cpf']) ?>" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_adotante.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require "rodape.php"; ?>
