<?php
// cadastro.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Aqui você pode adicionar a lógica para salvar no banco de dados.
    // Exemplo: inserção via PDO (não incluído para simplificar).

    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Adoção</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #fffaf0;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-warning {
            background-color: #ffb347;
            border: none;
        }
        .btn-warning:hover {
            background-color: #ffa62b;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="width: 100%; max-width: 450px;">
            <h3 class="text-center mb-4">🐾 Cadastro de Usuário</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required placeholder="Ex: Maria dos Anjos">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="exemplo@email.com">
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required placeholder="********">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-warning text-white">Cadastrar</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="index.php" class="text-decoration-none text-muted">← Voltar para o início</a>
            </div>
        </div>
    </div>
</body>
</html>
