<?php
require "cabecalho.php";
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $telefone = trim($_POST["telefone"]);
    $cpf = trim($_POST["cpf"]);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO adotante (adot_nome, adot_telefone, adot_cpf)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$nome, $telefone, $cpf]);

        header("Location: listar_excluir_adotante.php?status=cad_ok");
        exit;

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            header("Location: cadastrar_adotante.php?erro=cpf");
            exit;
        }

        header("Location: cadastrar_adotante.php?erro=1");
        exit;
    }
}
?>

<h2>Cadastrar Adotante</h2>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'cpf'): ?>
<div class="alert alert-danger">Já existe um adotante cadastrado com esse CPF.</div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input name="nome" type="text" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input name="telefone" type="text" class="form-control" placeholder="(00) 00000-0000">
    </div>

    <div class="mb-3">
        <label class="form-label">CPF</label>
        <input name="cpf" type="text" class="form-control" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_adotante.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require "rodape.php"; ?>
