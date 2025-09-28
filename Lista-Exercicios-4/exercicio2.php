<?php
    include("cabecalho.php");
?>

<h1>Exercicio 2 </h1>
<form method="post">
<div class="mb-3">
            <?php for($i=1;$i<=5;$i++):?>
              <label for="nome[]" class="form-label">Insira o nome do <?= $i ?>º aluno:</label>
              <input type="text" id="nome[]" name="nome[]" class="form-control" required="">
            </div><div class="mb-3">
              <label for="nota1[]" class="form-label">Insira a primeira nota do <?= $i ?>º aluno:</label>
              <input type="float" id="nota1[]" name="nota1[]" class="form-control" required="">
            </div><div class="mb-3">
              <label for="nota2[]" class="form-label">Insira a segunda nota <?= $i ?>º aluno:</label>
              <input type="float" id="nota2[]" name="nota2[]" class="form-control" required="">
            </div><div class="mb-3">
              <label for="nota3[]" class="form-label">Insira a terceira nota <?= $i ?>º aluno:</label>
              <input type="float" id="nota3[]" name="nota3[]" class="form-control" required="">
            <?php endfor; ?>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomes = $_POST['nome'];
        $notas1 = $_POST['nota1'];
        $notas2 = $_POST['nota2'];
        $notas3 = $_POST['nota3'];

        $alunos = [];

        for ($i = 0; $i < 5; $i++) {
            $nome = $nomes[$i];
            $n1 = $notas1[$i];
            $n2 = $notas2[$i];
            $n3 = $notas3[$i];

            $media = ($n1 + $n2 + $n3) / 3;
            $alunos[$nome] = $media;
        }

        arsort($alunos);

        foreach ($alunos as $nome => $media) {
            echo "<p>$nome | Média: " . number_format($media, 2, ',', '.') . "</p>";
        }
    }

    include("rodape.php");

?>
