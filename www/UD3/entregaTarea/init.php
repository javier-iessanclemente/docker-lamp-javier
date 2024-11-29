<?php 
// Estructura try-catch para la creación de la BD: 
try {
    $conexion = new mysqli('db', 'root', 'test');

    $sql= 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "tareas";';
    $resultado= $conexion->query($sql);
    if($resultado->num_rows == 1) {
        echo '<div role="alert" class="alert alert-warning">La base de datos "tareas" ya existía.</div>';
    }
    else {
        $sql = 'CREATE DATABASE IF NOT EXISTS tareas';
    if ($conexion->query($sql)) {
        echo '<div role="alert" class="alert alert-success">Base de datos creada correctamente</div>';
    }
    else {
        echo '<div role="alert" class="alert alert-danger">Error creando la base de datos: ' . $conexion->error . '</div>';
    }
    }
}
catch (mysqli_sql_exception $e) {
    echo '<div role="alert" class="alert alert-danger">Error en la conexión: ' . $e->getMessage() . '</div>';
}
finally {
    // Cerrar la conexión si se estableció
    if (isset($conexion) && $conexion->connect_errno === 0) {
        $conexion->close();
    }
}

// Estructura try-catch para la creación de la tabla usuarios: 
try {
    $conexion = new mysqli('db', 'root', 'test', 'tareas');

    $sql= 'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA= "tareas" && TABLE_NAME = "usuarios";';
    $resultado= $conexion->query($sql);
    if($resultado->num_rows == 1) {
        echo '<div role="alert" class="alert alert-warning">La tabla "usuarios" ya existía.</div>';
    }
    else {
        $sql = 'CREATE TABLE IF NOT EXISTS usuarios (id INT PRIMARY KEY AUTO_INCREMENT , username VARCHAR(50) NOT NULL, nombre VARCHAR(50) NOT NULL, apellidos VARCHAR(100) NOT NULL, contrasena VARCHAR(100) NOT NULL);';
        if ($conexion->query($sql)) {
            echo '<div role="alert" class="alert alert-success">Tabla usuarios creada correctamente</div>';
        }
        else {
            echo '<div role="alert" class="alert alert-danger">Error creando la tabla usuarios: ' . $conexion->error . '</div>';
        }
    }
}
catch (mysqli_sql_exception $e) {
    echo '<div role="alert" class="alert alert-danger">Error en la conexión: ' . $e->getMessage() . '</div>';
}
finally {
    // Cerrar la conexión si se estableció
    if (isset($conexion) && $conexion->connect_errno === 0) {
        $conexion->close();
    }
}

// Estructura try-catch para la creación de la tabla tareas: 
try {
    $conexion = new mysqli('db', 'root', 'test', 'tareas');

    $sql= 'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA= "tareas" && TABLE_NAME = "tareas";';
    $resultado= $conexion->query($sql);
    if($resultado->num_rows == 1) {
        echo '<div role="alert" class="alert alert-warning">La tabla "tareas" ya existía.</div>';
    }
    else {
        $sql = 'CREATE TABLE IF NOT EXISTS tareas (id INT PRIMARY KEY AUTO_INCREMENT , titulo VARCHAR(50) NOT NULL , descripcion VARCHAR(250) NOT NULL , estado VARCHAR(50) NOT NULL , id_usuario INT NOT NULL, FOREIGN KEY (id_usuario) REFERENCES usuarios (id) ON DELETE CASCADE);';
        if ($conexion->query($sql)) {
            echo '<div role="alert" class="alert alert-success">Tabla tareas creada correctamente</div>';
        }
        else {
            echo '<div role="alert" class="alert alert-success">Error creando la tabla tareas: ' . $conexion->error . '</div>';
        }
    }
}
catch (mysqli_sql_exception $e) {
    echo '<div role="alert" class="alert alert-danger">Error en la conexión: ' . $e->getMessage() . '</div>';
}
finally {
    // Cerrar la conexión si se estableció
    if (isset($conexion) && $conexion->connect_errno === 0) {
        $conexion->close();
    }
}
?>