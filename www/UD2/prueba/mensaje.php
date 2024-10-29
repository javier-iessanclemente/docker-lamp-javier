<?php 
if(isset($mensaje) == false) {
    $mensaje= "Hola";
}
function cambiarMensaje () {
    global $mensaje;
    $mensaje= "Adios";
}
?>