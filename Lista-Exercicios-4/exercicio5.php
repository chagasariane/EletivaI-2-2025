<?php
    include("cabecalho.php");
?>

<h1>Exercício 5</h1>
<form method="post">
<div class="mb-3">
            <?php for($i=1;$i<=2;$i++):?>
              <label for="titulo[]" class="form-label">Insira o título do <?= $i ?>º livro:</label>
              <input type="text" id="titulo[]" name="titulo[]" class="form-control" required="">
            </div><div class="mb-3">
              <label for="quantidade[]" class="form-label">Insira a quantidade do <?= $i ?>º livro:</label>
              <input type="number" id="quantidade[]" name="quantidade[]" class="form-control" required="">
            <?php endfor; ?>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulos = $_POST['titulo'];
        $quantidades = $_POST['quantidade'];

        $livros = [];

        for ($i = 0; $i < 2; $i++) {
            $titulo = $titulos[$i];
            $quantidade = $quantidades[$i];

            $livros[$titulo] = $quantidade;
        }

        ksort($livros);

        foreach ($livros as $titulo => $quantidade) {
            if ($quantidade < 5) {
                echo "<p>$titulo | Quantidade: $quantidade Estoque baixo!</p>";
            } else {
                echo "<p>$titulo | Quantidade: $quantidade</p>";
            }
        }
    }
    include("rodape.php");
?>