<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!--header-->
    <?php 
    include("header.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <!--menu-->
            <?php 
            include("menu.php");
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Título del contenido</h2>
                </div>
                <div class="container">
                <?php 
                include_once("utils.php");
                $valido= true;
                $campos= [];
                $num= 0;
                $camposFallidosMensaje= "";
                $esId= true;
                # Bucle que valida cada uno de los campos: 
                foreach ($_POST as $dato) {
                    if(validarCampo($dato, $esId) == false) {
                        $valido= false;
                        if($num == 0) {
                            $campos[] = "Id";
                        }
                        if($num == 1) {
                            $campos[] = "Descripción";
                        }
                        if($num == 2) {
                            $campos[] = "Estado";
                        }
                    }
                    if($num == 0) {
                        $esId= false;
                    }
                    $num++;
                }
                # Estructura if-else que decide el mensaje mostrado y si se guarda la tarea si todos los campos son validos: 
                if($valido) {
                    guardarTarea($_POST["id"], $_POST["descripcion"], $_POST["estado"]);
                    echo 'La tarea ha sido guardada.';
                }
                else {
                    $num= 0;
                    # Bucle que crea el mensaje cuando alguno de los campos falla incluyendo los campos fallidos: 
                    foreach($campos as $campo) {
                        $camposFallidosMensaje = $camposFallidosMensaje. $campo;
                        if($num != count($campos) - 1) {
                            $camposFallidosMensaje= $camposFallidosMensaje . ", ";
                        }
                        else {
                            $camposFallidosMensaje= $camposFallidosMensaje . ".";
                        }
                        $num++;
                    }
                    echo 'La tarea no se puede guardar por fallos en los siguientes campos: '. $camposFallidosMensaje;
                }
                ?>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php 
    include("footer.php");
    ?>
</body>
</html>