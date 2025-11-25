<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

$mensagem = "";

// EXCLUSÃO
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    try {
        $stmt = $pdo->prepare("DELETE FROM animal WHERE ani_id = ?");
        $ok = $stmt->execute([$id]);
        header("Location: listar_excluir_animal.php?excluir_ok=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            // Animal vinculado à tabela adocao
            $mensagem = "<p class='text-danger'>Não é possível excluir este animal, pois ele já está vinculado a uma adoção.</p>";
        } else {
            $mensagem = "<p class='text-danger'>Erro ao excluir animal.</p>";
        }
    }
}

// LISTAGEM
try {
    $sql = "
        SELECT a.*, o.ong_nome, ad.adot_nome
          FROM animal a
          JOIN ong o ON o.ong_id = a.ong_id
     LEFT JOIN adotante ad ON ad.adot_id = a.adot_id
      ORDER BY a.ani_id DESC
    ";
    $stmt = $pdo->query($sql);
    $animais = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao consultar animais.</p>";
    $animais = [];
}

// MENSAGENS
if ($mensagem) {
    echo $mensagem;
}
if (isset($_GET['cadastro'])) {
    echo $_GET['cadastro']
        ? "<p class='text-success'>Cadastro realizado!</p>"
        : "<p class='text-danger'>Erro ao cadastrar!</p>";
}
if (isset($_GET['editar'])) {
    echo $_GET['editar']
        ? "<p class='text-success'>Registro editado!</p>"
        : "<p class='text-danger'>Erro ao editar!</p>";
}
if (isset($_GET['excluir_ok'])) {
    echo $_GET['excluir_ok']
        ? "<p class='text-success'>Registro excluído!</p>"
        : "<p class='text-danger'>Erro ao excluir!</p>";
}
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
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($animais as $ani): ?>
            <tr>
                <td><?= $ani['ani_id'] ?></td>
                <td><?= htmlspecialchars($ani['especie']) ?></td>
                <td><?= htmlspecialchars($ani['raça']) ?></td>
                <td><?= htmlspecialchars($ani['nome']) ?></td>
                <td><?= htmlspecialchars($ani['fase_vida']) ?></td>
                <td><?= htmlspecialchars($ani['sexo']) ?></td>
                <td><?= htmlspecialchars($ani['ong_nome']) ?></td>
                <td><?= $ani['adot_nome'] ? htmlspecialchars($ani['adot_nome']) : '-' ?></td>
                <td class="no-print d-flex gap-2">
                    <a href="editar_animal.php?id=<?= $ani['ani_id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="listar_excluir_animal.php?excluir=<?= $ani['ani_id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Confirma excluir este animal?');">
                       Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require __DIR__ . "/rodape.php";
