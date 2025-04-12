<?php

declare(strict_types=1);

require_once 'flight/Flight.php';
//require 'flight/autoload.php';
$ruta= __DIR__ .'utils.php';
require_once __DIR__ .'/utils.php';

Flight::register('db', 'PDO', array('mysql:host=db;dbname=agenda','root','test'));

Flight::route('/', function () {
    echo 'API de agenda de contactos';
});

Flight::route('POST /register', function () {
    $nombre= Flight::request()->data->nombre;
    $email= Flight::request()->data->email;
    $password = Flight::request()->data->password;
    $resultadoValidacion= validarUsuario($nombre, $email, $password);
    if($resultadoValidacion[0]) {
        $sql= "SELECT id from usuarios WHERE token IS NOT NULL";
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->execute();
        $datos= $sentencia->fetchAll();
        if(count($datos) > 0) {
            for($j=0; $j < count($datos); $j++) {
                $sql= 'UPDATE usuarios SET token= NULL WHERE id=?';
                $token= bin2hex(random_bytes(32));
                $sentenciaUpdate= Flight::db()->prepare($sql);
                $sentenciaUpdate->bindParam(1, $datos[$j]['id']);
                $sentenciaUpdate->execute();
            }
        }
        $hash= password_hash($password, PASSWORD_DEFAULT);
        $token= bin2hex(random_bytes(32));
        $sql= 'INSERT INTO usuarios(nombre, email, password, token) VALUES (?, ?, ?, ?)';
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->bindParam(1, $nombre);
        $sentencia->bindParam(2, $email);
        $sentencia->bindParam(3, $hash);
        $sentencia->bindParam(4, $token);

        $sentencia->execute();

        Flight::json(["Usuario registrado correctamente. El token de este es " . $token]);
    }
    else {
        $errores= $resultadoValidacion[1];
        for($i= 0; $i < count($errores); $i++) {
            if($i == 0) {
                $mensaje= "Fallo al registrar el usuario: " . $errores[$i];
            }
            else {
                $mensaje= $mensaje . ', ' . $errores[$i];
            }
        }
        Flight::json([$mensaje], 400);
    }
});

Flight::route('POST /login', function () {
    $email=Flight::request()->data->email;
    $password=Flight::request()->data->password;
    $resultadoValidacion= validarUsuarioSesion($email, $password);
    $token= null;
    if($resultadoValidacion[0]) {
        $hash= password_hash($password, PASSWORD_DEFAULT);

        $sql= 'SELECT id,email, password from usuarios WHERE email=?';
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->bindParam(1, $email);

        $sentencia->execute();
        $datos_usuario= $sentencia->fetchAll();
        if(count($datos_usuario) > 0) {
            $contrasena_verificada= false;
            for($i=0; $i < count($datos_usuario); $i++) {
                if(password_verify($password, $datos_usuario[$i]['password'])) {
                    $sql= "SELECT id from usuarios WHERE token IS NOT NULL";
                    $sentencia= Flight::db()->prepare($sql);
                    $sentencia->execute();
                    $datos= $sentencia->fetchAll();
                    if(count($datos) > 0) {
                        for($j=0; $j < count($datos); $j++) {
                            $sql= 'UPDATE usuarios SET token= NULL WHERE id=?';
                            $token= bin2hex(random_bytes(32));
                            $sentenciaUpdate= Flight::db()->prepare($sql);
                            $sentenciaUpdate->bindParam(1, $datos[$j]['id']);
                            $sentenciaUpdate->execute();
                        }
                    }

                    $sql= 'UPDATE usuarios SET token=? WHERE id=?';
                    $token= bin2hex(random_bytes(32));
                    $sentencia= Flight::db()->prepare($sql);
                    $sentencia->bindParam(1, $token);
                    $sentencia->bindParam(2, $datos_usuario[$i]['id']);
                    $sentencia->execute();
                    $contrasena_verificada= true;
                }
            }
            if(!$contrasena_verificada) {
                Flight::json(["Fallo al iniciar sesión: La contraseña introducida no es correcta"]);
            }
            else {
                Flight::json(["Sesion iniciada correctamente. El token es " . $token]);
            }
        }
        else {
            Flight::json(["Fallo al al iniciar sesión: El correo introducido no es correcto"]);
        }
    }
    else {
        $errores= $resultadoValidacion[1];
        for($i= 0; $i < count($errores); $i++) {
            if($i == 0) {
                $mensaje= "Fallo al registrar el usuario: " . $errores[$i];
            }
            else {
                $mensaje= $mensaje . ', ' . $errores[$i];
            }
        }
        Flight::json([$mensaje], 400);
    }
});
/*
Flight::route('GET /contactos', function () {
    $token= Flight::request()->getHeader('X-Token');
    $sql= 'SELECT id, token FROM usuarios WHERE token=:token';
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datos= $sentencia->fetchAll();
    if(count($datos) == 1) {
        $id_usuario= $datos[0]['id'];
        Flight::set('user', $datos[0]);
        $sql= 'SELECT * FROM contactos WHERE usuario_id=:id_usuario';
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->execute();
        $datos= $sentencia->fetchAll();
        Flight::json($datos);
    }
    else {
        Flight::json(['message' => 'Unauthorized'], 401);
    }
});
*/
Flight::route('GET /contactos(/@id)', function ($id = null) {
    $token= Flight::request()->getHeader('X-Token');
    $sql= 'SELECT id, token FROM usuarios WHERE token=:token';
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datos= $sentencia->fetchAll();
    if(count($datos) == 1) {
        $id_usuario= $datos[0]['id'];
        Flight::set('user', $datos[0]);
        if(!is_null($id)) {
            $sql= 'SELECT * FROM contactos WHERE usuario_id=:id_usuario AND id=:id';
            $sentencia= Flight::db()->prepare($sql);
            $sentencia->bindParam(':id', $id);
        }
        else {
            $sql= 'SELECT * FROM contactos WHERE usuario_id=:id_usuario';
            $sentencia= Flight::db()->prepare($sql);
        }
        $sentencia->bindParam(':id_usuario', $id_usuario);
        
        $sentencia->execute();
        $datos= $sentencia->fetchAll();
        if(count($datos) > 0 || is_null($id)) {
            Flight::json($datos);
        }
        else {
            Flight::json(['El contacto a mostrar no pudo ser encontrado'], 404);
        }
    }
    else {
        Flight::json(['El token no es valido'], 401);
    }
});

Flight::route('POST /contactos', function () {
    $token= Flight::request()->getHeader('X-Token');
    $sql= 'SELECT id, token FROM usuarios WHERE token=:token';
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datos= $sentencia->fetchAll();
    if(count($datos) == 1) {
        $usuario_id= $datos[0]['id'];
        Flight::set('user', $datos[0]);
        $nombre= Flight::request()->data->nombre;
        $telefono= Flight::request()->data->telefono;
        $email= Flight::request()->data->email;
        $resultadoValidacion= validarContacto($nombre, $telefono, $email, $usuario_id);
        if($resultadoValidacion[0]) {
            $sql= 'INSERT INTO contactos (nombre, telefono, email, usuario_id) VALUES (:nombre, :telefono, :email, :usuario_id)';
            $sentencia= Flight::db()->prepare($sql);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':telefono', $telefono);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':usuario_id', $usuario_id);
            $sentencia->execute();
            $datos= $sentencia->fetchAll();
            Flight::json(['Contacto registrado correctamente']);
        }
        else {
            $errores= $resultadoValidacion[1];
            for($i= 0; $i < count($errores); $i++) {
                if($i == 0) {
                    $mensaje= "Fallo al crear el contacto: " . $errores[$i];
                }
                else {
                    $mensaje= $mensaje . ', ' . $errores[$i];
                }
            }
            Flight::json([$mensaje], 400);
        }
    }
    else {
        Flight::json(['El token no es valido'], 401);
    }
});

Flight::route('PUT /contactos/@id', function ($id) {
    $token= Flight::request()->getHeader('X-Token');
    $sql= 'SELECT id, token FROM usuarios WHERE token=:token';
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datos= $sentencia->fetchAll();
    if(count($datos) == 1) {
        $usuario_id= $datos[0]['id'];
        $sql= 'SELECT * FROM contactos WHERE id=:id';
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $datos= $sentencia->fetchAll();
        if(count($datos) == 1  && $datos[0]["usuario_id"] == $usuario_id) {
            Flight::set('user', $datos[0]);
            if(!is_null(Flight::request()->data->nombre)) {
                $nombre= Flight::request()->data->nombre;
            }
            else {
                $nombre= $datos['nombre'];
            }
            if(!is_null(Flight::request()->data->telefono)) {
                $telefono= Flight::request()->data->telefono;
            }
            else {
                $nombre= $datos['telefono'];
            }
            if(!is_null(Flight::request()->data->email)) {
                $email= Flight::request()->data->email;
            }
            else {
                $nombre= $datos['email'];
            }
            $resultadoValidacion= validarContacto($nombre, $telefono, $email, $usuario_id);
            if($resultadoValidacion[0]) {
                $sql= 'UPDATE contactos SET nombre=:nombre, telefono=:telefono, email=:email WHERE id=:id';
                $sentencia= Flight::db()->prepare($sql);
                $sentencia->bindParam(':nombre', $nombre);
                $sentencia->bindParam(':telefono', $telefono);
                $sentencia->bindParam(':email', $email);
                $sentencia->bindParam(':id', $id);
                $sentencia->execute();
                Flight::json(['Contacto actualizado correctamente']);
            }
            else {
                $errores= $resultadoValidacion[1];
                for($i= 0; $i < count($errores); $i++) {
                    if($i == 0) {
                        $mensaje= "Fallo al modificar el contacto: " . $errores[$i];
                    }
                    else {
                        $mensaje= $mensaje . ', ' . $errores[$i];
                    }
                }
                Flight::json([$mensaje], 400);
            }
        } 
        else {
            if(count($datos) == 0) {
                Flight::json(['El contacto a modificar no pudo ser encontrado'], 404);
            }
            else {
                if($datos[0]["usuario_id"] != $usuario_id) {
                    Flight::json(['El usuario no puede modificar el contacto ya que no le pertenece'], 403);
                }
            }
        }
    }
    else {
        Flight::json(['El token no es valido'], 401);
    }
});

Flight::route('DELETE /contactos/@id', function ($id) {
    $token= Flight::request()->getHeader('X-Token');
    $sql= 'SELECT id, token FROM usuarios WHERE token=:token';
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datos= $sentencia->fetchAll();
    if(count($datos) == 1) {
        $usuario_id= $datos[0]['id'];
        $sql= 'SELECT * FROM contactos WHERE id=:id';
        $sentencia= Flight::db()->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $datos= $sentencia->fetchAll();
        if(count($datos) == 1  && $datos[0]["usuario_id"] == $usuario_id) {
            Flight::set('user', $datos[0]);
            $resultadoValidacion= validarId($id);
            if($resultadoValidacion[0]) {
                $sql= 'DELETE FROM contactos WHERE id=:id';
                $sentencia= Flight::db()->prepare($sql);
                $sentencia->bindParam(':id', $id);
                $sentencia->execute();
                Flight::json(['Contacto borrado correctamente']);
            }
            else {
                $errores= $resultadoValidacion[1];
                for($i= 0; $i < count($errores); $i++) {
                    if($i == 0) {
                        $mensaje= "Fallo al borrar el contacto: " . $errores[$i];
                    }
                    else {
                        $mensaje= $mensaje . ', ' . $errores[$i];
                    }
                }
                Flight::json([$mensaje], 400);
            }
        } 
        else {
            if(count($datos) == 0) {
                Flight::json(['El contacto a borrar no pudo ser encontrado'], 404);
            }
            else {
                if($datos[0]["usuario_id"] != $usuario_id) {
                    Flight::json(['El usuario no puede modificar el contacto ya que no le pertenece'], 403);
                }
            }
        }
    }
    else {
        Flight::json(['El token no es valido'], 401);
    }
});

Flight::start();

