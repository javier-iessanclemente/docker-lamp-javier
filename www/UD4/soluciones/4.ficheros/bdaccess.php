<?php 
function conectar() {
    return new mysqli("db", "root", "test", "tienda");
}

function desconectar($conexion) {
    $conexion->close();
}

function seleccionarUsuarios() {
    $resultado= [];
    try {
        $conexion= conectar();
        $sql="SELECT * FROM usuarios";
        $resultado_consulta= $conexion->query($sql);
        $resultado= $resultado_consulta->fetch_all();
        return $resultado;
    }
    catch(mysqli_sql_exception $e) {
        return 'Error creado la conexión: ' . $e->getMessage();
    }
    finally {
        desconectar($conexion);
    }
}

function seleccionarProductos() {
    $resultado= [];
    try {
        $conexion= conectar();
        $sql="SELECT * FROM productos";
        $resultado_consulta= $conexion->query($sql);
        $resultado= $resultado_consulta->fetch_all();
        return $resultado;
    }
    catch(mysqli_sql_exception $e) {
        return 'Error creado la conexión: ' . $e->getMessage();
    }
    finally {
        desconectar($conexion);
    }
}

function filtrarCampo($campo) {
    $campo= trim($campo);
    $campo= stripslashes($campo);
    $campo = htmlspecialchars($campo, ENT_COMPAT, "ISO-8859-1");

    if(preg_match('/[^a-zA-Z0-9\s{1,}]/', $campo)) {
        $campo= preg_replace('/[^a-zA-Z0-9\s{1,}]/', '', $campo);
    }
    if(preg_match('/\s{2,}/', $campo)) {
        $campo= preg_replace('#\s+#', ' ', $campo);
    }
    return $campo;
}

function validarCamposUsuario($nombre, $apelidos, $edad, $provincia) {
    $nombre= filtrarCampo($nombre);
    $apelidos= filtrarCampo($apelidos);
    $edad= filtrarCampo($edad);
    $provincia= filtrarCampo($provincia);
    if(empty($nombre) || empty($apelidos) || empty($edad) || empty($provincia)) {
        echo "Entro en el if empty <br>";
        return false;
    }
    else {
        if(!is_integer(intval($edad)) && int_val($edad) > 0) {
            echo "Entro en el if no integer para edad <br>";
            return false;
        } else {
            if(is_numeric($nombre) || is_numeric($apelidos) || is_numeric($provincia)) {
                echo "Entro en el if si algún campo que no es edad es numerico <br>";
                return false;
            }
        }
    }
    return true;
}

function validarCamposProducto($nombre, $descripcion, $precio, $unidades, $foto) {
    $nombre= filtrarCampo($nombre);
    $descripcion= filtrarCampo($descripcion);
    $precio= filtrarCampo($precio);
    $unidades= filtrarCampo($unidades);
    if(empty($nombre) || empty($descripcion) || empty($precio) || empty($unidades) || empty($foto)) {
        echo "Entro en el if empty <br>";
        return false;
    }
    else {
        if(!is_numeric(floatval($precio)) || floatval($precio) < 0) {
            echo "Entro en el if precio no es numero o es menor que 0<br>";
            return false;
        } else {
            if(!is_numeric(floatval($unidades)) || floatval($unidades) < 0) {
                echo "Entro en el if unidades no es numero o es menor que 0<br>";
                return false;
            } else {
                if(is_numeric($nombre) || is_numeric($descripcion)) {
                    echo "Entro en el if si algún campo que no es edad es numerico <br>";
                    return false;
                }
                else {
                    $extension_foto= strtolower(pathinfo($foto["full_path"], PATHINFO_EXTENSION));
                    $tamaño_foto= $foto["size"]; 

                    if($extension_foto != "jpg" && $extension_foto != "jpeg" && $extension_foto != "png" && $extension_foto != "gif") {
                        echo "Entro en el if de tipo de imagen no valido<br>";
                    }
                    else {
                        if($tamaño_foto > 5000000) {
                            echo "Entro en el if de tamaño de imagen mayor de 5MB<br>";
                        }
                    }
                }
            }
        }
    }
    var_dump($foto);
    return true;
}

function validarCamposEdicionUsuario($nombre, $apellidos, $edad, $provincia) {
    
    if(!is_null($nombre)) {
        $nombre= filtrarCampo($nombre);
    }
    if(!is_null($apellidos)) {
        $apellidos= filtrarCampo($apellidos);
    }
    if(!is_null($edad)) {
        $edad= filtrarCampo($edad);
    }
    if(!is_null($provincia)) {
        $provincia= filtrarCampo($provincia);
    }
    
    if((empty($nombre) && !is_null($nombre)) || (empty($apellidos) && !is_null($apellidos)) || (empty($edad) && !is_null($edad)) || (empty($provincia) && !is_null($provincia))) {
        echo "Entro en el if empty <br>";
        return false;
    }
    else {
        if(!is_integer(intval($edad)) && !is_null($edad) && int_val($edad) > 0) {
            echo "Entro en el if no integer para edad <br>";
            return false;
        } else {
            if(is_numeric($nombre) || is_numeric($apellidos) || is_numeric($provincia)) {
                echo "Entro en el if si algún campo que no es edad es numerico <br>";
                return false;
            }
        }
    }
    var_dump($precio);
    return true;
}

function agregarUsuario($nombre, $apellidos , $edad, $provincia) {
    if(validarCamposUsuario($nombre, $apellidos, $edad, $provincia)) {
        try{
            $nombre= filtrarCampo($nombre);
            $apellidos= filtrarCampo($apellidos);
            $edad= intval(filtrarCampo($edad));
            $provincia= filtrarCampo($provincia);

            $conexion= conectar();
            $consulta_agregacion = $conexion->prepare("INSERT INTO usuarios (nombre, apellidos, edad, provincia) VALUES (?, ?, ?, ?);");
            $consulta_agregacion->bind_param("ssis", $nombre, $apellidos, $edad, $provincia);
            $consulta_agregacion->execute();
            $resultado_consulta= $consulta_agregacion->get_result();
            return $resultado_consulta;
        }
        catch(mysqli_sql_exception $e) {
            return 'Error en la agregación del usuario: ' . $e->getMessage();
        }
        finally {
            desconectar($conexion);
        }
    }
    else {
        echo "Los campos no son validos la agregación no se pudo realizar";
    }
}

function agregarProducto($nombre, $descripcion, $precio, $unidades, $foto) {
    if(validarCamposProducto(filtrarCampo($nombre), filtrarCampo($descripcion), filtrarCampo($precio), filtrarCampo($unidades), $foto)) {
        try{
            $nombre= filtrarCampo($nombre);
            $descripcion= filtrarCampo($descripcion);
            $precio= intval(filtrarCampo($precio));
            $unidades= filtrarCampo($unidades);
            $contenido_foto= file_get_contents($foto["tmp_name"]);

            $conexion= conectar();
            $consulta_agregacion = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, unidades, foto) VALUES (?, ?, ?, ?, ?);");
            $consulta_agregacion->bind_param("ssdis", $nombre, $descripcion, $precio, $unidades, $contenido_foto);
            $consulta_agregacion->execute();
            $resultado_consulta= $consulta_agregacion->get_result();
            return $resultado_consulta;
        }
        catch(mysqli_sql_exception $e) {
            return 'Error en la agregación del producto: ' . $e->getMessage();
        }
        finally {
            desconectar($conexion);
        }
    }
    else {
        echo "Los campos no son validos la agregación no se pudo realizar";
    }
}

function editarUsuario($id, $cambios) {
    $resultados_consultas= [];
    try {
        $conexion= conectar();
        $nombre= $cambios[0];
        $apellidos= $cambios[1];
        $edad= $cambios[2];
        $provincia= $cambios[3];
        if(!is_null($nombre)) {
            $nombre= filtrarCampo($nombre);
        }
        if(!is_null($apellidos)) {
            $apellidos= filtrarCampo($apellidos);
        }
        if(!is_null($edad)) {
            $edad= filtrarCampo($edad);
        }
        if(!is_null($provincia)) {
            $provincia= filtrarCampo($provincia);
        }
        var_dump($nombre);
        if(!is_null($nombre) && validarCamposEdicionUsuario($nombre, null, null, null)) {
            echo "Se entra en if del nombre<br>";
            $consulta_agregacion = $conexion->prepare('UPDATE usuarios SET nombre= ? WHERE id= ?;');
            $consulta_agregacion->bind_param("si", $nombre, $id);
            $consulta_agregacion->execute();
            $resultado_consulta1= $consulta_agregacion->get_result();
            //array_push($resultado_consultas, $resultado_consulta1);
        }
        var_dump($apellidos);
        if(!is_null($apellidos) && validarCamposEdicionUsuario(null, $apellidos, null, null)) {
            echo "Se entra en if de los apellidos<br>";
            $consulta_agregacion = $conexion->prepare('UPDATE usuarios SET apellidos= ? WHERE id= ?;');
            $consulta_agregacion->bind_param("si", $apellidos, $id);
            $consulta_agregacion->execute();
            $resultado_consulta2= $consulta_agregacion->get_result();
            //array_push($resultado_consultas, $resultado_consulta2);
        }
        var_dump($edad);
        if(!is_null($edad) && validarCamposEdicionUsuario(null, null, $edad, null)) {
            echo "Se entra en if de la edad<br>";
            $consulta_agregacion = $conexion->prepare('UPDATE usuarios SET edad= ? WHERE id= ?;');
            $consulta_agregacion->bind_param("ii", $edad, $id);
            $consulta_agregacion->execute();
            $resultado_consulta3= $consulta_agregacion->get_result();
            //array_push($resultado_consultas, $resultado_consulta3);
        }
        var_dump($provincia);
        if(!is_null($provincia) && validarCamposEdicionUsuario(null, null, null, $provincia)) {
            echo "Se entra en if de la provincia<br>";
            $consulta_agregacion = $conexion->prepare('UPDATE usuarios SET provincia= ? WHERE id= ?;');
            $consulta_agregacion->bind_param("si", $provincia, $id);
            $consulta_agregacion->execute();
            $resultado_consulta4= $consulta_agregacion->get_result();
            //array_push($resultado_consultas, $resultado_consulta4);
        }
        return $resultados_consultas;
    }
    catch(mysqli_sql_exception $e) {
        return 'Error en la edición del usuario: ' . $e->getMessage();
    }
    finally {
        desconectar($conexion);
    }

}

function borrarUsuario($id) {
    try{
        $conexion= conectar();
        $sql="DELETE FROM usuarios WHERE id=$id";
        $resultado_consulta= $conexion->query($sql);
        return true;
    }
    catch(mysqli_sql_exception $e) {
        return 'Error en el borrado del usuario: ' . $e->getMessage();
    }
    finally {
        desconectar($conexion);
    }
}

function borrarTabla() {
    try{
        $conexion= conectar();
        $sql="DROP TABLE usuarios";
        $resultado_consulta= $conexion->query($sql);
    }
    catch(mysqli_sql_exception $e) {
        return 'Error en el borrado de la tabla: ' . $e->getMessage();
    }
    finally {
        desconectar($conexion);
    }
}
?>