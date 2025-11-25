<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";

// ● Exibir mensagens de status
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'cad_ok') {
        echo '<div class="alert alert-success">Animal cadastrado com sucesso!</div>';
    } elseif ($_GET['status'] == 'edit_ok') {
        echo '<div class="alert alert-success">Animal editado com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_ok') {
        echo '<div class="alert alert-success">Animal excluído com sucesso!</div>';
    } elseif ($_GET['status'] == 'del_erro') {
        echo '<div class="alert alert-danger">Não é possível excluir este animal, pois ele está vinculado a uma adoção.</div>';
    }
}

// ● Exclusão
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];

    try {
        $stmt = $pdo->prepare("DELETE FROM animal WHERE ani_id = ?");
        $stmt->execute([$id]);
        header("Location: listar_excluir_animal.php?status=del_ok");
        exit;
    } catch (PDOException $e) {
        header("Location: listar_excluir_animal.php?status=del_erro");
        exit;
    }
}

// ● Listagem de animais
$sql = "
    SELECT a.*, o.ong_nome, ad.adot_nome
      FROM animal a
      JOIN ong o ON o.ong_id = a.ong_id
 LEFT JOIN adotante ad ON ad.adot_id = a.adot_id
  ORDER BY a.ani_id DESC
";
$stmt = $pdo->query($sql);
$animais = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Animais</h2>

<a href="cadastrar_animal.php" class="btn btn-success mb-3">Novo Animal</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Nome</th>
            <th>Fase da vida</th>
            <th>Sexo</th>
            <th>ONG</th>
            <th>Adotante</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($animais as $a): ?>
        <tr>
            <td><?= $a['ani_id'] ?></td>
            <td><?= htmlspecialchars($a['especie']) ?></td>
            <td><?= htmlspecialchars($a['raça']) ?></td>
            <td><?= htmlspecialchars($a['nome']) ?></td>
            <td><?= htmlspecialchars($a['fase_vida']) ?></td>
            <td><?= htmlspecialchars($a['sexo']) ?></td>
            <td><?= htmlspecialchars($a['ong_nome']) ?></td>
            <td><?= $a['adot_nome'] ? htmlspecialchars($a['adot_nome']) : '-' ?></td>
            <td>
                <a href="editar_animal.php?id=<?= $a['ani_id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="listar_excluir_animal.php?excluir=<?= $a['ani_id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirma excluir este animal?');">
                   Excluir
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "rodape.php"; ?>
