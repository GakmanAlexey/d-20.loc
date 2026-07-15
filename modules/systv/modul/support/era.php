<?php
namespace Modules\Systv\Modul\Support;

class Era
{
    public static $isLoad = false;
    public static function getNameFromId(int $idEra){
        if(!self::$isLoad){self::loadAllEra();}
        
    }
    public static function loadAllEra(){
        //Загрузить все еры

    }
}
