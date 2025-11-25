<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

$mensagem = "";

// Exibir mensagens de ações
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'cad_ok') {
        echo '<div class="alert alert-success">ONG cadastrada com sucesso!</div>';
    } elseif ($_GET['status'] == 'edit_ok') {
        echo '<div class="alert alert-success">ONG editada com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_ok') {
        echo '<div class="alert alert-success">ONG excluída com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_erro') {
        echo '<div class="alert alert-danger">Não é possível excluir esta ONG, pois ela está vinculada a animais ou adoções.</div>';
    }
}

// Exclusão
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];

    try {
        $stmt = $pdo->prepare("DELETE FROM ong WHERE ong_id = ?");
        $stmt->execute([$id]);
        header("Location: listar_excluir_ong.php?status=del_ok");
        exit;
    } catch (PDOException $e) {
        header("Location: listar_excluir_ong.php?status=del_erro");
        exit;
    }
}

// Listagem
$stmt = $pdo->query("SELECT * FROM ong ORDER BY ong_nome");
$ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>ONGs Cadastradas</h2>

<a href="cadastrar_ong.php" class="btn btn-success mb-3">Nova ONG</a>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ongs as $o): ?>
        <tr>
            <td><?= $o['ong_id'] ?></td>
            <td><?= htmlspecialchars($o['ong_nome']) ?></td>
            <td><?= htmlspecialchars($o['ong_cnpj']) ?></td>
            <td>
                <a href="editar_ong.php?id=<?= $o['ong_id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="listar_excluir_ong.php?excluir=<?= $o['ong_id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirma excluir esta ONG?');">
                   Excluir
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "rodape.php"; ?>
