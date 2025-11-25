<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LAR AMIGO</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
      background: #fffaf0;
      font-family: 'Poppins', Arial;
  }
</style>
</head>

<body>
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="principal.php">LAR AMIGO</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
            aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link" href="principal.php">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Cadastros
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listar_excluir_animal.php">Animal</a></li>
            <li><a class="dropdown-item" href="listar_excluir_adotante.php">Adotante</a></li>
            <li><a class="dropdown-item" href="listar_excluir_ong.php">ONG</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="adocao.php">Adoções</a>
        </li>
      </ul>

      <span class="navbar-text">
        <?= isset($_SESSION['nome']) ? "Olá, " . htmlspecialchars($_SESSION['nome']) : "" ?>
      </span>
    </div>
  </div>
</nav>

<div class="container py-3">
