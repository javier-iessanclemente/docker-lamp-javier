<?php
class Usuario {
    private int $id;
    private string $username;
    private string $nombre;
    private string $apellidos;
    private string $contrasena;
    private int $rol;

    public function __construct(string $nombre= "", string $apellidos= "", string $username= "", string $contrasena= "", int $id= 0) {
        $this->id= $id;
        $this->username= $username;
        $this->nombre= $nombre;
        $this->apellidos= $apellidos;
        $this->contrasena= $contrasena;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id= $id;
    }

    public function getUsername(): string {
        return $this->username;
    }
    
    public function setUsername(string $username): void {
        $this->username= $username;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre= $nombre;
    }

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos= $apellidos;
    }

    public function getContrasena(): string {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): void {
        $this->contrasena= $contrasena;
    }

    public function getRol(): int {
        return $this->rol;
    }

    public function setRol(int $rol): void {
        $this->rol= $rol;
    }

    public function validarTexto(): array {
        
        $mensajes= [];
        $valido= true;
        if(!validarCampoTexto($this->getNombre())) {
            array_push($mensajes, 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getApellidos())) {
            array_push($mensajes, 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getUsername())) {
            array_push($mensajes, 'El campo username es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!empty($this->getContrasena()) && !validaContrasena($this->getContrasena())) {
            array_push($mensajes, 'La contraseña debe ser compleja.');
            $valido= false;
        }
        return [$valido, $mensajes];
    }

    public function validarTextoNuevo(): array {
        
        $mensajes= [];
        $valido= true;
        if(!validarCampoTexto($this->getNombre())) {
            array_push($mensajes, 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getApellidos())) {
            array_push($mensajes, 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validarCampoTexto($this->getUsername())) {
            array_push($mensajes, 'El campo username es obligatorio y debe contener al menos 3 caracteres.');
            $valido= false;
        }
        if(!validaContrasena($this->getContrasena())) {
            array_push($mensajes, 'La contraseña debe ser compleja.');
            $valido= false;
        }
        return [$valido, $mensajes];
    }
}