<?php

    $dominio = "mysql:host=localhost;dbname=projetophp"; // PDO - aponta para o objeto/classe interna que vai  manipular os dados no banco de dados
    $usuario = "root";
    $senha = "";

    try{
        $pdo = new PDO($dominio, $usuario, $senha);
    } catch(Exception $e){
        die("Erro ao concetar ao banco!".$e->getMessage());
    }
?>