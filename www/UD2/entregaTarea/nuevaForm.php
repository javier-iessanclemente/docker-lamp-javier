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
                    <h2>Formulario de creación de una nueva tarea</h2>
                </div>
                <div class="container">
                    <form action="nueva.php" method="post">
                        <p>Identificador de la tarea: <input type="number" name="id" required/></p>
                        <p>Descripción de la tarea: <input type="text" name="descripcion" required/></p>
                        <p>Estado de la tarea:
                            <select name="estado" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="en proceso">En proceso</option>
                                <option value="completada">Completada</option>
                            </select>
                        </p>
                        <button type="submit">Enviar</button>
                    </form>
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