<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 10</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container">
<h1>Perímetro do retângulo</h1>
<form method="post">
<div class="mb-3">
              <label for="largura" class="form-label">Insira a largura do retângulo</label>
              <input type="number" id="largura" name="largura" class="form-control" required="">
            </div><div class="mb-3">
              <label for="altura" class="form-label">Insira a altura do retângulo</label>
              <input type="number" id="altura" name="altura" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $largura = $_POST['largura'];
    $altura = $_POST['altura'];
    $perimetro = (2*$largura) + (2*$altura);
    echo "<p> Perímetro do retângulo = $perimetro </p>";
}

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>