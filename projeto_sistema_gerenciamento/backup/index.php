<?php
// index.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Adoção de Animais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="cadastro.php" class="btn btn-warning btn-lg text-white shadow-sm">
                <i class="bi bi-person-plus"></i> Cadastrar Novo Usuário
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
