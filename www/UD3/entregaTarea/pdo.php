<?php 

    function conectarPDO() {
        try {
            $conexion= new PDO("mysql:host=db;dbname=tareas", "root", "test");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        }
        catch(PDOException $e) {
            echo 'Fallo en la conexión: '. $e->getMessage();
            return $e->getMessage();
        }
    }

    function mostrarUsuarios() {
        try {
            $conexion= conectarPDO();
            $consulta= $conexion->prepare("SELECT id, username, nombre, apellidos FROM usuarios");
            $consulta->execute();
            $result= $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetchAll();
            $resultado= [];
            foreach($resultados as $fila) {
                array_push($resultado, $fila);
            }
            return $resultado;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function mostrarUsuario($id) {
        try {
            $conexion= conectarPDO();
            $consulta= $conexion->prepare('SELECT username, nombre, apellidos FROM usuarios WHERE id=' . $id);
            $consulta->execute();
            $result= $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetchAll();
            return $resultados;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function filtrarCampoUsuario($campo) {
        $campo = trim($campo);
        $campo = stripslashes($campo);
        $campo = htmlspecialchars($campo);
        return $campo;
    }

    function validarCamposUsuario($username, $nombre, $apellidos, $contrasena) {
        $campos_invalidos= [];
        $username= filtrarCampoUsuario($username);
        $nombre= filtrarCampoUsuario($nombre);
        $apellidos= filtrarCampoUsuario($apellidos);
        
        // Comprobación de si la contraseña es nula ya que puede serlo al editar un usuario y si es nulo no se puede filtrar: 
        if(!is_null($contrasena)) {
            $contrasena= filtrarCampoUsuario($contrasena);
        }
        if(empty($username) || strlen($username) > 50) {
            array_push($campos_invalidos, "Nombre de usuario");
        }
        if(empty($nombre) || strlen($nombre) > 50) {
            array_push($campos_invalidos, "Nombre");
        }
        if(empty($apellidos) || strlen($apellidos) > 100) {
            array_push($campos_invalidos, "Apellidos");
        }
        if((empty($contrasena) || strlen($contrasena) > 100) && !is_null($contrasena)) {
            array_push($campos_invalidos, "Contraseña");
        }
        if(count($campos_invalidos) > 0) {
            return [false, $campos_invalidos];
        }
        else {
            return [true];
        }
    }

    function registrarUsuario($username, $nombre, $apellidos, $contrasena) {
        $validacion= validarCamposUsuario($username, $nombre, $apellidos, $contrasena);
        if($validacion[0]) {
            try {
                $conexion= conectarPDO();
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql= 'INSERT INTO usuarios(username, nombre, apellidos, contrasena) VALUES ("'. filtrarCampoUsuario($username) .'", "'. filtrarCampoUsuario($nombre) .'", "'. filtrarCampoUsuario($apellidos) .'", "'. filtrarCampoUsuario($contrasena) . '");';
                $conexion->exec($sql);
            }
            catch(PDOException $e) {
                return $e->getMessage();
            }
            finally {
                desconectarPDO($conexion);
            }
        }
        else {
            return $validacion[1];
        }
    }

    function editarUsuario($username, $nombre, $apellidos, $contrasena, $id) {
        $validacion= validarCamposUsuario($username, $nombre, $apellidos, $contrasena);
        if($validacion[0]) {
            try {
                $conexion= conectarPDO();

                // Comprobación de si la contraseña es nula para alterar la sentencia de actualización: 
                if(is_null($contrasena) || is_null(filtrarCampoUsuario($contrasena))) {
                    $actualizacion= $conexion->prepare('UPDATE usuarios SET username="' . filtrarCampoUsuario($username) . '", nombre="' . filtrarCampoUsuario($nombre) . '", apellidos="' . filtrarCampoUsuario($apellidos) . '" WHERE id=' . $id);
                }
                else {
                    $actualizacion= $conexion->prepare('UPDATE usuarios SET username="' . filtrarCampoUsuario($username) . '", nombre="' . filtrarCampoUsuario($nombre) . '", apellidos="' . filtrarCampoUsuario($apellidos) . '", contrasena="'. filtrarCampoUsuario($contrasena) .'" WHERE id=' . $id);
                }
                $actualizacion->execute();
            }
            catch(PDOException $e) {
                return $e->getMessage();
            }
            finally {
                desconectarPDO($conexion);
            }
        }
        else {
            return $validacion[1];
        }
    }

    function borrarUsuario($id) {
        try {
            $conexion= conectarPDO();
            $sql= 'DELETE FROM usuarios WHERE id=' . $id . ';';
            $borrado= $conexion->exec($sql);
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function desconectarPDO($conexion) {
        $conexion= null;
    }

    function obtenerNombresUsuarioPDO() {
        try {
            $conexion= conectarPDO();
            $consulta= $conexion->prepare('SELECT username FROM usuarios');
            $consulta->execute();
            $result= $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetchAll();
            return $resultados;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function obtenerIdUsuarioPDO($nombre_usuario) {
        try {
            $conexion= conectarPDO();
            $consulta= $conexion->prepare('SELECT id FROM usuarios WHERE username="' . $nombre_usuario . '";');
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetch();
            return $resultados;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function obtenerNombreUsuarioPDO($id) {
        try {
            $conexion= conectarPDO();
            $consulta= $conexion->prepare('SELECT username FROM usuarios WHERE id=' . $id . ';');
            $consulta->execute();
            $result= $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetch();
            return $resultados;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }

    function buscarTareas($id_usuario, $estado) {
        try {
            $conexion= conectarPDO();
            if(is_null($estado) || empty($estado)) {
                $consulta= $conexion->prepare('SELECT id, titulo, descripcion, estado, id_usuario FROM tareas WHERE id_usuario=' . $id_usuario . ';');
            }
            else {
                $consulta= $conexion->prepare('SELECT id, titulo, descripcion, estado, id_usuario FROM tareas WHERE id_usuario=' . $id_usuario . ' && estado="' . $estado . '";');
            }
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $resultados= $consulta->fetchAll();
            $resultado= [];
            foreach($resultados as $fila) {
                array_push($resultado, $fila);
            }
            return $resultado;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            desconectarPDO($conexion);
        }
    }
?>