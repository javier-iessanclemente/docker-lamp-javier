<?php

function filtraCampo($campo)
{
    $campo = trim($campo);
    $campo = stripslashes($campo);
    $campo = htmlspecialchars($campo);
    return $campo;
}

function validarCampoTexto($campo)
{
    return (!empty(filtraCampo($campo) && validarLargoCampo($campo, 2)));
}

function validarLargoCampo($campo, $longitud)
{
    return (strlen(trim($campo)) > $longitud);
}

function esNumeroValido($campo)
{
    return (!empty(filtraCampo($campo) && is_numeric($campo)));
}

function validaContrasena($campo)
{
    return (!empty($campo) && validarLargoCampo($campo, 7));
}

function validaRol($campo) {
    return (!empty($campo) && ($campo == "normal" || $campo == "administrador"));
}

function validarArchivo($archivo) {
    $tamano= $archivo["size"];
    $extension= strtolower(pathinfo($archivo["full_path"], PATHINFO_EXTENSION));
    return ($tamano <= 20000000) && ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "pdf");
}

function esAdmin() {
    if($_SESSION["usuario"]["rol"] == 1) {
        return true;
    }
    else {
        return false;
    }
}