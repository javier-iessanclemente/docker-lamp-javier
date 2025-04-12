<?php
function validarUsuario($nombre, $email, $password) {
    $validacion= [true];
    $errores= [];
    if(!isset($nombre) || is_null($nombre) || !is_string($nombre) || empty($nombre) ) {
        $validacion[0]= false;
        array_push($errores, 'El nombre no es valido');
    }
    if(!isset($email) || is_null($email) || !is_string($email) || empty($email)) {
        $validacion[0]= false;
        array_push($errores, 'El email no es valido');
    }
    if(!isset($password) || is_null($password) || !is_string($password) || empty($password)) {
        $validacion[0]= false;
        array_push($errores, 'La contraseña no es valida');
    }
    array_push($validacion, $errores);
    return $validacion;
}

function validarUsuarioSesion($email, $password) {
    $validacion= [true];
    $errores= [];
    if(!isset($email) || is_null($email) || !is_string($email) || empty($email)) {
        $validacion[0]= false;
        array_push($errores, 'El email no es valido');
    }
    if(!isset($password) || is_null($password) || !is_string($password) || empty($password)) {
        $validacion[0]= false;
        array_push($errores, 'La contraseña no es valida');
    }
    array_push($validacion, $errores);
    return $validacion;
}

function validarContacto($nombre, $telefono, $email, $usuario_id) {
    $validacion= [true];
    $errores= [];
    if(!isset($nombre) || is_null($nombre) || !is_string($nombre) || empty($nombre) ) {
        $validacion[0]= false;
        array_push($errores, 'El nombre no es valido');
    }
    if(!isset($telefono) || is_null($telefono) || !is_string($telefono) || empty($telefono)) {
        $validacion[0]= false;
        array_push($errores, 'El número de telefono no es valido');
    }
    if(!isset($email) || is_null($email) || !is_string($email) || empty($email)) {
        $validacion[0]= false;
        array_push($errores, 'El email no es valido');
    }
    if(!isset($usuario_id) || is_null($usuario_id) || !is_int($usuario_id)) {
        $validacion[0]= false;
        array_push($errores, 'El id del usuario no es valido');
    }
    array_push($validacion, $errores);
    return $validacion;
}

function validarContactoEdicion($nombre=null, $telefono=null, $email=null, $usuario_id=null) {
    $validacion= [true];
    $errores= [];
    if(!isset($nombre) || !is_string($nombre) || empty($nombre) ) {
        $validacion[0]= false;
        array_push($errores, 'El nombre no es valido');
    }
    if(!isset($telefono) || !is_string($telefono) || empty($telefono)) {
        $validacion[0]= false;
        array_push($errores, 'El número de telefono no es valido');
    }
    if(!isset($email) || !is_string($email) || empty($email)) {
        $validacion[0]= false;
        array_push($errores, 'El email no es valido');
    }
    if(!isset($usuario_id) || !is_int($usuario_id)) {
        $validacion[0]= false;
        array_push($errores, 'El id del usuario no es valido');
    }
    array_push($validacion, $errores);
    return $validacion;
}

function validarId($id) {
    $validacion= [true];
    $errores= [];
    if(!isset($id) || !is_int(intval($id)) || empty($id) ) {
        $validacion[0]= false;
        array_push($errores, 'El id no es valido');
    }
    array_push($validacion, $errores);
    return $validacion;
}