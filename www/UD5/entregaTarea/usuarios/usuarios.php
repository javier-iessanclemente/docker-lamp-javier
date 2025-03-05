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
    }
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
            include_once('../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Usuarios</h2>
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
                <?php
                    require_once('../modelo/pdo.php');
                    require_once(__DIR__ . '/../modelo/Usuario.php');
                    $resultado = listaUsuarios();
                    if ($resultado[0])
                    {
                ?>
                    <div class="table">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="thead">
                                <tr>                            
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $usuarios = $resultado[1];
                                    if (count($usuarios) > 0)
                                    {
                                        foreach ($usuarios as $usuario)
                                        {
                                            echo '<tr>';
                                            echo '<td>' . $usuario->getId() . '</td>';
                                            echo '<td>' . $usuario->getNombre() . '</td>';
                                            echo '<td>' . $usuario->getApellidos() . '</td>';
                                            echo '<td>' . $usuario->getUsername() . '</td>';
                                            if($usuario->getRol() == 0) {
                                                echo '<td>Normal</td>';
                                            }
                                            elseif($usuario->getRol() == 1) {
                                                echo '<td>Administrador</td>';
                                            }
                                            echo '<td>';
                                            echo '<a class="btn btn-sm btn-outline-success" href="editaUsuarioForm.php?id=' . $usuario->getId() . '" role="button">Editar</a>';
                                            echo '<a class="btn btn-sm btn-outline-danger ms-2" href="borraUsuario.php?id=' . $usuario->getId() . '" role="button">Borrar</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="100">No hay usuarios</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                    }
                    else
                    {
                        echo '<div class="alert alert-warning" role="alert">' . $resultado[1] . '</div>';
                    }
                ?>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>
    
</body>
</html>
