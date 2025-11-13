<?php
// index.php - Tela de login
session_start();
require __DIR__ . '/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $sql = "SELECT idusuario, nome, email, senha FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login OK
            $_SESSION['idusuario'] = $usuario['idusuario'];
            $_SESSION['nome']      = $usuario['nome'];

            header('Location: principal.php');
            exit;
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Adoção de Animais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #fffaf0;
            font-family: 'Poppins', sans-serif;
        }
        .main-container {
            height: 100vh;
        }
        .welcome-box {
            background: #fefefe;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 420px;
            width: 100%;
        }
        .paw {
            font-size: 50px;
            color: #ffb347;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center main-container">
        <div class="welcome-box">
            <div class="paw">🐾</div>
            <h1 class="mt-3">Bem-vindo ao Sistema de Adoção 💛</h1>
            <p class="text-muted mb-4">Cuidando de quem precisa de um lar com amor e responsabilidade.</p>

            <?php if ($erro): ?>
                <div class="alert alert-danger py-2" role="alert">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="exemplo@email.com">
                </div>
                <div class="mb-3 text-start">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required placeholder="********">
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-warning btn-lg text-white shadow-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </div>
            </form>

            <div class="mt-2">
                <small class="text-muted">
                    Não tem conta?
                    <a href="cadastro.php" class="text-decoration-none">Cadastre-se aqui</a>.
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
