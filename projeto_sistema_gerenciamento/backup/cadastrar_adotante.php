<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = trim($_POST['nome'] ?? '');
    $telefone  = trim($_POST['telefone'] ?? '');
    $cpf       = trim($_POST['cpf'] ?? '');

    try {
        $stmt = $pdo->prepare("
            INSERT INTO adotante (adot_nome, adot_telefone, adot_cpf)
            VALUES (?, ?, ?)
        ");
        $ok = $stmt->execute([$nome, $telefone, $cpf]);
        header("Location: listar_excluir_adotante.php?cadastro=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $mensagem = "<p class='text-danger'>Já existe um adotante cadastrado com esse CPF.</p>";
        } else {
            $mensagem = "<p class='text-danger'>Erro ao cadastrar adotante.</p>";
        }
    }
}
?>

<h1>Novo Adotante</h1>
<?= $mensagem ?>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome completo</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" id="telefone" name="telefone" class="form-control" placeholder="(00) 00000-0000">
    </div>
    <div class="mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" id="cpf" name="cpf" class="form-control" required placeholder="000.000.000-00">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_adotante.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
