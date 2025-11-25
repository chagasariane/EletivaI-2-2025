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
    $stmt = $pdo->prepare("SELECT * FROM adotante WHERE adot_id = ?");
    $stmt->execute([$id]);
    $adotante = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$adotante) {
        echo "<p class='text-danger'>Adotante não encontrado.</p>";
        require __DIR__ . "/rodape.php";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao consultar adotante.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = trim($_POST['nome'] ?? '');
    $telefone  = trim($_POST['telefone'] ?? '');
    $cpf       = trim($_POST['cpf'] ?? '');

    try {
        $stmt = $pdo->prepare("
            UPDATE adotante
               SET adot_nome = ?, adot_telefone = ?, adot_cpf = ?
             WHERE adot_id = ?
        ");
        $ok = $stmt->execute([$nome, $telefone, $cpf, $id]);
        header("Location: listar_excluir_adotante.php?editar=" . ($ok ? 1 : 0));
        exit;
    } catch (PDOException $e) {
        echo "<p class='text-danger'>Erro ao editar adotante.</p>";
    }
}
?>

<h1>Editar Adotante</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome completo</label>
        <input type="text" id="nome" name="nome" class="form-control" required
               value="<?= htmlspecialchars($adotante['adot_nome']) ?>">
    </div>
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" id="telefone" name="telefone" class="form-control"
               value="<?= htmlspecialchars($adotante['adot_telefone']) ?>">
    </div>
    <div class="mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" id="cpf" name="cpf" class="form-control" required
               value="<?= htmlspecialchars($adotante['adot_cpf']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_adotante.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
