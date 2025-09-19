<?php
    $nome = "Ariane";

    echo "<p>Todas em maiúsculo: ".strtoupper($nome)."</p>";
    echo "<p>Todas em minúscula: ".strtolower($nome)."</p>";
    echo "<p>Qtd. de caracteres: ".strlen($nome)."</p>";

    $posicao = strpos($nome, "e");
    echo "<p>Caractere E na posição $posicao</p>";

    date_default_timezone_set('America/Sao_Paulo'); //para usar o horário certo
    $data1 = date("d/m/Y"); //dia atual de 01 a 31, mes de 01 a 12 e ano com 4 numeros
    $dia = date("d");
    $hora = date("H:i:s");
    echo "<p>Data: $data1</p>";
    echo "<p>Dia: $dia</p>";
    echo "<p>Hora: $hora</p>";
    if (checkdate(2 , 30, 2025)){
        echo "<p>A data informada existe (30/02/2025)</p>";
    } else{
         echo "<p>A data informada não existe (30/02/2025)!</p>";
    }

    $valor = -10;
    echo "<p>Valor absoluto: ".abs($valor)."</p>"; //pegar o número absoluto (sempre positivo)
    $valor = 5.9;
    echo "<p>Valor arredondado: ".round($valor)."</p>";
    $valor = rand(1, 100);
    echo "<p>Valor aleatório: $valor</p>";
    echo "<p>Raiz quadrada de 16: ".sqrt(16)."</p>";
    $valor = 13500;
    echo "<p>Valor formatado: R$".number_format($valor, 2, ",", ".")."</p>"; //duas casas decimais, separador e separador de milha

    function exibirSaudacao(){
        echo "<p>Olá mundo!</p>";
    }
    exibirSaudacao(); // chamar a função

    function exibirSaudacaoComNome($nome){
        echo "<p>Seja bem-vindo(a), $nome!</p>";
    }
    exibirSaudacaoComNome("Ariane"); 

    function menorValor($valor1,$valor2){
        return min($valor1, $valor2);
    }   
    echo "Menor valor entre 4 e 8 é ".menorValor(8,4);

    function somarValores(...$numeros){
        return array_sum($numeros);
    }
    $soma = somarValores(1,2,3,4,5,6);
    echo "<p>A soma dos valores é: $soma</p>";
?>