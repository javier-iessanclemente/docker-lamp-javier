<?php
    interface CalculosCentroEstudios {
        public function numeroDeAprobados();
        public function numeroDeSuspensos();
        public function notaMedia();
    }

    abstract class Notas {
        private array $notas;

        public function __construct($notas) {
            $this->notas= $notas;
        }

        public function getNotas(): array {
            return $this->notas;
        }

        public function setNotas($notas): void {
            $this->notas= $notas;
        }

        public abstract function toString();
    }

    class NotasDaw extends Notas implements CalculosCentroEstudios {
        public function __construct($notas) {
            parent::__construct($notas);
        }

        public function numeroDeAprobados(): int {
            $arrayNotas= $this->getNotas();
            $numAprobados= 0;
            for($i= 0; $i < count($arrayNotas); $i++) {
                if($arrayNotas[$i] >= 5) {
                    $numAprobados++;
                }
            }
            return $numAprobados;
        }

        public function numeroDeSuspensos(): int {
            $arrayNotas= $this->getNotas();
            $numSuspensos= 0;
            for($i= 0; $i < count($arrayNotas); $i++) {
                
                if($arrayNotas[$i] < 5) {
                    $numSuspensos++;
                }
            }
            return $numSuspensos;
        }

        public function notaMedia(): float {
            $media= 0;
            $arrayNotas= $this->getNotas();
            foreach ($arrayNotas as $nota) {
                $media+= $nota;
            }
            $media= $media/count($arrayNotas);
            return $media;
        }

        public function toString(): string {
            $listaDeNotas = "[";
            $arrayNotas= $this->getNotas();
            for($i= 0; $i < count($arrayNotas); $i++) {
                if($i == (count($arrayNotas) - 1)) {
                    $listaDeNotas .= "$arrayNotas[$i]";
                }
                else {
                    $listaDeNotas .= "$arrayNotas[$i], ";
                }
            }
            $listaDeNotas .= "]";
            return $listaDeNotas;
        }

    }

$notasDAW= new NotasDaw([5, 1, 10, 9, 8, 6]);
echo 'Las notas son: ' . $notasDAW->toString() . '<br><br>';
echo 'El nº de aprobados es: ' . $notasDAW->numeroDeAprobados() . '<br>El número de suspensos es: ' . $notasDAW->numeroDeSuspensos() . '<br>La nota media es: ' . $notasDAW->notaMedia();