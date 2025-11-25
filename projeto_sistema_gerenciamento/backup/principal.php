<?php
session_start();

if (empty($_SESSION['idusuario']) || empty($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/cabecalho.php";
?>
<h1 class="mb-4">Seja bem-vindo ao Lar Amigo, <?= htmlspecialchars($_SESSION['nome']) ?> 🐶💛</h1>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-heart-pulse"></i> Animais</h5>
                <p class="card-text">Gerencie o cadastro de animais disponíveis para adoção.</p>
                <a href="listar_excluir_animal.php" class="btn btn-sm btn-primary">Ir para animais</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Adotantes</h5>
                <p class="card-text">Cadastre e acompanhe os adotantes.</p>
                <a href="listar_excluir_adotante.php" class="btn btn-sm btn-primary">Ir para adotantes</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> ONGs</h5>
                <p class="card-text">Gerencie as ONGs responsáveis pelos animais.</p>
                <a href="listar_excluir_ong.php" class="btn btn-sm btn-primary">Ir para ONGs</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-house-heart"></i> Adoções</h5>
                <p class="card-text">Registre e acompanhe as adoções.</p>
                <a href="adocao.php" class="btn btn-sm btn-primary">Ir para adoções</a>
            </div>
        </div>
    </div>
</div>

<hr>
<a href="logout.php" class="btn btn-outline-danger btn-sm">
    <i class="bi bi-box-arrow-right"></i> Sair
</a>
<?php
require __DIR__ . "/rodape.php";
