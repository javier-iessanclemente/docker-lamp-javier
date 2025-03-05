<?php
require_once(__DIR__ . '/../modelo/Tarea.php');
require_once(__DIR__ . '/../modelo/Usuario.php');

function conectaPDO()
{
    $servername = $_ENV['DATABASE_HOST'];
    $username = $_ENV['DATABASE_USER'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $dbname = $_ENV['DATABASE_NAME'];

    $conPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conPDO;
}

function listaUsuarios()
{
    try {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, username, nombre, apellidos, rol FROM usuarios');
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll();
        $usuarios= [];
        foreach ($resultados as $key => $resultado) {
            $usuario= new Usuario();
            $usuario->setId($resultado['id'] );
            $usuario->setUsername($resultado['username']);
            $usuario->setNombre($resultado['nombre']);
            $usuario->setApellidos($resultado['apellidos']);
            $usuario->setRol($resultado['rol']);
            array_push($usuarios, $usuario);
        }
        return [true, $usuarios];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
    
}

function listaTareasPDO($tarea)
{
    try {
        $id_usuario= $tarea->getUsuario()->getId();
        
        $con = conectaPDO();
        $sql = 'SELECT * FROM tareas WHERE id_usuario = ' . $id_usuario;
        if (($tarea->getEstado() !== null) && !empty($tarea->getEstado()))
        {
            $estado= $tarea->getEstado();
            $sql = $sql . " AND estado = '" . $estado . "'";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $tareas = array();
        while ($row = $stmt->fetch())
        {
            $usuario= new Usuario();
            $usuario->setId($id_usuario);
            $resultadoUsuario = buscaUsuario($usuario);
            
            $tarea= new Tarea();
            $tarea->setId($row['id']);
            $tarea->setTitulo($row['titulo']);
            $tarea->setDescripcion(filtraCampo($row['descripcion']));
            $tarea->setEstado(filtraCampo($row['estado']));
            $usuario->setId($row['id_usuario']);
            $tarea->setUsuario($resultadoUsuario);

            array_push($tareas, $tarea);
        }
        return [true, $tareas];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
    
}

function nuevoUsuario(Usuario $usuario)
{
    try{
        $nombre= $usuario->getNombre();
        $apellidos= $usuario->getApellidos();
        $username= $usuario->getUsername();
        $contrasena= $usuario->getContrasena();
        $rol= $usuario->getRol();
        $con = conectaPDO();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, username, contrasena, rol) VALUES (:nombre, :apellidos, :username, :contrasena, :rol)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':username', $username);
        $hash= password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $hash);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function actualizaUsuario(Usuario $usuario)
{
    try{
        $con = conectaPDO();
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, username = :username, rol = :rol";

        if (isset($contrasena))
        {
            $sql = $sql . ', contrasena = :contrasena';
        }

        $sql = $sql . ' WHERE id = :id';

        $id= $usuario->getId();
        $nombre= $usuario->getNombre();
        $apellidos= $usuario->getApellidos();
        $username= $usuario->getUsername();
        $rol= $usuario->getRol();

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':rol', $rol);
        if(isset($contrasena)) {
            $contrasena= $usuario->getContrasena();
            $hash= password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt->bindParam(':contrasena', $hash);
        }
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function borraUsuario(Usuario $usuario)
{
    try {
        $con = conectaPDO();

        $con->beginTransaction();

        $id= $usuario->getId();
        $stmt = $con->prepare('DELETE FROM tareas WHERE id_usuario = ' . $id);
        $stmt->execute();
        $stmt = $con->prepare('DELETE FROM usuarios WHERE id = ' . $id);
        $stmt->execute();
        
        return [$con->commit(), ''];
    }
    catch (PDOExcetion $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function buscaUsuario(Usuario $usuario)
{

    try
    {
        $id= $usuario->getId();
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT * FROM usuarios WHERE id = ' . $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1)
        {
            $resultado= $stmt->fetch();
            $usuario= new Usuario();
            $usuario->setId($resultado['id']);
            $usuario->setUsername($resultado['username']);
            $usuario->setNombre($resultado['nombre']);
            $usuario->setApellidos($resultado['apellidos']);
            $usuario->setContrasena($resultado['contrasena']);
            $usuario->setRol($resultado['rol']);
            return $usuario;
        }
        else
        {
            return null;
        }
    }
    catch (PDOExcetion $e)
    {
        return null;
    }
    finally
    {
        $con = null;
    }
    
}

function ValidaUsuario($nombre, $contrasena)
{

    try
    {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT * FROM usuarios WHERE username = "' . $nombre . '"');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() >= 1)
        {
            $resultados= $stmt->fetchAll();
            foreach($resultados as $resultado) {
                if(password_verify($contrasena, $resultado['contrasena'])) {
                    return [true, $resultado];
                }
            }

            return [false, "Contraseña no existe"];
        }
        else
        {
            return [false, "Usuario no existe"];
        }
    }
    catch (PDOExcetion $e)
    {
        return [false, $e.getMessage()];
    }
    finally
    {
        $con = null;
    }
    
}