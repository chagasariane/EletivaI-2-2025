<?php
    include("cabecalho.php");
?>
<h1>Exercício 1</h1>
<form method="post">
<div class="mb-3">
              <label for="palavra" class="form-label">Insira uma palavra:</label>
              <input type="text" id="palavra" name="palavra" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $palavra = $_POST['palavra'];

        function qtdCarateres($palavra){
            echo "<p>Quantidade de caracteres: ".strlen($palavra)."</p>";
        }

        qtdCarateres($palavra);
    }

    include("rodape.php");
?>
