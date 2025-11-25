<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuario (usu_nome, usu_email, usu_senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        header("Location: index.php?cadastro_ok=1");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header("Location: cadastro.php?erro=email");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Criar Conta - Lar Amigo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #ffeccc, #fffaf0);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

.card {
    border-radius: 20px;
    padding: 30px;
    width: 370px;
    border: none;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.paw {
    font-size: 60px;
    color: #ff9f43;
}
</style>
</head>

<body>

<div class="card">
    <div class="text-center mb-3">
        <div class="paw">🐾</div>
        <h3 class="fw-bold">Criar Conta</h3>
    </div>

    <?php if (isset($_GET["erro"]) && $_GET["erro"] == "email"): ?>
    <div class="alert alert-danger">Este e-mail já está cadastrado.</div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Nome completo</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button class="btn w-100 text-white" style="background:#ff9f43;">Cadastrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">Voltar ao login</a>
    </div>
</div>

</body>
</html>
