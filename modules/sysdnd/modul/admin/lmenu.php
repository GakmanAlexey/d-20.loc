<?php

namespace Modules\Sysdnd\Modul\Admin;

Class Lmenu extends \Modules\Abs\Lmenu{
    
    public function build(){

        $ico = '<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.20817 20.5834H8.6665C4.33317 20.5834 2.1665 19.5001 2.1665 14.0834V8.66675C2.1665 4.33341 4.33317 2.16675 8.6665 2.16675H17.3332C21.6665 2.16675 23.8332 4.33341 23.8332 8.66675V14.0834C23.8332 18.4167 21.6665 20.5834 17.3332 20.5834H16.7915C16.4557 20.5834 16.1307 20.7459 15.9248 21.0167L14.2998 23.1834C13.5848 24.1367 12.4148 24.1367 11.6998 23.1834L10.0748 21.0167C9.9015 20.7784 9.50067 20.5834 9.20817 20.5834Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M7.5835 8.66675H18.4168" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M7.5835 14.0833H14.0835" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>        
        ';
        
       
        \Modules\Admin\Modul\Buildermenu::add_element(
            "/",                        //Родитель   
            "dnd",              //Название на латинице
            "Днд " ,     //Название на Русском
            "dnd",              //Url адрес
            5,                          //Приоритет
            1,                          //TODO Вид действия
            $ico,                    //Иконка
            "admin"         //Привелегии
        );
        
        \Modules\Admin\Modul\Buildermenu::add_element(
            "dnd",                        //Родитель   
            "dndsource",              //Название на латинице
            "Источники Днд " ,     //Название на Русском
            "dndsource",              //Url адрес
            10,                          //Приоритет
            1,                          //TODO Вид действия
            $ico,                    //Иконка
            "admin"         //Привелегии
        );
        
        \Modules\Admin\Modul\Buildermenu::add_element(
            "dnd",                        //Родитель   
            "dndmagicitem",              //Название на латинице
            "Магические предметы " ,     //Название на Русском
            "dndmagicitem",              //Url адрес
            11,                          //Приоритет
            1,                          //TODO Вид действия
            $ico,                    //Иконка
            "admin"         //Привелегии
        );
        
 
    }
}
