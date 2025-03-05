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
        require_once('../utils.php');
        if(!esAdmin()) {
            header("Location: ../index.php?redirigido=true");
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
            include_once('../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Actualizar usuario</h2>
                    <?php
                            if(isset($_SESSION['error']) && isset($_SESSION['mensajes'])) {
                                foreach($_SESSION['mensajes'] as $mensaje) {
                                    echo '<div class="'. ($_SESSION['error'] ? 'alert alert-danger' : 'alert alert-success') . '" role="alert">' . $mensaje . '</div>';
                                }
                                unset($_SESSION['error']);
                                unset($_SESSION['mensajes']);
                            }
                        }
                    }
                    ?>
                </div>

                <div class="container justify-content-between">
                    <form action="editaUsuario.php" method="POST" class="mb-5 w-50">
                        <?php
                        require_once('../modelo/pdo.php');
                        if (!empty($_GET))
                        {
                            $id = $_GET['id'];
                            $usuario= new Usuario();
                            $usuario->setId($id);
                            $usuario = buscaUsuario($usuario);
                            if (!empty($id) && $usuario)
                            {
                                $nombre = $usuario->getNombre();
                                $apellidos = $usuario->getApellidos();
                                $username = $usuario->getUsername();
                                $rol= $usuario->getRol();
                        ?>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <?php include_once('formUsuario.php'); ?>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" >
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <option value="" <?php echo isset($rol) ? '' : 'selected' ?> disabled>Seleccione el rol</option>
                                    <option value="normal" <?php echo isset($rol) && $rol == 0 ? 'selected' : '' ?> >Normal</option>
                                    <option value="administrador" <?php echo isset($rol) && $rol == 1 ? 'selected' : '' ?> >Administrador</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        <?php
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información del usuario.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de usuarios.</div>';
                        }
                        ?>
                    </form>

                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>
    
</body>
</html>
