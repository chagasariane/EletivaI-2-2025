<?php
    include("cabecalho.php");
?>
<h1>Exercício 4</h1>
<form method="post">
<div class="mb-3">
              <label for="valor" class="form-label">Informe um valor</label>
              <input type="number" id="valor" name="valor" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $valor = $_POST['valor'];
        if($valor > 100){
            $desconto = $valor - ($valor * 0.15);
            echo "<p>O valor do produto com desconto é de R$".number_format($desconto, 2, ",", ".")."</p>";
        }
    }
    include("rodape.php");
?>