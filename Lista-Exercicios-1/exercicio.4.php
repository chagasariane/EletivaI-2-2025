<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercício 4</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container">
<h1>Divisão de Valores com Verificação</h1>
<form method="post">
<div class="mb-3">
              <label for="valor1" class="form-label">Informe o primeiro valor</label>
              <input type="number" id="valor1" name="valor1" class="form-control" required="">
            </div><div class="mb-3">
              <label for="valor2" class="form-label">Informe o segundo valor</label>
              <input type="number" id="valor2" name="valor2" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $valor1 = $_POST['valor1'];
        $valor2 = $_POST['valor2'];
        if($valor2 > 0){
            $divisao = $valor1 / $valor2;
            echo "<p>Divisão: $divisao</p>";
        }
        elseif($valor2 == 0){
            echo "<p>Divisão por zero não existe!</p>";
        }
    }

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>