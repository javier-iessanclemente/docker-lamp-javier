<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?php echo isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD4. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('./vista/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Iniciar sesión</h2>
                    <?php
                        if(isset($_SESSION['error']) && isset($_SESSION['mensajes'])) {
                            foreach($_SESSION['mensajes'] as $mensaje) {
                                echo '<div class="'. ($_SESSION['error'] ? 'alert alert-danger' : 'alert alert-success') . '" role="alert">' . $mensaje . '</div>';
                            }
                            unset($_SESSION['error']);
                            unset($_SESSION['mensajes']);
                        }
                    ?>
                </div>

                <div class="container justify-content-between">
                    <form action="./controlador/loginAuth.php" method="POST" class="mb-5 w-50">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" >
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <?php include_once('./vista/footer.php'); ?>
</body>
</html>
