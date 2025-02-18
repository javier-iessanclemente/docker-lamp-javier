<?php
class Alien {
    private string $nombre;
    private static int $numberOfAliens= 0;

    public function __construct(string $nombre) {
        $this->nombre= $nombre;
        Alien::$numberOfAliens += 1;
    }

    public static function getNumberOfAliens(): int {
        return Alien::$numberOfAliens;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre= $nombre;
    }
}

$alien1= new Alien("Viltrumita");
echo 'Datos alien 1: ' . $alien1->getNombre() . '<br><br>';
echo 'Nº de aliens: ' . Alien::getNumberOfAliens() . '<br><br>';

$alien2= new Alien("Paco");
echo 'Datos alien 2: ' . $alien2->getNombre() . '<br><br>';
echo 'Nº de aliens: ' . Alien::getNumberOfAliens() . '<br><br>';

$alien2->setNombre("Marciano");
echo 'Datos alien 2 modificado: ' . $alien2->getNombre() . '<br><br>';
echo 'Nº de aliens: ' . Alien::getNumberOfAliens() . '<br><br>';