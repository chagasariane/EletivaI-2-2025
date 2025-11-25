<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

// Mensagens de status (Bootstrap)
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'cad_ok') {
        echo '<div class="alert alert-success">Adotante cadastrado com sucesso!</div>';
    } elseif ($_GET['status'] == 'edit_ok') {
        echo '<div class="alert alert-success">Adotante editado com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_ok') {
        echo '<div class="alert alert-success">Adotante excluído com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_erro') {
        echo '<div class="alert alert-danger">Não é possível excluir este adotante, pois ele está vinculado a uma adoção.</div>';
    }
}

// Exclusão
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];

    try {
        $stmt = $pdo->prepare("DELETE FROM adotante WHERE adot_id = ?");
        $stmt->execute([$id]);

        header("Location: listar_excluir_adotante.php?status=del_ok");
        exit;

    } catch (PDOException $e) {
        header("Location: listar_excluir_adotante.php?status=del_erro");
        exit;
    }
}

// Listagem
$stmt = $pdo->query("SELECT * FROM adotante ORDER BY adot_nome");
$adotantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Adotantes</h2>

<a href="cadastrar_adotante.php" class="btn btn-success mb-3">Novo Adotante</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>CPF</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adotantes as $a): ?>
        <tr>
            <td><?= $a['adot_id'] ?></td>
            <td><?= htmlspecialchars($a['adot_nome']) ?></td>
            <td><?= htmlspecialchars($a['adot_telefone']) ?></td>
            <td><?= htmlspecialchars($a['adot_cpf']) ?></td>
            <td>
                <a href="editar_adotante.php?id=<?= $a['adot_id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                <a href="listar_excluir_adotante.php?excluir=<?= $a['adot_id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirma excluir este adotante?');">
                   Excluir
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "rodape.php"; ?>
