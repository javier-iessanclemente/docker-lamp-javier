<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 2: Arrays</title>
    <style>
        table, tr, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Actividad 2: Arrays</h1>
    <h2>Punto 1: Uso de Arrays</h2>
    <h3>Alamacenamiento e Impresión de los 10 primeros números pares: </h3>
    <?php
        $x= 0;
        $pares= [];
        for($i= 0; count($pares) < 10; $i++) {
            if($i % 2 == 0) {
                $pares[$x]= $i;
                $x++;
            }
        }
        $x= 1;
        #echo 'Array creado: ' . $pares[1];
        foreach ($pares as $par) {
            echo 'Par nº'. $x  . ': ' .  $par . '<br>';
            $x++;
        }
    ?>
    <h3>Impresión del contenido del array asociativo: </h3>
    <?php 
        $v[1]=90;
        $v[10] = 200;
        $v['hola']=43;
        $v[9]='e';
        $x= 1;
        foreach ($v as $valor) {
            echo 'Valor nº'. $x . ': '. $valor . '<br>';
            $x++;
        }
    ?>
    <h2>Punto 2: Arrays Multidimensionales</h2>
    <?php
    $usuarios= [
    [
        "usuario" => "Jonh",
        "info" => [
            "email" => "john@demo.com", 
            "website" => "www.john.com", 
            "age" => 22,
            "password" => "pass"]
    ],
    [
        "usuario" => "Anna",
        "info" => [ 
            "email" => "anna@demo.com", 
            "website" => "www.anna.com", 
            "age" => 24,
            "password" => "pass"
        ]
    ],
    [
        "usuario" => "Peter",
        "info" => [ 
            "email" => "peter@mail.com", 
            "website" => "www.peter.com", 
            "age" => 42,
            "password" => "pass"
        ]
    ],
    [
        "usuario" => "Max",
        "info" => [ 
            "email" => "max@mail.com", 
            "website" => "www.max.com", 
            "age" => 33,
            "password" => "pass"
        ]
    ]
    ];
    foreach ($usuarios as $usuario) {
        echo 'Usuario: '. $usuario["usuario"] . '<br>';
        echo 'Email: '. $usuario["info"]["email"] . '<br>';
        echo 'Website: '. $usuario["info"]["website"] . '<br>';
        echo 'Age: '. $usuario["info"]["age"] . '<br>';
        echo 'Password: '. $usuario["info"]["password"] . '<br><br>';
    }
    ?>
    <h2>Punto 3: Uso de arrays</h2>
    <h3>Creación e impresión de matriz aleatoria: </h3>
    <?php
    $matriz= [];
    for ($i=0; $i < 30; $i++) {
        $matriz[] = rand(0, 20);
    }
    $x= 1;
    foreach($matriz as $num) {
        echo 'Nº'. $x . ': ' . $num . '<br>';
        $x++;
    }
    ?>
    <h3>Creación e modificación de matriz de cadenas: </h3>
    <?php
    $matrizCadena= ["Batman", "Superman", "Krusty", "Bob", "Mel", "Barney"];
    unset($matrizCadena[(count($matrizCadena) - 1)]);
    echo 'Posición de la cadena Superman: ' . array_keys($matrizCadena, "Superman")[0] . '<br>';
    array_push($matrizCadena, "Carl", "Lenny", "Burns", "Lisa");
    sort($matrizCadena);
    $x= 1;
    foreach($matrizCadena as $cadena) {
        echo "Cadena nº" . $x . ': ' . $cadena . '<br>';
        $x++;
    }
    echo '<br>';
    array_unshift($matrizCadena, "Apple", "Melon", "Watermelon");
    $x= 1;
    foreach($matrizCadena as $cadena) {
        echo "Cadena nº" . $x . ': ' . $cadena . '<br>';
        $x++;
    }
    ?>
    <h3>Creación de la copia de la matriz e impresión de la copia: </h3>
    <?php 
    $copia= array_slice($matrizCadena, 2, 3);
    $copia[]= "Pera";
    $x= 1;
    foreach($copia as $cadena) {
        echo "Cadena nº" . $x . ': ' . $cadena . '<br>';
        $x++;
    }
    ?>
    <h2>Punto 4: Uso de arrays e Strings</h2>
    <?php
    $informacion = "Tokyo,Japan,Asia;Mexico City,Mexico,North America;New York City,USA,North America;Mumbai,India,Asia;Seoul,Korea,Asia;Shanghai,China,Asia;Lagos,Nigeria,Africa;Buenos Aires,Argentina,South America;Cairo,Egypt,Africa;London,UK,Europe";
    echo '<table>
        <tr>
            <th>Ciudad</th>
            <th>Pais</th>
            <th>Contienente</th>
        </tr>';
    $informacionSeparado= explode(";", $informacion);
    foreach($informacionSeparado as $fila) {
        $fila_array= explode(",", $fila);
        echo '
        <tr>
            <td>' . $fila_array[0] . '</td>
            <td>'. $fila_array[1] . '</td>
            <td>' . $fila_array[2] . '</td>
        </tr>';
    }
    echo '</table>';
    ?>
</body>
</html>