<?php
    include("cabecalho.php");
?>

<h1>Exercício 2</h1>
<form method="post">
<div class="mb-3">
              <label for="numero1" class="form-label">Insira um número</label>
              <input type="number" id="numero1" name="numero1" class="form-control" required="">
            </div><div class="mb-3">
              <label for="numero2" class="form-label">Insira outro número</label>
              <input type="number" id="numero2" name="numero2" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $numero1 = $_POST['numero1'];
        $numero2 = $_POST['numero2'];
        if($numero1 == $numero2){
            $triplo = 3 * ($numero1 + $numero2);
            echo "<p>O triplo da soma dos números é $triplo</p>";
        } else{
            $soma = $numero1 + $numero2;
            echo "<p>A soma de $numero1 + $numero2 é $soma</p>";
        }
    }
    include("rodape.php");
?>
