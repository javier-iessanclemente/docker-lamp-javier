<?php
    session_start();
    if(!isset($_SESSION['usuario'])) {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'Debes iniciar sesión para acceder');
        header("Location: ../login.php?redirigido=true");
    }
    else {

    
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?php echo isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD5. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once('../vista/header.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php 
                require_once('../utils.php'); 
                include_once('../vista/menu.php');
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Nuevo archivo</h2>
                    <?php
                        if(isset($_SESSION['error']) && isset($_SESSION['mensajes'])) {
                            foreach($_SESSION['mensajes'] as $mensaje) {
                                echo '<div class="'. ($_SESSION['error'] ? 'alert alert-danger' : 'alert alert-success') . '" role="alert">' . $mensaje . '</div>';
                            }
                            unset($_SESSION['error']);
                            unset($_SESSION['mensajes']);
                        }
                    }
                    ?>
                </div>
                <div class="container justify-content-between">
                    <form action="<?php echo isset($_GET["id"]) ? "subidaFichProc.php?id=" . $_GET["id"] : "";?>" method="POST" class="mb-5 w-50" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Seleccionar archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" accept=".jpg, .jpeg, .png, .pdf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subir archivo</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <?php include_once('../vista/footer.php'); ?>
</body>
</html>