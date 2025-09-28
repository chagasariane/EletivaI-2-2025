<?php
    include("cabecalho.php");
?>

<h1>Exercício 4</h1>
<form method="post">
<div class="mb-3">
              <label for="dia" class="form-label">Digite um dia:</label>
              <input type="number" id="dia" name="dia" class="form-control" required="">
            </div><div class="mb-3">
              <label for="mes" class="form-label">Digite um mês:</label>
              <input type="number" id="mes" name="mes" class="form-control" required="">
            </div><div class="mb-3">
              <label for="ano" class="form-label">Digite um ano:</label>
              <input type="number" id="ano" name="ano" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        function verificaData($dia, $mes, $ano){
            if (checkdate($mes, $dia, $ano)){
                echo "<p>A data informada existe ($dia/$mes/$ano)</p>";
            }else{
                echo "<p>A data informada não existe ($dia/$mes/$ano)!</p>";
            }
        }
        verificaData($dia, $mes, $ano);
    }

    include("rodape.php");
?>