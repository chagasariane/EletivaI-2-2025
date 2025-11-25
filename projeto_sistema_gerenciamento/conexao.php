<?php
$dsn = "mysql:host=localhost;dbname=projeto;charset=utf8mb4";
$usuario = "root";      
$senha   = "";          

try {
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div style='padding:20px;color:white;background:#c0392b;font-family:Arial;border-radius:8px;'>
            <strong>Erro ao conectar ao banco:</strong> " . $e->getMessage() . "
         </div>");
}
