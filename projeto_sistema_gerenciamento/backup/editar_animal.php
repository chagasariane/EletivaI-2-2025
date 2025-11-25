<?php
session_start();
if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
require __DIR__ . "/conexao.php";

$id = (int) ($_GET['id'] ?? 0);

// Carregar ONGs
try {
    $stmt = $pdo->query("SELECT ong_id, ong_nome FROM ong ORDER BY ong_nome");
    $ongs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao carregar ONGs.</p>";
    $ongs = [];
}

// Carregar animal
try {
    $stmt = $pdo->prepare("SELECT * FROM animal WHERE ani_id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$animal) {
        echo "<p class='text-danger'>Animal não encontrado.</p>";
        require __DIR__ . "/rodape.php";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro ao consultar animal.</p>";
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
            UPDATE animal
               SET especie = ?, `raça` = ?, nome = ?, fase_vida = ?, sexo = ?, ong_id = ?
             WHERE ani_id = ?
        ");
        $ok = $stmt->execute([$especie, $raca, $nome, $fase_vida, $sexo, $ong_id, $id]);
        header("Location: listar_excluir_animal.php?editar=" . ($ok ? 1 : 0));
        exit;
    } catch (Exception $e) {
        echo "<p class='text-danger'>Erro ao editar animal.</p>";
    }
}
?>

<h1>Editar Animal</h1>
<form method="post">
    <div class="mb-3">
        <label for="especie" class="form-label">Espécie</label>
        <?php $esp = $animal['especie']; ?>
        <select id="especie" name="especie" class="form-select" required>
            <option value="Cachorro" <?= $esp == 'Cachorro' ? 'selected' : '' ?>>Cachorro</option>
            <option value="Gato" <?= $esp == 'Gato' ? 'selected' : '' ?>>Gato</option>
            <option value="Outro" <?= $esp == 'Outro' ? 'selected' : '' ?>>Outro</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="raca" class="form-label">Raça</label>
        <input type="text" id="raca" name="raca" class="form-control" required
               value="<?= htmlspecialchars($animal['raça']) ?>">
    </div>
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do animal</label>
        <input type="text" id="nome" name="nome" class="form-control"
               value="<?= htmlspecialchars($animal['nome']) ?>">
    </div>
    <div class="mb-3">
        <label for="fase_vida" class="form-label">Fase da vida</label>
        <?php $fase = $animal['fase_vida']; ?>
        <select id="fase_vida" name="fase_vida" class="form-select" required>
            <option value="Filhote" <?= $fase == 'Filhote' ? 'selected' : '' ?>>Filhote</option>
            <option value="Adulto" <?= $fase == 'Adulto' ? 'selected' : '' ?>>Adulto</option>
            <option value="Idoso" <?= $fase == 'Idoso' ? 'selected' : '' ?>>Idoso</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="sexo" class="form-label">Sexo</label>
        <?php $sx = $animal['sexo']; ?>
        <select id="sexo" name="sexo" class="form-select" required>
            <option value="Macho" <?= $sx == 'Macho' ? 'selected' : '' ?>>Macho</option>
            <option value="Fêmea" <?= $sx == 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="ong_id" class="form-label">ONG responsável</label>
        <select id="ong_id" name="ong_id" class="form-select" required>
            <?php foreach ($ongs as $o): ?>
                <option value="<?= $o['ong_id'] ?>"
                    <?= $o['ong_id'] == $animal['ong_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($o['ong_nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="listar_excluir_animal.php" class="btn btn-secondary">Voltar</a>
</form>

<?php
require __DIR__ . "/rodape.php";
