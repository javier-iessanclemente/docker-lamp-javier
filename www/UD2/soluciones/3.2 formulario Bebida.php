<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado formulario bebida</title>
</head>
<body>
    <p>
    <?php 
    $opcion= $_POST["opcion"];
    $cantidad= $_POST["cantidad"];
    $mensaje= "";
    $precio= 0;
    switch ($opcion) {
        case 'cocacola':
            $mensaje= "Coca Cola";
            $precio= 1;
            break;
        case 'pepsi':
            $mensaje= "Pepsi Cola";
            $precio= 0.80;
            break;
        case 'fanta':
            $mensaje= "Fanta Naranja";
            $precio= 0.90;
            break;
        case 'trina':
            $mensaje= "Trina Manzana";
            $precio= 1.30;
            break;
        default:
            $mensaje= "Error: Selecionada opción no implementada.";
            break;
    }
    if($precio == 0) {
        echo $mensaje;
    }
    else {
        echo 'Pediste '. $cantidad . ' botellas de '. $mensaje . '. Precio total a pagar: '. ($precio * $cantidad) . ' Euros.';
    }
    ?>
    </p>
</body>
</html>