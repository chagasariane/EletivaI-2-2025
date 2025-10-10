<?php
    require('cabecalho.php');
?>
    <h1>Seja bem-vindo <?= $_SESSION['nome']?></h1>
    <h6><a href='logout.php'>Sair</h6>
<?php
    require('rodape.php');
?>