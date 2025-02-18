<?php

class Data
{
    private static string $calendario = "Calendario gregoriano";
    private static $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    private static $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    public static function getCalendar(): string {
        return 'Usamos el calendario: ' . Data::$calendario;
    }

    public static function getHora(): string {
        return date('H') . ':' . date('i') . ':' . date('s');
    }

    
    public static function getData(): string 
    {
        $ano = date('Y'); //Nos da el año actual 
        $mes = date('m');
        $dia = date('d');
        $diaSemana= $dia/7;
        return Data::$dias[intval($diaSemana)] . ' ' . $dia . ' de ' . Data::$meses[intval($mes) - 1] . ' del ' . $ano;
    }

    public static function getDataHora(): string {
        return 'Hoy es ' . Data::getData() . ' y son las ' . Data::getHora();
    }
}
echo Data::getCalendar() . '<br>';
echo Data::getDataHora() . '<br>';