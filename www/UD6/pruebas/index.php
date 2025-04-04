<?php

declare(strict_types=1);

require_once 'flight/Flight.php';
//require 'flight/autoload.php';

Flight::route('/', function () {
    echo 'hello world!';
});

Flight::route('/saludar', function () {
    echo 'Hola, bienvenido al módulo de DWCS!';
});

Flight::start();

