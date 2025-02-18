<?php

class ExPropia extends Exception {

}

class ExPropiaClass {
    static function testNumber(float $num) {
        try {
            if($num == 0) {
                throw new ExPropia('El número no puede ser 0');
            }
            else {
                return $num;
            }
        }
        catch (ExPropia $e) {
            return $e->getMessage();
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
}

echo ExPropiaClass::testNumber(1) . '<br>' . ExPropiaClass::testNumber(0) . '<br>' . ExPropiaClass::testNumber(-1) . '<br>' . ExPropiaClass::testNumber(0.2) . '<br>' . ExPropiaClass::testNumber(-0.1) . '<br>';