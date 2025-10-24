<?php
    require("cabecalho.php");
    require("conexao.php");
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        try{
            $stmt = $pdo->query("SELECT * FROM categoria");
            $categorias = $stmt->fetchAll();
            $stmt = $pdo->prepare("SELECT * FROM produto WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            echo "Erro ao consultar categoria".$e->getMessage();
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $id = $_POST['id'];
        $categoria = $_POST['categoria'];
        $valor = $_POST['valor'];
        try{
            $stmt = $pdo->prepare("UPDATE produto SET descricao = ?, valor = ?, categoria_id = ? WHERE id = ?");
            if($stmt->execute([$nome, $id])){
                header('location: produtos.php?editar=true');
            } else
            header('location: produtos.php?editar=false');
        }catch(\Exception $e){
            echo 'Erro: '.$e->getMessage();
        }
    }
?>

    <h1>Editar Produto</h1>
    <form method="post">
    <div class="mb-3">
                <label for="descricao" class="form-label">Informe a descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""></textarea>
                </div><div class="mb-3">
                <label for="valor" class="form-label">Informe o valor</label>
                <input type="number" id="valor" name="valor" class="form-control" required="">
                </div><div class="mb-3">
                <label for="categoria" class="form-label">Selecione a categoria</label>
                <select id="categoria" name="categoria" class="form-select" required="">
                    <option value="Categoria">Categoria</option>
                </select>
                </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

<?php
    require("rodape.php");
?>

