<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4.Funciones</title>
</head>
<body>
    <h1>4.Funciones</h1>
    <h2>Tarea 1: Uso de funciones</h2>
    <h3>Paso 1: Función que recibe un carácter y imprime si el carácter es un dígito entre 0 y 9</h3>
    <p>
        <?php
        function imprimeDigito($caracter) {
            if(is_numeric($caracter)) {
                if($caracter > 0 && $caracter < 9) {
                    echo 'Resultado de la función para '. $caracter . ': Es un número entre 0 y 9.<br>';
                }
                else {
                    echo 'Resultado de la función para '. $caracter . ': No es un número entre 0 y 9.<br>';
                }
            }
            else {
                echo 'Resultado de la función para '. $caracter . ': No es un número.<br>';
            }
        }
        imprimeDigito(1);
        imprimeDigito(9);
        imprimeDigito(10);
        imprimeDigito(-1);
        imprimeDigito('gato');
        ?>
    </p>
    <h3>Paso 2: Función que recibe un string y devuelve su longitud</h3>
    <p>
        <?php
        function devolverLongitud($cadena) {
            echo 'La longitud del string '. $cadena . ' es: '. strlen($cadena) . '<br>';
        }
        devolverLongitud("perro");
        devolverLongitud("supercalifragilisticoesperalidoso");
        devolverLongitud(12);
        devolverLongitud(9.5);
        ?>
    </p>
    <h3>Paso 3: Función que recibe dos números a y b y devuelve el número a elevado a b</h3>
    <p>
        <?php
        function realizarPotencia($a, $b) {
            $pow= 1;
            if(is_numeric($a) && is_numeric($b)) {
                for ($i= 0; $i < $b; $i++) {
                    $pow*= $a;
                }
                echo $a . ' elevado a ' . $b . ' es igual a ' . $pow . '.<br>';
            }
            else {
                if(!is_numeric($a) && !is_numeric($b) && $a != null && $b != null) {
                    echo $a . " y " . $b . ' no son números.<br>';
                }
                else {
                    if($a == null && $b == null) {
                        echo "Ambos números son nulos.<br>";
                    }
                    else {
                        if(!is_numeric($a) && $a != null) {
                            echo $a . ' no es un número.<br>';
                        } 
                        else {
                            if($a == null) {
                                echo "El primer número es nulo.<br>";
                            }
                            if(!is_numeric($b) && $b != null) {
                                echo $b . ' no es un número.<br>';
                            } 
                            else {
                                if($b == null) {
                                    echo "El segundo número es nulo.<br>";
                                }
                            }
                        }
                    }
                }
            }
        }
        realizarPotencia(2,2);
        realizarPotencia(3,3);
        realizarPotencia("2","4");
        realizarPotencia("gato", "perro");
        realizarPotencia("gato", 2);
        realizarPotencia(3, "perro");
        realizarPotencia(null, null);
        realizarPotencia(null, "g");
        realizarPotencia(2, null);
        ?>
    </p>
    <h3>Paso 4: Función que reciba un carácter y devuelva true si el carácter es una vocal</h3>
    <p>
        <?php 
        function esVocal($caracter) {
            if(strlen($caracter) == 1 && preg_match('/[aeiouáéíóú]/ui', $caracter)) {
                return true;
            }
            return false;
        }
        $i= 0;
        $datos= ["a", "E", "í", "Ó", "gato"];
        while($i < count($datos)) {
            if(esVocal($datos[$i])) {
                echo "El texto " . $datos[$i] . ' es una vocal <br>';
            }
            else {
                echo "El texto " . $datos[$i] . ' no es una vocal <br>';
            }
            $i++;
        }
        ?>
    </p>
    <h3>Paso 5: Función que recibe un número y devuelve si el número es par o impar</h3>
    <p>
        <?php
        function esPar($numero) {
            if(is_numeric($numero)) {
                if(fmod($numero, 2) == 0) {
                    return "Par";
                }
                else {
                    return "Impar";
                }
            }
            else {
                return "No número";
            }
        }
        $i= 0;
        $datos= ["10", "1", "-1", "-12", "g", 4.11, 4.42];
        while($i < count($datos)) {
            echo 'Resultado para '. $datos[$i] . ' es: '. esPar($datos[$i]). '<br>';
            $i++;
        }
        ?>
    </p>
    <h3>Paso 6: Función que recibe un string y devuelve el string en maiúsculas</h3>
    <p>
        <?php
            function convertirMayúsculas($cadena) {
                return strtoupper($cadena);
            }
            $i= 0;
            $datos= ["10", "gato", "Paco", "HOLA", "Hola, soy Juán"];
            while($i < count($datos)) {
                echo 'La cadena en mayúsculas de '. $datos[$i] . ' es: '. convertirMayúsculas($datos[$i]). '<br>';
                $i++;
            }
        ?>
    </p>
    <h3>Paso 7: Función que imprime la zona horaria (timezone) por defecto utilizada en PHP</h3>
    <p>
    <?php
        function imprimirZonaHoraria() {
            $timezone= date_default_timezone_get();
            echo 'Zona horaria: '. $timezone;
        }
        imprimirZonaHoraria();
    ?>
    </p>
    <h3>Paso 8: Función que imprime la hora a la que sale y se pone el sol para la localicación por defecto (Se Debe comprobar como ajustar las coordenadas (latitud y longitud) predeterminadas de tu servidor).</h3>
    <p>
        <?php
            date_sunrise()
            date_sunset()
        ?>
    </p>
</body>
</html>