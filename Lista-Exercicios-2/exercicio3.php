<?php
    include("cabecalho.php");
?>

<h1>Exercício 3</h1>
<form method="post">
<div class="mb-3">
              <label for="valorA" class="form-label">Insira um número</label>
              <input type="number" id="valorA" name="valorA" class="form-control" required="">
            </div><div class="mb-3">
              <label for="valorB" class="form-label">Insira outro número</label>
              <input type="number" id="valorB" name="valorB" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $valorA = $_POST['valorA'];
        $valorB = $_POST['valorB'];

        if($valorA != $valorB){
            $maior = $valorA; 
            if($valorB > $maior){
                echo "<p>$valorA, $valorB</p>";
            } else{
                echo "<p>$valorB, $valorA";
            }
        }else
            echo "Números iguais: $valorA</p>";
    }

    include("rodape.php");
?>
