<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

$id = (int) ($_GET['id'] ?? 0);

try {
    $stmt = $pdo->prepare("SELECT * FROM ong WHERE ong_id = ?");
    $stmt->execute([$id]);
    $ong = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$ong) {
        echo "<p class='text-danger'>ONG não encontrada.</p>";
        require __DIR__ . "/rodape.php";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao consultar ONG.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');

    try {
        $stmt = $pdo->prepare("UPDATE ong SET ong_nome = ?, ong_cnpj = ? WHERE ong_id = ?");
        $ok = $stmt->execute([$nome, $cnpj, $id]);
        header("Location: listar_excluir_ong.php?editar=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        echo "<p class='text-danger'>Erro ao editar ONG.</p>";
    }
}
?>

<h1>Editar ONG</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da ONG</label>
        <input type="text" id="nome" name="nome" class="form-control" required
               value="<?= htmlspecialchars($ong['ong_nome']) ?>">
    </div>
    <div class="mb-3">
        <label for="cnpj" class="form-label">CNPJ</label>
        <input type="text" id="cnpj" name="cnpj" class="form-control" required
               value="<?= htmlspecialchars($ong['ong_cnpj']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_ong.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
