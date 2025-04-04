<?php

declare(strict_types=1);

require_once 'flight/Flight.php';
//require 'flight/autoload.php';

Flight::route('/', function () {
    echo 'Usa ThunderCloud para acceder a las diferentes opciones con el metodo correcto (GET, POST, DELETE..)';
});

Flight::route('GET /clientes', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from clientes");
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('GET /clientes/@id', function ($id)
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from clientes WHERE id=" . $id);
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /clientes', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $nombre= Flight::request()->data->nombre;
    $apellidos= Flight::request()->data->apellidos;
    $edad= Flight::request()->data->edad;
    $email= Flight::request()->data->email;
    $telefono= Flight::request()->data->telefono;
    $sql= 'INSERT INTO clientes(nombre, apellidos, edad, email, telefono) VALUES (:nombre, :apellidos, :edad, :email, :telefono)';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':nombre', $nombre);
    $setencia->bindParam(':apellidos', $apellidos);
    $setencia->bindParam(':edad', $edad);
    $setencia->bindParam(':email', $email);
    $setencia->bindParam(':telefono', $telefono);

    $setencia->execute();

    Flight::json(['Cliente agregado correctamente']);
});

Flight::route('DELETE /clientes', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $sql= "DELETE FROM clientes WHERE id=?";
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(1, $id);

    $setencia->execute();

    Flight::json(['Cliente de id ' . $id . ' ha sido borrado correctamente']);
});

Flight::route('GET /hoteles', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from hoteles");
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('PUT /clientes', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $apellidos= Flight::request()->data->apellidos;
    $edad= Flight::request()->data->edad;
    $email= Flight::request()->data->email;
    $telefono= Flight::request()->data->telefono;
    $sql= 'UPDATE clientes set apellidos=:apellidos, edad=:edad, email=:email, telefono=:telefono WHERE id=:id';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':id', $id);
    $setencia->bindParam(':apellidos', $apellidos);
    $setencia->bindParam(':edad', $edad);
    $setencia->bindParam(':email', $email);
    $setencia->bindParam(':telefono', $telefono);

    $setencia->execute();

    Flight::json(['Cliente de id ' . $id . ' modificado correctamente']);
});

Flight::route('GET /hoteles/@id', function ($id)
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from hoteles WHERE id=" . $id);
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /hoteles', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $hotel= Flight::request()->data->hotel;
    $direccion= Flight::request()->data->direccion;
    $telefono= Flight::request()->data->telefono;
    $email= Flight::request()->data->email;
    $sql= 'INSERT INTO hoteles(hotel, direccion, telefono, email) VALUES (:hotel, :direccion, :telefono, :email)';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':hotel', $hotel);
    $setencia->bindParam(':direccion', $direccion);
    $setencia->bindParam(':telefono', $telefono);
    $setencia->bindParam(':email', $email);

    $setencia->execute();

    Flight::json(['Hotel agregado correctamente']);
});

Flight::route('DELETE /hoteles', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $sql= 'DELETE FROM hoteles WHERE id=?';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(1, $id);

    $setencia->execute();

    Flight::json(['Hotel de id ' . $id . ' ha sido borrado correctamente']);
});

Flight::route('PUT /hoteles', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $direccion= Flight::request()->data->direccion;
    $telefono= Flight::request()->data->telefono;
    $email= Flight::request()->data->email;
    $sql= 'UPDATE hoteles set direccion=:direccion, telefono=:telefono, email=:email WHERE id=:id';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':id', $id);
    $setencia->bindParam(':direccion', $direccion);
    $setencia->bindParam(':telefono', $telefono);
    $setencia->bindParam(':email', $email);

    $setencia->execute();

    Flight::json(['Hotel de id ' . $id  . ' modificado correctamente']);
});

Flight::route('GET /reservas', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from reservas");
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('GET /reservas/@id', function ($id)
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $setencia = Flight::db()->prepare("SELECT * from reservas WHERE id=" . $id);
    $setencia->execute();
    $datos=$setencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /reservas', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id_cliente= Flight::request()->data->id_cliente;
    $id_hotel= Flight::request()->data->id_hotel;
    $fecha_reserva= Flight::request()->data->fecha_reserva;
    $fecha_entrada= Flight::request()->data->fecha_entrada;
    $fecha_salida= Flight::request()->data->fecha_salida;
    $sql= 'INSERT INTO reservas(id_cliente, id_hotel, fecha_reserva, fecha_entrada, fecha_salida) VALUES (:id_cliente, :id_hotel, :fecha_reserva, :fecha_entrada, :fecha_salida)';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':id_cliente', $id_cliente);
    $setencia->bindParam(':id_hotel', $id_hotel);
    $setencia->bindParam(':fecha_reserva', $fecha_reserva);
    $setencia->bindParam(':fecha_entrada', $fecha_entrada);
    $setencia->bindParam(':fecha_salida', $fecha_salida);

    $setencia->execute();

    Flight::json(['Reserva agregada correctamente']);
});

Flight::route('DELETE /reservas', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $sql= 'DELETE FROM reservas WHERE id=?';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(1, $id);

    $setencia->execute();

    Flight::json(['Reserva de id ' . $id . ' ha sido borrada correctamente']);
});

Flight::route('PUT /reservas', function ()
{
    Flight::register('db', 'PDO', array('mysql:host=db;dbname=pruebas','root','test'));
    $id= Flight::request()->data->id;
    $fecha_entrada= Flight::request()->data->fecha_entrada;
    $fecha_salida= Flight::request()->data->fecha_salida;
    $sql= 'UPDATE reservas set fecha_entrada=:fecha_entrada, fecha_salida=:fecha_salida WHERE id=:id';
    $setencia= Flight::db()->prepare($sql);
    $setencia->bindParam(':id', $id);
    $setencia->bindParam(':fecha_entrada', $fecha_entrada);
    $setencia->bindParam(':fecha_salida', $fecha_salida);

    $setencia->execute();

    Flight::json(['Reserva de id ' . $id . ' modificada correctamente']);
});

Flight::start();
