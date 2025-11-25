<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

// Carregar ONGs para o select
try {
    $stmt = $pdo->query("SELECT ong_id, ong_nome FROM ong ORDER BY ong_nome");
    $ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao carregar ONGs.</p>";
    $ongs = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especie   = trim($_POST['especie'] ?? '');
    $raca      = trim($_POST['raca'] ?? '');
    $nome      = trim($_POST['nome'] ?? '');
    $fase_vida = trim($_POST['fase_vida'] ?? '');
    $sexo      = trim($_POST['sexo'] ?? '');
    $ong_id    = (int) ($_POST['ong_id'] ?? 0);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO animal (especie, `raça`, nome, fase_vida, sexo, ong_id, adot_id)
            VALUES (?, ?, ?, ?, ?, ?, NULL)
        ");
        $ok = $stmt->execute([$especie, $raca, $nome, $fase_vida, $sexo, $ong_id]);
        header("Location: listar_excluir_animal.php?cadastro=" . ($ok ? 1 : 0));
        exit;
    } catch (Exception $e) {
        echo "<p class='text-danger'>Erro ao cadastrar animal.</p>";
    }
}
?>

<h1>Novo Animal</h1>
<form method="post">
    <div class="mb-3">
        <label for="especie" class="form-label">Espécie</label>
        <select id="especie" name="especie" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outro">Outro</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="raca" class="form-label">Raça</label>
        <input type="text" id="raca" name="raca" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do animal</label>
        <input type="text" id="nome" name="nome" class="form-control">
    </div>
    <div class="mb-3">
        <label for="fase_vida" class="form-label">Fase da vida</label>
        <select id="fase_vida" name="fase_vida" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Filhote">Filhote</option>
            <option value="Adulto">Adulto</option>
            <option value="Idoso">Idoso</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="sexo" class="form-label">Sexo</label>
        <select id="sexo" name="sexo" class="form-select" required>
            <option value="">Selecione...</option>
            <option value="Macho">Macho</option>
            <option value="Fêmea">Fêmea</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="ong_id" class="form-label">ONG responsável</label>
        <select id="ong_id" name="ong_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php foreach ($ongs as $o): ?>
                <option value="<?= $o['ong_id'] ?>"><?= htmlspecialchars($o['ong_nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_animal.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
