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
    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');

    try {
        $stmt = $pdo->prepare("INSERT INTO ong (ong_nome, ong_cnpj) VALUES (?, ?)");
        $ok = $stmt->execute([$nome, $cnpj]);
        header("Location: listar_excluir_ong.php?cadastro=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $mensagem = "<p class='text-danger'>Já existe uma ONG cadastrada com esse CNPJ.</p>";
        } else {
            $mensagem = "<p class='text-danger'>Erro ao cadastrar ONG.</p>";
        }
    }
}
?>

<h1>Nova ONG</h1>
<?= $mensagem ?>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da ONG</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="cnpj" class="form-label">CNPJ</label>
        <input type="text" id="cnpj" name="cnpj" class="form-control" required placeholder="00.000.000/0000-00">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_ong.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
