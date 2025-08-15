<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeiro exemplo</title>
</head>
<body>
    <?php //delimitador padrão do PHP e "<?= ? sinal de maior delimitador contraido"
        $dia = date("d");

        echo "<p>" . $dia . "</p>"; // o "." concatena, igual o + em C#
        echo "<p> $dia </p>" //exbir variável com $variavel
    ?>
    <h1>Hoje é dia <?= $dia ?> de Agosto de 2025</h1>
    
</body>
</html>