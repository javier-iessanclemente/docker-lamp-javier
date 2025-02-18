<?php 
class Contacto {
    private $nombre;
    private $apellido;
    private $numTelefono;

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre= $nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function setApellido($apellido) {
        $this->apellido= $apellido;
    }

    function getNumTelefono() {
        return $this->numTelefono;
    }

    function setNumTelefono($numTelefono) {
        $this->numTelefono= $numTelefono;
    }

    function muestraInformacion() {
        echo 'Nombre: ' . $this->nombre . '<br>Apellido: ' . $this->apellido . '<br>Nº de telefono: ' . $this->numTelefono . '<br>';
    }

    function __destruct() {
        echo 'Objeto destruído';
    }
}
  
$contacto= new Contacto();
$contacto->setNombre('Juan');
echo $contacto->getNombre() . '<br>';

$contacto->setApellido('Lopez');
echo $contacto->getApellido() . '<br>';

$contacto->setNumTelefono(693705223);
echo $contacto->getNumTelefono() . '<br>';

$contacto->muestraInformacion();
