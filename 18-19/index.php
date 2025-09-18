<?php

    $valor = array(1,2,3,4,5);
    echo "<p>Primeiro valor do vetor: ".$valor[0]."</p>";
    //$v = $_POST['name'];

    $vator = [1,2,3,4,5];
    //Função para exibir valores do vetor
    var_dump($vetor);
    echo "<br/>";
    print_r($vetor);

    $vetor[4] = 6;
    echo "<p>Novo valor da posição 4: ".$vetor[4]."</p>";

    $v = "nome";
    $vetor[$v] = "Ariane";
    print_r($vetor);

    $valor = [
        'nome' => "Ariane",
        'sobrenome' => "Chagas",
        'idade' => "27"
    ];

    foreach($valores as $c => $v){
        echo "<p>Posição: $c = Valor: $v</p>";
    }

?>