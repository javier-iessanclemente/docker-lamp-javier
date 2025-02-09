<?php

function conecta($host, $user, $pass, $db)
{
    $conexion = new mysqli($host, $user, $pass, $db);
    return $conexion;
}

function conectaTareas()
{
    return conecta($_ENV['DATABASE_HOST'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], $_ENV['DATABASE_NAME']);
}

function conectaFicheros() {
    return conecta($_ENV['DATABASE_HOST'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], $_ENV['DATABASE_NAME']);
}

function cerrarConexion($conexion)
{
    if (isset($conexion) && $conexion->connect_errno === 0) {
        $conexion->close();
    }
}

function creaDB()
{
    try {
        $conexion = conecta($_ENV['DATABASE_HOST'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], null);
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // Verificar si la base de datos ya existe
            $sqlCheck = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'tareas'";
            $resultado = $conexion->query($sqlCheck);
            if ($resultado && $resultado->num_rows > 0) {
                return [false, 'La base de datos "tareas" ya existía.'];
            }

            $sql = 'CREATE DATABASE IF NOT EXISTS tareas';
            if ($conexion->query($sql))
            {
                return [true, 'Base de datos "tareas" creada correctamente'];
            }
            else
            {
                return [false, 'No se pudo crear la base de datos "tareas".'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function createTablaUsuarios()
{
    try {
        $conexion = conectaTareas();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // Verificar si la tabla ya existe
            $sqlCheck = "SHOW TABLES LIKE 'usuarios'";
            $resultado = $conexion->query($sqlCheck);

            if ($resultado && $resultado->num_rows > 0)
            {
                return [false, 'La tabla "usuarios" ya existía.'];
            }

            $sql = 'CREATE TABLE `usuarios` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(50) NOT NULL , `nombre` VARCHAR(50) NOT NULL , `apellidos` VARCHAR(100) NOT NULL , `contrasena` VARCHAR(100) NOT NULL , `rol` INT NOT NULL DEFAULT 0, PRIMARY KEY (`id`)) ';
            if ($conexion->query($sql))
            {
                return [true, 'Tabla "usuarios" creada correctamente'];
            }
            else
            {
                return [false, 'No se pudo crear la tabla "usuarios".'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function createTablaTareas()
{
    try {
        $conexion = conectaTareas();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // Verificar si la tabla ya existe
            $sqlCheck = "SHOW TABLES LIKE 'tareas'";
            $resultado = $conexion->query($sqlCheck);

            if ($resultado && $resultado->num_rows > 0)
            {
                return [false, 'La tabla "tareas" ya existía.'];
            }

            $sql = 'CREATE TABLE `tareas` (`id` INT NOT NULL AUTO_INCREMENT, `titulo` VARCHAR(50) NOT NULL, `descripcion` VARCHAR(250) NOT NULL, `estado` VARCHAR(50) NOT NULL, `id_usuario` INT NOT NULL, PRIMARY KEY (`id`), FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`))';
            if ($conexion->query($sql))
            {
                return [true, 'Tabla "tareas" creada correctamente'];
            }
            else
            {
                return [false, 'No se pudo crear la tabla "tareas".'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function createTablaFicheros() {
    try {
        $conexion = conectaFicheros();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // Verificar si la tabla ya existe
            $sqlCheck = "SHOW TABLES LIKE 'ficheros'";
            $resultado = $conexion->query($sqlCheck);

            if ($resultado && $resultado->num_rows > 0)
            {
                return [false, 'La tabla "ficheros" ya existía.'];
            }

            $sql = 'CREATE TABLE `ficheros` (`id` INT NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(100) NOT NULL, `file` VARCHAR(250) NOT NULL, `descripcion` VARCHAR(250) NOT NULL, `id_tarea` INT NOT NULL, FOREIGN KEY (id_tarea) REFERENCES tareas(id), PRIMARY KEY (`id`))'; 
            if ($conexion->query($sql))
            {
                return [true, 'Tabla "ficheros" creada correctamente'];
            }
            else
            {
                return [false, 'No se pudo crear la tabla "ficheros".'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function listaTareas()
{
    try {
        $conexion = conectaTareas();

        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $sql = "SELECT * FROM tareas";
            $resultados = $conexion->query($sql);
            $tareas = array();
            while ($row = $resultados->fetch_assoc())
            {
                $usuario = buscaUsuarioMysqli($row['id_usuario']);
                $row['id_usuario'] = $usuario['username'];
                array_push($tareas, $row);
            }
            return [true, $tareas];
        }
        
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function listaTareasUsuario($id_usuario) {
    try {
        $conexion = conectaTareas();

        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $sql = "SELECT * FROM tareas WHERE id_usuario=" . $id_usuario;
            $resultados = $conexion->query($sql);
            $tareas = array();
            while ($row = $resultados->fetch_assoc())
            {
                $usuario = buscaUsuarioMysqli($row['id_usuario']);
                $row['id_usuario'] = $usuario['username'];
                array_push($tareas, $row);
            }
            return [true, $tareas];
        }
        
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function nuevaTarea($titulo, $descripcion, $estado, $usuario)
{
    try {
        $conexion = conectaTareas();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $stmt = $conexion->prepare("INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $titulo, $descripcion, $estado, $usuario);

            $stmt->execute();

            return [true, 'Tarea creada correctamente.'];
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function actualizaTarea($id, $titulo, $descripcion, $estado, $usuario)
{
    try {
        $conexion = conectaTareas();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $sql = "UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, id_usuario = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssii", $titulo, $descripcion, $estado, $usuario, $id);

            $stmt->execute();

            return [true, 'Tarea actualizada correctamente.'];
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function borraTarea($id)
{
    try {
        $conexion = conectaTareas();

        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $sql = "DELETE FROM tareas WHERE id = " . $id;
            if ($conexion->query($sql))
            {
                return [true, 'Tarea borrada correctamente.'];
            }
            else
            {
                return [false, 'No se pudo borrar la tarea.'];
            }
            
        }
        
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function buscaTarea($id)
{
    $conexion = conectaTareas();

    if ($conexion->connect_error)
    {
        return [false, $conexion->error];
    }
    else
    {
        $sql = "SELECT * FROM tareas WHERE id = " . $id;
        $resultados = $conexion->query($sql);
        if ($resultados->num_rows == 1)
        {
            return $resultados->fetch_assoc();
        }
        else
        {
            return null;
        }
    }
}

function buscaUsuarioMysqli($id)
{
    $conexion = conectaTareas();

    if ($conexion->connect_error)
    {
        return [false, $conexion->error];
    }
    else
    {
        $sql = "SELECT * FROM usuarios WHERE id = " . $id;
        $resultados = $conexion->query($sql);
        if ($resultados->num_rows == 1)
        {
            return $resultados->fetch_assoc();
        }
        else
        {
            return null;
        }
    }
}

function nuevoFichero($tarea_id, $nombre, $descripcion, $archivo) {
    try {
        $conexion = conectaTareas();
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $directorio = "../files/";
            $archivo["name"]= bin2hex(random_bytes(8));
            $rutaArchivo = $directorio . $archivo["name"];
            if(move_uploaded_file($archivo["tmp_name"], $rutaArchivo)) {
                $stmt = $conexion->prepare("INSERT INTO ficheros (nombre, descripcion, file, id_tarea) VALUES (?,?,?,?)");
                $stmt->bind_param("sssi", $nombre, $descripcion, $rutaArchivo, $tarea_id);

                $stmt->execute();

                return [true, 'Fichero añadido correctamente.'];
            }
            else {
                return [false, 'El fichero no pudo ser guardado correctamente'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}

function buscaFicherosTarea($id_tarea) {
    try {
        $conexion = conectaFicheros();
        if ($conexion->connect_error) {
            return [false, $conexion->error];
        }
        else {
            $sql = "SELECT * FROM ficheros WHERE id_tarea = " . $id_tarea;
            $resultados = $conexion->query($sql);
            if ($resultados->num_rows >= 1) {
                $resultado= [];
                for($i= 0; $i < $resultados->num_rows; $i++) {
                    array_push($resultado, $resultados->fetch_assoc());
                }
                return [true, $resultado];
            }
            else {
                return null;
            }
        }
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally {
        cerrarConexion($conexion);
    }
}

function borrarFichero($id) {
    try {
        $conexion = conectaFicheros();

        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            $sql = "SELECT * FROM ficheros WHERE id = " . $id;
            $resultado= $conexion->query($sql);
            if ($resultado->num_rows == 1)
            {
                $resultados= $resultado->fetch_assoc();
                if(unlink($resultados['file'])) {
                    $sql = "DELETE FROM ficheros WHERE id = " . $id;
                    if ($conexion->query($sql))
                    {
                        return [true, 'Fichero borrado correctamente.'];
                    }
                }
                else {
                    return [false, 'No se pudo borrar el fichero.'];
                }
            }
            else {
                    return [false, 'No se pudo encontrar el fichero.'];
                }
        }
        
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally
    {
        cerrarConexion($conexion);
    }
}