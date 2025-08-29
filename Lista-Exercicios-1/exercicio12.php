<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 12</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercício 12</h1>
<form method="post">
<div class="mb-3">
              <label for="base" class="form-label">Insira o valor da base</label>
              <input type="number" id="base" name="base" class="form-control" required="">
            </div><div class="mb-3">
              <label for="expoente" class="form-label">Insira o valor do expoente</label>
              <input type="number" id="expoente" name="expoente" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $base = $_POST["base"];
        $expoente = $_POST["expoente"];
        $resultado = $base ** $expoente;
        echo "$base ^ $expoente = $resultado";
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>