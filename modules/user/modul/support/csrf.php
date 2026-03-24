<?php
namespace Modules\User\Modul\Support;

class Csrf
{
    //Modules\User\Modul\Support\Csrf::validate($fieldToken);
    public static function validate($fieldToken){
        if (!\Modules\Core\Modul\Csrftoken::validateToken($fieldToken)) {
            return false;
        }
        return true;
    }
}