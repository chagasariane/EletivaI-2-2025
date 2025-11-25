<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit;
}

require "cabecalho.php";
require "conexao.php";
?>

<h1 class="mb-4">Bem-vindo ao Lar Amigo, <?= htmlspecialchars($_SESSION['nome']) ?> 🐾</h1>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-heart-pulse"></i> Animais</h5>
                <p>Gerencie os animais disponíveis.</p>
                <a href="listar_excluir_animal.php" class="btn btn-primary btn-sm">Acessar</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Adotantes</h5>
                <p>Cadastre e edite adotantes.</p>
                <a href="listar_excluir_adotante.php" class="btn btn-primary btn-sm">Acessar</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> ONGs</h5>
                <p>Gerencie ONGs parceiras.</p>
                <a href="listar_excluir_ong.php" class="btn btn-primary btn-sm">Acessar</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-house-heart"></i> Adoções</h5>
                <p>Registre e acompanhe adoções.</p>
                <a href="adocao.php" class="btn btn-primary btn-sm">Acessar</a>
            </div>
        </div>
    </div>

</div>

<?php
// Consulta para o gráfico: adoções por espécie
$stmt = $pdo->query("
    SELECT especie, COUNT(*) AS total
      FROM animal
     WHERE adot_id IS NOT NULL
  GROUP BY especie
");
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$valores = [];

foreach ($dados as $d) {
    $labels[] = $d['especie'];
    $valores[] = (int)$d['total'];
}
?>

<?php if (!empty($dados)): ?>
<div class="card mt-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body">
        <h5 class="card-title mb-3">Adoções por espécie</h5>
        <div style="height: 220px;">
            <canvas id="graficoAdoes"></canvas>
        </div>
    </div>
</div>
<?php endif; ?>

<a href="logout.php" class="btn btn-outline-danger mt-4">
    <i class="bi bi-box-arrow-left"></i> Sair
</a>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoAdoes');

<?php if (!empty($dados)): ?>
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            data: <?= json_encode($valores) ?>,
            backgroundColor: '#ff9f43',
            borderRadius: 10,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // respeita a altura do container
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});
<?php endif; ?>
</script>

<?php require "rodape.php"; ?>
