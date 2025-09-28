<?php
    include("cabecalho.php");
?>

<h1>Exercício 4</h1>
<form method="post">
<div class="mb-3">
            <?php for($i=1;$i<=5;$i++):?>
              <label for="nome[]" class="form-label">Insira o nome do <?= $i ?>º produto:</label>
              <input type="text" id="nome[]" name="nome[]" class="form-control" required="">
            </div><div class="mb-3">
              <label for="preco[]" class="form-label">Insira o preço do <?= $i ?>º produto:</label>
              <input type="float" id="preco[]" name="preco[]" class="form-control" required="">
            <?php endfor; ?>
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomes = $_POST['nome'];
        $precos = $_POST['preco'];

        $itens = [];

        for ($i = 0; $i < 5; $i++) {
            $nome = $nomes[$i];
            $preco = $precos[$i];

            $precoComImposto = $preco * 1.15;

            $itens[$nome] = $precoComImposto;
        }

        $precosOrdenacao = $itens;

        asort($precosOrdenacao);

        foreach ($precosOrdenacao as $nome => $preco) {
            echo "<p>$nome | R$ " . number_format($preco, 2, ',', '.') . "</p>";
        }
    }

    include("rodape.php");
?>