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
        $stmt = $pdo->prepare("DELETE FROM ong WHERE ong_id = ?");
        $ok = $stmt->execute([$id]);
        header("Location: listar_excluir_ong.php?excluir_ok=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $mensagem = "<p class='text-danger'>Não é possível excluir esta ONG, pois ela está vinculada a animais ou adoções.</p>";
        } else {
            $mensagem = "<p class='text-danger'>Erro ao excluir ONG.</p>";
        }
    }
}

// LISTAGEM
try {
    $stmt = $pdo->query("SELECT * FROM ong ORDER BY ong_nome");
    $ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao consultar ONGs.</p>";
    $ongs = [];
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

<h2>ONGs</h2>
<a href="cadastrar_ong.php" class="btn btn-success mb-3">Nova ONG</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CNPJ</th>
            <th class="no-print">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ongs as $o): ?>
            <tr>
                <td><?= $o['ong_id'] ?></td>
                <td><?= htmlspecialchars($o['ong_nome']) ?></td>
                <td><?= htmlspecialchars($o['ong_cnpj']) ?></td>
                <td class="no-print d-flex gap-2">
                    <a href="editar_ong.php?id=<?= $o['ong_id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="listar_excluir_ong.php?excluir=<?= $o['ong_id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Confirma excluir esta ONG?');">
                       Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require __DIR__ . "/rodape.php";
