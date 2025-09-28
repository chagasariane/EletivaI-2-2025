<?php
    include("cabecalho.php");
?>

<h1>Exercício 6</h1>
<form method="post">
<div class="mb-3">
              <label for="numero" class="form-label">Digite um número de ponto flutuante:</label>
              <input type="float" id="numero" name="numero" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $numero = $_POST['numero'];

        function arredondarNumero($numero){
            echo "<p>$numero arredondado: ".round($numero)."</p>";
        }
        arredondarNumero($numero);
    }

    include("rodape.php");
?>