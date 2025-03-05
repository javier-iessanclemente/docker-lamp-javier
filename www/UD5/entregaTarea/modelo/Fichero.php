<?php
class Fichero {
    private int $id;
    private string $nombre;
    private array $file;
    private string $descripcion;
    private Tarea $tarea;
    public static array $FORMATOS= ['jpg', 'jpeg', 'png', 'pdf'];
    public static int $MAX_SIZE= 20000000;

    public function __construct(string $nombre= "", string $descripcion= "", Tarea $tarea= new Tarea(), array $file=[], int $id= 0) {
        $this->id= $id;
        $this->nombre= $nombre;
        $this->file= $file;
        $this->descripcion= $descripcion;
        $this->tarea= $tarea;
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
    
    public function setNombre(string $nombre): void {
        $this->nombre= $nombre;
    }

    public function getFile(): array {
        return $this->file;
    }
    
    public function setFile(array $file): void {
        $this->file= $file;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion= $descripcion;
    }

    public function getTarea(): Tarea {
        return $this->tarea;
    }

    public function setTarea(Tarea $tarea): void {
        $this->tarea= $tarea;
    }

    public static function validar($campos): array {
        
        $mensajes= [];
        $valido= true;
        $archivo= $campos['archivo'];
        $nombre= $campos['nombre'];
        $descripcion= $campos['descripcion'];
        if(!validarCampoTexto($nombre)) {
            $mensajes['nombre']= 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.';
            $valido= false;
        }
        if(!validarCampoTexto($descripcion)) {
            $mensajes['descripcion']= 'El campo username es obligatorio y debe contener al menos 3 caracteres.';
            $valido= false;
        }
        
        $tamano= $archivo["size"];
        $extension= strtolower(pathinfo($archivo["full_path"], PATHINFO_EXTENSION));
        if(($tamano == 0 || empty($extension)) || (($tamano > Fichero::$MAX_SIZE) || (!in_array($extension, Fichero::$FORMATOS)))) {
            $mensajes['archivo']= 'El archivo es obligatorio, debe ser un .jpg, .png o .pdf y no debe superar los 20MB de tamaño.';
            $valido= false;
        }

        return $mensajes;
    }
}