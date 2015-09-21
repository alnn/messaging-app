<?php

interface App_User_Interface {
    
    public function getId();
    
    public static function fetchById($intID);
    
    public static function getByLoginPassword($strLogin, $strPassword);
    
}
