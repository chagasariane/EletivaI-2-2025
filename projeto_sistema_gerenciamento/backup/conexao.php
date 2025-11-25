<?php
// conexao.php
$dominio = "mysql:host=localhost;dbname=projeto;charset=utf8mb4";
$usuario = "root";       // ajuste se for diferente
$senha   = "";           // ajuste se houver senha

try {
    $pdo = new PDO($dominio, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro ao conectar ao banco! " . $e->getMessage());
}
