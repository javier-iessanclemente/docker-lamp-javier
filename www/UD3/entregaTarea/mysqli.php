<?php 
    function conectar() {
        $conexion= new mysqli("db", "root", "test", "tareas");
        $error= $conexion->connect_error;
        if($error != null) {
            return $conexion->connect_error;
        }
        else {
            return $conexion;
        }
    }

    function obtenerIdUsuario($nombre_usuario) {
        $conexion= conectar();
        $consulta= 'SELECT id FROM usuarios WHERE username="' . $nombre_usuario . '";';
        $resultado= $conexion->query($consulta);
        if($resultado->num_rows == 1) {
            desconectar($conexion);
            return $resultado->fetch_assoc()["id"];
        }

    }

    function obtenerNombresUsuario() {
        $nombres= [];
        $conexion= conectar();
        $consulta= 'SELECT username FROM usuarios;';
        $resultados= $conexion->query($consulta);
        desconectar($conexion);
        if($resultados->num_rows >= 1) {
            while($resultado= $resultados->fetch_assoc()) {
                array_push($nombres, $resultado);
            }
            return $nombres;
        }

    }

    function obtenerNombreUsuario($id) {
        $nombres= [];
        $conexion= conectar();
        $consulta= 'SELECT username FROM usuarios WHERE id=' . $id . ';';
        $resultados= $conexion->query($consulta);
        desconectar($conexion);
        if($resultados->num_rows == 1) {
            while($resultado= $resultados->fetch_assoc()) {
                array_push($nombres, $resultado);
            }
            return $nombres;
        }

    }

    function obtenerValoresEstado() {
        $conexion= conectar();
        $consulta = 'SHOW COLUMNS FROM tareas LIKE "estado"';
        $result = $conexion->query($consulta); 
        if ($result->num_rows > 0) { 
            $row = $result->fetch_assoc(); 
            $estados = $row['Type'];
            $estados = str_replace("enum('", "", $estados);
            $estados = str_replace("')", "", $estados);
            $estados = explode("','", $estados);
            return $estados;
        }
    }

    function mostrarTareas() {
        $conexion= conectar();
        $consulta= "SELECT id, titulo, descripcion, estado, id_usuario FROM tareas";
        $resultados= $conexion->query($consulta);
        $resultado= [];
        foreach($resultados as $fila) {
            array_push($resultado, $fila);
        }
        desconectar($conexion);
        return $resultado;
        
    }

    function obtenerTarea($id) {
        $conexion= conectar();
        $tarea= [];
        $consulta= 'SELECT id, titulo, descripcion, estado, id_usuario FROM tareas WHERE id=' . $id . ';';
        $resultados= $conexion->query($consulta);
        if($resultados->num_rows == 1) {
            desconectar($conexion);
            array_push($tarea, $resultados->fetch_assoc());
            return $tarea;
        }
    }

    function filtrarCampoTarea($campo) {
        $campo = trim($campo);
        $campo = stripslashes($campo);
        $campo = htmlspecialchars($campo);
        return $campo;
    }

    function validarCamposTareas($titulo, $descripcion, $estado, $nombre_usuario) {
        $campos_invalidos= [];
        $titulo= filtrarCampoTarea($titulo);
        $descripcion= filtrarCampoTarea($descripcion);
        $estado= filtrarCampoTarea($estado);
        $nombre_usuario= filtrarCampoTarea($nombre_usuario);
        if(empty($titulo) || strlen($titulo) > 50) {
            array_push($campos_invalidos, "Titulo");
        }
        if(empty($descripcion) || strlen($descripcion) > 250) {
            array_push($campos_invalidos, "Descripción");
        }
        if(empty($estado) || strlen($estado) > 50) {
            array_push($campos_invalidos, "Estado");
        }
        if(empty($nombre_usuario) || strlen($nombre_usuario) > 50) {
            array_push($campos_invalidos, "Id_Usuario");
        }
        if(count($campos_invalidos) > 0) {
            return [false, $campos_invalidos];
        }
        else {
            return [true];
        }
    }

    function registrarTarea($titulo, $descripcion, $estado, $nombre_usuario) {
        $validacion= validarCamposTareas($titulo, $descripcion, $estado, $nombre_usuario);
        if($validacion[0]) {
            $nombre_usuario= filtrarCampoTarea($nombre_usuario);
            $id_usuario= obtenerIdUsuario($nombre_usuario);
            $titulo= filtrarCampoTarea($titulo);
            $descripcion= filtrarCampoTarea($descripcion);
            $estado= filtrarCampoTarea($estado);
            $conexion= conectar();
            if(!is_string($conexion)) {
                $registro= $conexion->prepare("INSERT INTO tareas(titulo, descripcion, estado, id_usuario) VALUES (?,?,?,?);");
                $registro->bind_param("sssi", $titulo, $descripcion, $estado, $id_usuario);
                $registro->execute();
                $registro->close();
                desconectar($conexion);
            }
            else {
                return $conexion;
            }
        }
        else {
            return $validacion[1];
        }
    }

    function borrarTarea($id) {
        $conexion= conectar();
        $operacion_borrado= 'DELETE FROM tareas WHERE id=' . $id . ';';
        $borrado= $conexion->query($operacion_borrado);
        if($borrado) {
            return true;
        }
        else {
            return $conexion->error;
        }
    }

    function editarTarea($titulo, $descripcion, $estado , $username , $id) {
        $validacion= validarCamposTareas($titulo, $descripcion, $estado , $username);
        if($validacion[0]) {
            $conexion= conectar();
            $operacion_edicion= 'UPDATE tareas SET titulo="' . filtrarCampoTarea($titulo) . '", descripcion="' . filtrarCampoTarea($descripcion) . '", estado="' . filtrarCampoTarea($estado) . '", id_usuario="' . filtrarCampoTarea(obtenerIdUsuario($username)) . '" WHERE id=' . $id . ';';
            $edicion= $conexion->query($operacion_edicion);
        }
        else {
            return $validacion[1];
        }
        
        
    }

    function desconectar($conexion) {
        $conexion->close();
    }
?>