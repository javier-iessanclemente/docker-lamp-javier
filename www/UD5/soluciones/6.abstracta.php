<?php 

abstract class Persona {
    private int $id;
    protected string $nombre;
    protected string $apellidos;

    public function __construct($id, $nombre, $apellidos) {
        $this->id= $id;
        $this->nombre= $nombre;
        $this->apellidos= $apellidos;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id= $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void  {
        $this->nombre= $nombre;
    }

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos= $apellidos;
    }

    abstract function accion();
}

class Usuarios extends Persona {
    public function accion() {
        echo 'Nombre: ' . $this->getNombre() . '<br> Apellidos: ' . $this->getApellidos() . '<br> Es un usuario. <br><br>';
    }
}

class Administradores extends Persona {
    public function accion() {
        echo 'Nombre: ' . $this->getNombre() . '<br> Apellidos: ' . $this->getApellidos() . '<br> Es un admin. <br><br>';
    }
}

$usuario1= new Usuarios(1, 'Paco', 'Lopez');
$admin1= new Administradores(2, 'Luisa', 'Gonzalez');

echo 'Datos del usuario: . <br><br>Id: ' . $usuario1->getId() . '<br>Nombre: ' . $usuario1->getNombre() . '<br> Apellidos: ' . $usuario1->getApellidos() . '<br><br>';
echo 'Datos del admin: . <br><br>Id: ' . $admin1->getId() . '<br>Nombre: ' . $admin1->getNombre() . '<br> Apellidos: ' . $admin1->getApellidos() . '<br><br>';

$usuario1->setId(3);
$usuario1->setNombre('Paula');
$usuario1->setApellidos('Flores');

$admin1->setId(4);
$admin1->setNombre('Lorenzo');
$admin1->setApellidos('Montoya');

$usuario1->accion();
$admin1->accion();