<?php 
class Tarea {
    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $estado;
    private Usuario $usuario;

    public function __construct(string $titulo= "", string $descripcion= "", string $estado= "", Usuario $usuario= new Usuario(), int $id= 0) {
        $this->id= $id;
        $this->titulo= $titulo;
        $this->descripcion= $descripcion;
        $this->estado= $estado;
        $this->usuario= $usuario;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id= $id;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }
    
    public function setTitulo(string $titulo): void {
        $this->titulo= $titulo;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion= $descripcion;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function setEstado(string $estado): void {
        $this->estado= $estado;
    }

    public function getUsuario(): Usuario {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): void {
        $this->usuario= $usuario;
    }

    public function validar(): array {
        $usuario= $this->getUsuario();
        $mensajes= [];
        $valido= true;
        if(!validarCampoTexto($this->getTitulo())) {
            array_push($mensajes, 'El campo titulo es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getDescripcion())) {
            array_push($mensajes, 'El campo descripcion es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getEstado())) {
            array_push($mensajes, 'El campo estado es obligatorio.');
            $valido= false;
        }
        if(!esNumeroValido($usuario->getId())) {
            array_push($mensajes, 'El campo usuario es obligatorio.');
            $valido= false;
        }
        return [$valido, $mensajes];
    }

}