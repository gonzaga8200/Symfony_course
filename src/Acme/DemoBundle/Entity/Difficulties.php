<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Difficulties
 *
 * @author Gonzaga
 */

namespace Acme\DemoBundle\Entity;
class Difficulties {
    CONST UNKNOWN = 'Desocnocido';
    CONST EASY = 'Facil';
    CONST NORMAL = 'Medio';
    CONST HARD = 'Dificil';
    
    public static function toArray (){
        return array(
            self::UNKNOWN => self::UNKNOWN,
            self::EASY=> self::EASY,
            self::NORMAL=>self::NORMAL,
            self::HARD=>self::HARD
        );
        
    }
}

?>
