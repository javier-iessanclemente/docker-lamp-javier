<?php 
    function conectar() {
        try {
            $conPDO = new PDO("mysql:host=db;dbname=donacion", "root", "test");
            //  Forzar excepciones
            $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Conexión correcta';
          } catch(PDOException $e) {
            echo 'Fallo en conexión: ' . $e->getMessage();
          }
    }

    function desconectar() {
        $conPDO= null;
    }

    function registrarDonante($nombre, $apellidos, $edad, $grupo_sanguineo, $cod_postal, $tel) {

    }

    function visualizarDonantes($id) {

    }

    function eliminarDonante($id) {

    }

    function registrarDonacion($donante, $fecha_donacion, $fecha_proxima) {

    }

    function visualizarDonaciones($id_donante) {
        
    }

    function borrarDonacion($id) {
        
    }
?>