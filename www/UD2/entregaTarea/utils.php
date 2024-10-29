<?php 

# Creación de la variable global del array $listaTareas: 
if(!isset($listaTareas)) {
    $listaTareas= [['id' => 1, 'descripcion' => "Descripcion", 'estado' => "pendiente"], ['id' => 2, 'descripcion' => "Descripcion 2", 'estado' => "en proceso"]];
}

# Función que retorna el contenido del array de las tareas: 
function devolverLista () {
    global $listaTareas;
    foreach ($listaTareas as $tarea) {
        echo '<tr>';
            echo '<td>'. $tarea['id'] . '</td>';
            echo '<td>'. $tarea['descripcion'] . '</td>';
            echo '<td>'. $tarea['estado'] . '</td>';
        echo '</tr>';
    }
}

# Función que filtra el contenido del campo introducido: 
function filtrarContenidoCampo ($campo) {
    $campo= trim($campo);
    $campo = htmlspecialchars($campo, ENT_COMPAT, "ISO-8859-1");
    $campo= stripslashes($campo);
    echo $campo . '<br>';
    if(preg_match('/[^a-zA-Z0-9\s{1,}]/', $campo)) {
        $campo= preg_replace('/[^a-zA-Z0-9\s{1,}]/', '', $campo);
    }
    if(preg_match('/\s{2,}/', $campo)) {
        $campo= preg_replace('#\s+#', ' ', $campo);
    }
    return $campo;
}

# Función que comprueba si los datos del campo son validos incluyendo una variable $esId para saber si el campo introducido es el id: 
function validarCampo ($campo, $esId) {
    $campo= filtrarContenidoCampo($campo);
    if(empty($campo)) {
        return false;
    }
    else {
        if($esId) {
            if(!is_numeric($campo) || $campo < 1) {
                return false;
            }
            global $listaTareas;
            foreach($listaTareas as $tarea) {
                if($tarea['id'] == $campo) {
                    return false;
                }
            }
        } 
        else {
            if(is_numeric($campo)) {
                return false;
            }
        }
    }
    return true;
}

# Función que guarda los campos dentro de la lista: 
function guardarTarea ($id, $descripcion, $estado) {
    global $listaTareas;
    if(validarCampo($id, true) && validarCampo($descripcion, false) && validarCampo($estado, false)) {
        $arrayCampo= [];
        $arrayCampo += ["id" => filtrarContenidoCampo($id), "descripcion" => filtrarContenidoCampo($descripcion), "estado" => filtrarContenidoCampo($estado)];
        $listaTareas[]= $arrayCampo;
        return true;
    }
    else {
        return false;
    }
}
?>