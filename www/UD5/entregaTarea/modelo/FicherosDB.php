<?php
require_once(__DIR__ . '/Fichero.php');
require_once(__DIR__ . '/Tarea.php');
require_once(__DIR__ . '/Usuario.php');
require_once(__DIR__ . '/mysqli.php');
interface FicherosDBInt {
    public function listaFicheros($id_tarea): array;
    public function buscaFichero($id): Fichero;
    public function borraFichero($id): bool;
    public function nuevoFichero($fichero): bool;
}

class FicherosDBImp implements FicherosDBInt {
    public function listaFicheros($id_tarea): array {
        try {
            $conexion = conectaFicheros();
            if ($conexion->connect_error) {
                throw new DatabaseException($conexion->error, 'listaFicheros');
            }
            else {
                $sql = "SELECT * FROM ficheros WHERE id_tarea = " . $id_tarea;
                $resultados = $conexion->query($sql);
                if ($resultados->num_rows >= 1) {
                    $ficheros= [];
                    for($i= 0; $i < $resultados->num_rows; $i++) {
                        $resultado= $resultados->fetch_assoc();
    
                        $fichero= new Fichero();
                        $fichero->setId($resultado['id']);
                        $fichero->setNombre($resultado['nombre']);
                        $fichero->setFile(['ruta' => $resultado['file']]);
                        $fichero->setDescripcion($resultado['descripcion']);
                        
                        $tarea= new Tarea();
                        $tarea->setId($resultado['id_tarea']);
                        
                        $fichero->setTarea($tarea);
                        array_push($ficheros, $fichero);
                    }
                    return [true, $ficheros];
                }
                else {
                    return [];
                }
            }
        }
        catch (mysqli_sql_exception $e) {
            if(isset($sql)) {
                throw new DatabaseException($e->getMessage(), 'buscaFicherosTarea', $sql);
            }
            else {
                throw new DatabaseException($e->getMessage(), 'buscaFicherosTarea');
            }
            
            return [false];
        }
        finally {
            if(isset($conexion)) {
                cerrarConexion($conexion);
            }
        }
    }

    public function buscaFichero($id): Fichero {
        try {
            $conexion = conectaTareas();
            if ($conexion->connect_error) {
                throw new DatabaseException($conexion->error, 'buscaFichero');
            }
            else {
                $sql = "SELECT * FROM ficheros WHERE id = " . $id;
                $resultados = $conexion->query($sql);
                if ($resultados->num_rows == 1) {
                    $ficheros= [];
                    for($i= 0; $i < $resultados->num_rows; $i++) {
                        $resultado= $resultados->fetch_assoc();
    
                        $fichero= new Fichero();
                        $fichero->setId($resultado['id']);
                        $fichero->setNombre($resultado['nombre']);
                        $fichero->setFile(['ruta' => $resultado['file']]);
                        $fichero->setDescripcion($resultado['descripcion']);
                        $tarea= new Tarea();
                        $tarea->setId($resultado['id_tarea']);
                        $fichero->setTarea($tarea);
                        return $fichero;
                    }
                }
                else {
                    throw new DatabaseException('No se pudo encontrar el fichero.', 'borrarFichero', $sql);
                }
            }
        }
        catch (mysqli_sql_exception $e) {
            if(isset($sql)) {
                throw new DatabaseException($e->getMessage(), 'buscaFichero', $sql);
            }
            throw new DatabaseException($e->getMessage(), 'buscaFichero');
        }
        finally {
            if(isset($conexion)) {
                cerrarConexion($conexion);
            }
        }
    }
    
    public function borraFichero($id): bool {
        try {
            $conexion = conectaFicheros();
    
            if ($conexion->connect_error)
            {
                throw new DatabaseException($conexion->error, 'borrarFichero');
            }
            else
            {
                $fichero= $this->buscaFichero($id);
                if(unlink($fichero->getFile()['ruta'])) {
                    $sql = "DELETE FROM ficheros WHERE id = " . $id;
                    if ($conexion->query($sql))
                    {
                        return true;
                    }
                    else {
                        throw new DatabaseException('No se pudo borrar el fichero.', 'borrarFichero', $sql);
                        return false;
                    }
                }
                else {
                    throw new DatabaseException('No se pudo borrar el fichero.', 'borrarFichero');
                    return false;
                }
                
            }
            
        }
        catch (mysqli_sql_exception $e) {
            if(isset($sql)) {
                throw new DatabaseException($e->getMessage(), 'borrarFichero', $sql);
            }
            else {
                throw new DatabaseException($e->getMessage(), 'borrarFichero');
            }
            return false;
        }
        finally
        {
            if(isset($conexion)) {
                cerrarConexion($conexion);
            }
        }
    }

    public function nuevoFichero($fichero): bool {
        try {
            $conexion = conectaFicheros();
            
            if ($conexion->connect_error)
            {
                throw new DatabaseException($conexion->error, 'nuevoFichero');
            }
            else
            {
                $archivo= $fichero->getFile();
                $nombre= $fichero->getNombre();
                $descripcion= $fichero->getDescripcion();
                $tarea_id= $fichero->getTarea()->getId();
                $directorio = "../files/";
                $archivo["name"]= bin2hex(random_bytes(8));
                $rutaArchivo = $directorio . $archivo["name"];
                if(move_uploaded_file($archivo["tmp_name"], $rutaArchivo)) {
                    $stmt = $conexion->prepare("INSERT INTO ficheros (nombre, descripcion, file, id_tarea) VALUES (?,?,?,?)");
                    $stmt->bind_param("sssi", $nombre, $descripcion, $rutaArchivo, $tarea_id);
    
                    $stmt->execute();
    
                    return true;
                }
                else {
                    throw new DatabaseException('El fichero no pudo ser guardado correctamente', 'nuevoFichero');
                    return false;
                }
            }
        }
        catch (mysqli_sql_exception $e)
        {
            if(isset($stmt)) {
                throw new DatabaseException($e->getMessage(), 'nuevoFichero', mysqli_stmt_sqlstate($stmt));
            }
            else {
                throw new DatabaseException($e->getMessage(), 'nuevoFichero');
            }
            return false;
        }
        finally
        {
            if(isset($conexion)) {
                cerrarConexion($conexion);
            }
        }
    }

}