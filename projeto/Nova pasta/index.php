<?php
session_start();
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE usu_email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($u && password_verify($senha, $u["usu_senha"])) {
        $_SESSION["acesso"] = true;
        $_SESSION["idusuario"] = $u["usu_id"];
        $_SESSION["nome"] = $u["usu_nome"];

        header("Location: principal.php");
        exit;
    } else {
        header("Location: index.php?erro=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login - Lar Amigo</title>

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

<div class="card" style="width: 370px;">
    <div class="text-center mb-3">
        <div class="paw">🐾</div>
        <h3 class="fw-bold">Lar Amigo</h3>
        <p class="text-muted">Acesso ao sistema</p>
    </div>

    <?php if (isset($_GET["erro"])): ?>
    <div class="alert alert-danger">E-mail ou senha incorretos.</div>
    <?php endif; ?>

    <?php if (isset($_GET["cadastro_ok"])): ?>
    <div class="alert alert-success">Cadastro realizado com sucesso!</div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required placeholder="exemplo@email.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button class="btn w-100 text-white" style="background:#ff9f43;">Entrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="cadastro.php" class="text-decoration-none">Criar conta</a>
    </div>
</div>

</body>
</html>
