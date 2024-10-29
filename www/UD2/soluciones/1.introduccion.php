<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 1: Introducción</title>
</head>
<body>
    <h1>Actividad 1: Introducción</h1>
    <h2>Punto 1: PHP con los errores corregidos</h2>
    <?php
    echo '¿Cómo estás? ';
    echo 'Estoy bien, gracias.';
    ?>
    <h2>Punto 2: Lista de nombres validos e invalidos</h2>
    <ol>
        <li>- valor: No es valido. No incluye $ al principio.</li>
        <li>- $_N: Es valido. Porque inclye $ al principo y empieza por _ que es un caracter valido.</li>
        <li>- $valor_actual: Es valido. Porque empieza por $ y el _ se puede incluir.</li>
        <li>- $n: Es valido. Porque empieza por $ y el _ se puede incluir.</li>
        <li>- $#datos: No es valido. Porque el nombre tras $ debe empezar por _ o una letra.</li>
        <li>- $valorInicial0: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $proba,valor: No es valido. Porque no puede contener el caracter ,.</li> 
        <li>- $2saldo: No es valido. Porque el nombre tras $ debe empezar por _ o una letra.</li>
        <li>- $n: Es valido. Porque el nombre empieza por $ y tras este empieza por una letra.</li>
        <li>- $meuProblema: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $meu Problema: No es valido. Porque el nombre no puede contener espacios.</li>
        <li>- $echo: No es valido. Porque el nombre puede confundirse con la sentencia echo.</li>
        <li>- $m&m: No es valido. Porque el caracter & no se puede usar.</li>
        <li>- $registro: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $ABC: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $85 Nome: No es valido. Porque el nombre tras $ empieza por un numero y contiene espacios.</li>
        <li>- $AAAAAAAAA: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $nome_apelidos: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $saldoActual: Es valido. Porque empieza por $ y los caracteres usados estan permitidos.</li>
        <li>- $92: No es valido. Porque tras $ empieza por un número y solo inclye números.</li>
        <li>- $*143idade: No es valido. Porque el nombre tras $ debe empezar por _ o una letra.</li>
    </ol>
    <h2>Punto 3: Prueba de la devolución del código PHP</h2>
    <?php
    $a = "true"; // imprime el valor devuelto por is_bool($a)...
    echo is_bool($a);
    echo "<br/>";
    $b = 0; // imprime el valor devuelto por is_bool($b)...; y se entra dentro de if($b) {...}
    echo is_bool($b);
    echo "<br/>";
    $c = "false"; // imprime el valor devuelto por gettype($c);
    echo gettype($c);
    echo "<br/>";
    $d = ""; // el valor devuelto por empty($d);
    echo empty($d);
    echo "<br/>";
    $e = 0.0; // el valor devuelto por empty($e);
    echo empty($e);
    echo "<br/>";
    $f = 0; // el valor devuelto por empty($f);
    echo empty($f);
    echo "<br/>";
    $g = false; // el valor devuelto por empty($g);
    echo empty($g);
    echo "<br/>";
    $h; // el valor devuelto por empty($h);
    echo empty($h);
    echo "<br/>";
    $i = "0"; // el valor devuelto por empty($i);
    echo empty($i);
    echo "<br/>";
    $j = "0.0"; // el valor devuelto por empty($j);
    echo empty($j);
    echo "<br/>";
    $k = true; // el valor devuelto por isset($k);
    echo isset($k);
    echo "<br/>";
    $l = false; // el valor devuelto por isset($l);
    echo isset($l);
    echo "<br/>";
    $m = true; // el valor devuelto por is_numeric($m);
    echo is_numeric($m);
    echo "<br/>";
    $n = ""; // el valor devuelto por is_numeric($n);
    echo is_numeric($n);
    echo "<br/>";
    ?>
    <h2>Punto 4: Muestra de las variables con phpinfo()</h2>
    <?php 
    phpinfo();
    ?>
    <h2>Punto 5: Programas que usan operadores</h2>
    <h3>Conversión de Farenheit a Celisius: </h3>
    <?php
    $farenheit= 100;
    echo 'Grados farenheit: ' . $farenheit . '<br/>';
    $celsius= (($farenheit - 32) * 5)/9;
    echo 'Grados celsisus: ' . $celsius;
    ?>
    <h3>Operaciones con variables: </h3>
    <h4>Versión 1: Con nuevas variables.</h4>
    <?php
    $x= 20;
    $y= 10;
    $suma= $x + $y;
    echo 'Suma de x e y: ' . $suma . '<br/>';
    $resta= $x - $y;
    echo 'Resta de x e y: ' . $resta . '<br/>';
    $multiplicacion= $x * $y;
    echo 'Multiplicación de x e y: ' . $multiplicacion . '<br/>';
    $division= $x/$y;
    echo 'División de x e y: ' . $division . '<br/>';
    $modulo= $x % $y;
    echo 'Módulo de x e y: ' . $modulo . '<br/>';
    ?>
    <h4>Versión 2: Sin nuevas variables.</h4>
    <?php
    $x= 20;
    $y= 10;
    echo 'Suma de x e y: ' . ($x + $y) . '<br/>';
    echo 'Resta de x e y: ' . ($x - $y) . '<br/>';
    echo 'Multiplicación de x e y: ' . ($x * $y) . '<br/>';
    echo 'División de x e y: ' . ($x/$y) . '<br/>';
    echo 'Módulo de x e y: ' . ($x % $y) . '<br/>';
    ?>
    <h3>Impresión de los cuadrados de los 20 primeros números naturales: </h3>
    <?php
    for ($i= 1; $i <=20; $i++) {
        echo 'Cuadrado nº'. $i . ': ' . ($i*$i) . '<br>';
    }
    ?>
    <h3>Cálculo de perímetero y área de un rectángulo: </h3>
    <?php 
    $base= 20;
    $altura= 10;
    $area= $base * $altura;
    $perimetro= (2* $base) + (2* $altura);
    echo 'Base: ' . $base . '<br>';
    echo 'Altura: ' . $altura . '<br>';
    echo 'Área: ' . $area . '<br>';
    echo 'Perímetro: ' . $perimetro . '<br>';
    ?>
    <h2>Punto 6: Programas con cadenas</h2>
    <h3>Impresión de hola mundo en cursiva: </h3>
    <?php
    echo "<i>Hola, Mundo!</i>"
    ?>
    <h3>Impresión de mensaje de bienvenida: </h3>
    <?php
    $nombre= "Javier";
    echo '<b>Bienvenido ' . $nombre . '</b>';
    ?>
</body>
</html>