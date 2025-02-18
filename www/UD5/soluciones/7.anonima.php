<?php 
$area= new class(10, 10) {
    private float $base; 
    private float $altura; 

    public function __construct($base, $altura) {
        $this->base= $base;
        $this->altura= $altura;
    }

    public function area(): float { 
        return (($this->base * $this->altura)/2);
    }
};

echo 'Área de prueba: ' . $area->area();