<?php
session_start();

// Se não estiver logado, volta pro index (que depois será seu login)
if (!isset($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

require("cabecalho.php");
?>
    <h1>Seja Bem-vindo ao Lar Amigo, <?= htmlspecialchars($_SESSION['nome']) ?></h1>
    <h6><a href="logout.php">Sair</a></h6>
<?php
require("rodape.php");
?>

<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
