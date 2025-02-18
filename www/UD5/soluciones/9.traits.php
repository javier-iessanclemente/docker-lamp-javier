<?php 

trait CalculosCentroEstudos {
    public function numeroDeAprobados(array $arrayNotas): int {
        $numAprobados= 0;
        for($i= 0; $i < count($arrayNotas); $i++) {
            if($arrayNotas[$i] >= 5) {
                $numAprobados++;
            }
        }
        return $numAprobados;
    }

    public function numeroDeSuspensos(array $arrayNotas): int {
        $numSuspensos= 0;
        for($i= 0; $i < count($arrayNotas); $i++) {
            
            if($arrayNotas[$i] < 5) {
                $numSuspensos++;
            }
        }
        return $numSuspensos;
    }

    public function notaMedia(array $arrayNotas): float {
        $media= 0;
        foreach ($arrayNotas as $nota) {
            $media+= $nota;
        }
        $media= $media/count($arrayNotas);
        return $media;
    }
}

trait MostrarCalculos {
    use CalculosCentroEstudos;

    public function saludo(): void {
        echo 'Bienvenido al centro de cálculo<br>';
    }

    public function showCalculusStudyCenter($arrayNotas): void {
        echo 'Nº de aprobados: ' . $this->numeroDeAprobados($arrayNotas) . '<br>';
        echo 'Nº de suspensos: ' . $this->numeroDeSuspensos($arrayNotas) . '<br>';
        echo 'Nota media: ' . $this->notaMedia($arrayNotas) . '<br>';
    }
}

class NotasTrait {
    use MostrarCalculos;

    private array $arrayNotas;

    public function __construct(array $arrayNotas) {
        $this->arrayNotas= $arrayNotas;
    }

    public function mostrar(): void {
        $this->saludo();
        $this->showCalculusStudyCenter($this->arrayNotas);
    }
}

$notas= [5, 1, 10, 9, 8, 6];
$clase= new NotasTrait($notas);
echo $clase->mostrar();
