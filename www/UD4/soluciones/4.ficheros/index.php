<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3 1.Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Título del contenido</h2>
                </div>
                <div class="container">
                    <?php 
                    require_once("bdaccess.php");
                        try {
                            $conexion= new mysqli("db", "root", "test");
                            $sql="CREATE DATABASE IF NOT EXISTS tienda;";
                            $conexion->query($sql);
                        }
                        catch(mysqli_sql_exception $e) {
                            echo 'Error creado la BD: ' . $e->getMessage() . '<br>';
                        }
                        finally {
                            desconectar($conexion);
                        }
                        try {
                            $conexion= new mysqli("db", "root", "test", "tienda");
                            $sql="CREATE TABLE IF NOT EXISTS usuarios(
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            nombre VARCHAR(50),
                            apellidos VARCHAR(100),
                            edad INT,
                            provincia VARCHAR(50)
                            );";
                            $conexion->query($sql);
                        }
                        catch(mysqli_sql_exception $e) {
                            echo 'Error creado la tabla: ' . $e->getMessage() . '<br>';
                        }
                        try {
                            $conexion= new mysqli("db", "root", "test", "tienda");
                            $sql="CREATE TABLE IF NOT EXISTS productos(
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            nombre VARCHAR(50),
                            descripcion VARCHAR(100),
                            precio FLOAT,
                            unidades INT,
                            foto BLOB
                            );";
                            $conexion->query($sql);
                        }
                        catch(mysqli_sql_exception $e) {
                            echo 'Error creado la tabla: ' . $e->getMessage() . '<br>';
                        }
                        finally {
                            desconectar($conexion);
                        }
                        $resultados= seleccionarUsuarios();
                        if(is_array($resultados)) {
                            echo '<table class="table table-bordered">'; 
                            echo '<thead class="table-dark">'; 
                            echo '<tr>'; 
                            echo '<th>Id</th>'; 
                            echo '<th>Nombre</th>'; 
                            echo '<th>Apellidos</th>'; 
                            echo '<th>Edad</th>'; 
                            echo '<th>Provincia</th>'; 
                            echo '<th>Acciones</th>'; 
                            echo '</tr>'; 
                            echo '</thead>'; 
                            echo '<tbody>';
                            foreach ($resultados as $row) { 
                                echo '<tr>'; 
                                echo '<td>' . $row[0] . '</td>'; 
                                echo '<td>' . $row[1] . '</td>'; 
                                echo '<td>' . $row[2] . '</td>'; 
                                echo '<td>' . $row[3] . '</td>'; 
                                echo '<td>' . $row[4] . '</td>'; 
                                echo '<td>'; 
                                echo '<a href="editarUsuarioForm.php?id=' . $row[0] . '" class="btn btn-success m-2" role="button">Editar</a>'; 
                                echo '<a href="borrarUsuario.php?id=' . $row[0] . '" class="btn btn-danger" role="button">Eliminar</a>'; 
                                echo '</td>'; 
                                echo '</tr>'; 
                            } 
                                echo '</tbody>'; 
                                echo '</table>';
                        }
                        else {
                            echo $resultados;
                        }
                        $resultados= seleccionarProductos();
                        if(is_array($resultados)) {
                            echo '<table class="table table-bordered">'; 
                            echo '<thead class="table-dark">'; 
                            echo '<tr>'; 
                            echo '<th>Id</th>'; 
                            echo '<th>Nombre</th>'; 
                            echo '<th>Descripción</th>'; 
                            echo '<th>Precio</th>'; 
                            echo '<th>Unidades</th>'; 
                            echo '<th>foto</th>';
                            echo '<th>Acciones</th>'; 
                            echo '</tr>'; 
                            echo '</thead>'; 
                            echo '<tbody>';
                            foreach ($resultados as $row) { 
                                echo '<tr>'; 
                                echo '<td>' . $row[0] . '</td>'; 
                                echo '<td>' . $row[1] . '</td>'; 
                                echo '<td>' . $row[2] . '</td>'; 
                                echo '<td>' . $row[3] . '</td>'; 
                                echo '<td>' . $row[4] . '</td>'; 
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row[5]) . '"></td>'; 
                                echo '<td>'; 
                                echo '<a href="editarUsuarioForm.php?id=' . $row[0] . '" class="btn btn-success m-2" role="button">Editar</a>'; 
                                echo '<a href="borrarUsuario.php?id=' . $row[0] . '" class="btn btn-danger" role="button">Eliminar</a>'; 
                                echo '</td>'; 
                                echo '</tr>'; 
                            } 
                                echo '</tbody>'; 
                                echo '</table>';
                        }
                        else {
                            echo $resultados;
                        }
                    ?>
                </div>
                <h2>Formulario de añadido de usuarios</h2>
                <form action="agregarUsuario.php" method="post">
                    <p>Nombre del usuario: <input type="text" name="nombre" required /></p>
                    <p>Apellidos del usuario: <input type="text" name="apellidos" required /></p>
                    <p>Edad del usuario: <input type="number" name="edad" required /></p>
                    <p>Provincia de residencia del usuario: <input type="text" name="provincia" required /></p>
                    <button class="btn btn-primary" role="button" type="submit">Añadir usuario</button>
                </form>
                <br>
                <h2>Formulario de añadido de productos</h2>
                <form action="agregarProducto.php" method="post" enctype="multipart/form-data">
                    <p>Nombre del producto: <input type="text" name="nombre" required /></p>
                    <p>Descripción del producto: <input type="text" name="descripcion" required /></p>
                    <p>Precio del producto: <input type="number" name="precio" step="0.01" required /></p>
                    <p>Unidades del producto: <input type="number" name="unidades" required /></p>
                    <p>Foto del producto: <input type="file" name="foto" required /></p>
                    <button class="btn btn-primary" role="button" type="submit">Añadir producto</button>
                </form>
            </main>
            <?php
            include("footer.php");
            ?>
        </div>
    </div>
</body>
</html>