<?php
require "cabecalho.php";
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $cnpj = trim($_POST["cnpj"]);

    try {
        $stmt = $pdo->prepare("INSERT INTO ong (ong_nome, ong_cnpj) VALUES (?, ?)");
        $stmt->execute([$nome, $cnpj]);

        header("Location: listar_excluir_ong.php?status=cad_ok");
        exit;

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            header("Location: cadastrar_ong.php?erro=cnpj");
            exit;
        }

        header("Location: cadastrar_ong.php?erro=1");
        exit;
    }
}
?>

<h2>Cadastrar ONG</h2>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'cnpj'): ?>
<div class="alert alert-danger">Já existe uma ONG cadastrada com esse CNPJ.</div>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] == '1'): ?>
<div class="alert alert-danger">Erro ao cadastrar a ONG.</div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nome da ONG</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">CNPJ</label>
        <input type="text" name="cnpj" class="form-control" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_ong.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require "rodape.php"; ?>
