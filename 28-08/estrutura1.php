

<?php

    include("cabecalho.php");

    $valor = 10;
    //operadores >  <  >=  <=  !=  ==  ===
    // &&-e  ||-ou  !-não
    if(($valor > 20) && ($valor < 20)){
        echo "Valor maior que 20!";
    } else {
        echo "Valor menor ou igual a 20!";
    }

    include("rodape.php");
?>

   