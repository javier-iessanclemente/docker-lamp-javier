<?php
class Participante {
    protected string $nombre;
    protected int $edad;

    public function __construct(string $nombre, int $edad) {
        $this->nombre= $nombre;
        $this->edad= $edad;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getEdad(): int {
        return $this->edad;
    }

    public function setNombre(string $nombre): void {
        $this->nombre= $nombre;
    }

    public function setEdad(int $edad): void {
        $this->edad= $edad;
    }
}

class Jugador extends Participante {
    private string $posicion;
    
    public function __construct(string $nombre, int $edad, string $posicion) {
        parent::__construct($nombre, $edad);
        $this->posicion= $posicion;
    }

    public function getPosicion(): string {
        return $this->posicion;
    }

    public function setPosicion(string $posicion): void {
        $this->posicion= $posicion;
    }

}

class Arbitro extends Participante {
    private int $anosArbitraje;
    
    public function __construct(string $nombre, int $edad, int $anosArbitraje) {
        parent::__construct($nombre, $edad);
        $this->anosArbitraje= $anosArbitraje;
    }

    public function getAnosArbitraje(): int  {
        return $this->anosArbitraje;
    }

    public function setAnosArbitraje(int $anosArbitraje): void {
        $this->anosArbitraje= $anosArbitraje;
    }

}
$jugador1= new Jugador("Paco", 23, "delantero");
$jugador2= new Jugador("Laura", 65, "portero");

$arbitro1= new Arbitro("Juana", 40, 5);
$arbitro2= new Arbitro("Gonzalo", 20, 89);

echo 'Datos jugador 1: ' . '<br>' . 'Nombre: ' . $jugador1->getNombre() . '<br>Edad: ' . $jugador1->getEdad() . '<br>Posición: ' . $jugador1->getPosicion() . '<br><br>';
echo 'Datos jugador 2: ' . '<br>' . 'Nombre: ' . $jugador2->getNombre() . '<br>Edad: ' . $jugador2->getEdad() . '<br>Posición: ' . $jugador2->getPosicion() . '<br><br>';

echo 'Datos arbitro 1: ' . '<br>' . 'Nombre: ' . $arbitro1->getNombre() . '<br>Edad: ' . $arbitro1->getEdad() . '<br>Años de experiencia: ' . $arbitro1->getAnosArbitraje() . '<br><br>';
echo 'Datos arbitro 2: ' . '<br>' . 'Nombre: ' . $arbitro2->getNombre() . '<br>Edad: ' . $arbitro2->getEdad() . '<br>Años de experiencia: ' . $arbitro2->getAnosArbitraje() . '<br><br>';

$jugador1->setNombre('Luisa');
$jugador1->setEdad(18);
$jugador1->setPosicion("defensa");
echo 'Datos jugador 1 modificado: ' . '<br>' . 'Nombre: ' . $jugador1->getNombre() . '<br>Edad: ' . $jugador1->getEdad() . '<br>Posición: ' . $jugador1->getPosicion() . '<br><br>';

$arbitro1->setNombre('Luis');
$arbitro1->setEdad(38);
$arbitro1->setAnosArbitraje(10);
echo 'Datos arbitro 1 modificado: ' . '<br>' . 'Nombre: ' . $arbitro1->getNombre() . '<br>Edad: ' . $arbitro1->getEdad() . '<br>Años de experiencia: ' . $arbitro1->getAnosArbitraje() . '<br><br>';

