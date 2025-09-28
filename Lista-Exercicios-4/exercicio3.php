<?php
    include("cabecalho.php");
?>

<h1>Exercício 3</h1>
<form method="post">
<div class="mb-3">
            <?php for($i=1;$i<=5;$i++):?>
              <label for="codigo[]" class="form-label">Insira o código do <?= $i ?>º produto:</label>
              <input type="number" id="codigo[]" name="codigo[]" class="form-control" required="">
            </div><div class="mb-3">
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
        $codigos = $_POST['codigo'];
        $nomes = $_POST['nome'];
        $precos = $_POST['preco'];

        $produtos = [];

        for ($i = 0; $i < 5; $i++) {
            $codigo = $codigos[$i];
            $nome = $nomes[$i];
            $preco = $precos[$i];

            if ($preco > 100) {
                $preco = $preco * 0.9;
            }

            $info = [
                'nome' => $nome,
                'preco' => $preco
            ];
            ksort($info);

            $produtos[$codigo] = $info;
        }

        $nomesOrdenacao = [];
        foreach ($produtos as $codigo => $dados) {
            $nomesOrdenacao[$codigo] = $dados['nome'];
        }

        asort($nomesOrdenacao);

        foreach ($nomesOrdenacao as $codigo => $nomeOrdenado) {
            $nome  = $produtos[$codigo]['nome'];
            $preco = number_format($produtos[$codigo]['preco'], 2, ',', '.');
            echo "<p>Código: $codigo | Nome: $nome | Preço: R$ $preco</p>";
        }
    }

    include("rodape.php");
?>
