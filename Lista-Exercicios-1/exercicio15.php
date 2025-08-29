<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 15</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercício 15</h1>
<form method="post">
<div class="mb-3">
              <label for="peso" class="form-label">Insira o peso</label>
              <input type="number" id="peso" name="peso" class="form-control" required="" step="0.01">
            </div><div class="mb-3">
              <label for="altura" class="form-label">Insira a altura</label>
              <input type="number" id="altura" name="altura" class="form-control" required="" step="0.01">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $peso = (float) $_POST["peso"];
        $altura = (float) $_POST["altura"];
        $imc = ($peso / ($altura ** 2));
        echo "O IMC é igual a ".number_format($imc, 2, ',', '.');
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>