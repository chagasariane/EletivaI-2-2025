<?php
    include("cabecalho.php");
?>

<h1>Exercício 3</h1>
<form method="post">
<div class="mb-3">
              <label for="palavra1" class="form-label">Insira uma palavra:</label>
              <input type="text" id="palavra1" name="palavra1" class="form-control" required="">
            </div><div class="mb-3">
              <label for="palavra2" class="form-label">Insira outra palavra:</label>
              <input type="text" id="palavra2" name="palavra2" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $palavra1 = $_POST['palavra1'];
        $palavra2 = $_POST['palavra2'];

        function verificaPalavra($palavra1, $palavra2){
            $contem = strpos($palavra1, $palavra2);
            if($contem){
                echo "<p>A segunda palavra está contida na primeira palavra</p>";
            }
            else{
                echo "<p>A segunda palavra não está contida na primeira palavra</p>";
            }
        }
        verificaPalavra($palavra1, $palavra2);
    }
    

    include("rodape.php");
?>