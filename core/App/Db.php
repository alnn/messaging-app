<?php

abstract class App_Db {
    
    public static function connect($arrConf) 
    {
        App_Db_Connection::getInstance()->connect($arrConf);
    }
    
    public static function read($strQuery, $arrBind = [])
    {
        
        self::addQuote($arrBind);
        
        $objConn        = App_Db_Connection::getInstance()->get();
        $objStatement   = $objConn->prepare($strQuery);
        $objStatement->execute($arrBind);
        
        return $objStatement;
    }
    
    public static function write($strQuery, $arrBind = [])
    {
        
        self::addQuote($arrBind);
        
        $objConn        = App_Db_Connection::getInstance()->get();
        
        $objStatement   = $objConn->prepare($strQuery);
        $objStatement->execute($arrBind);
        
        return $objConn;
    }
    
    private static function addQuote(&$arrBind)
    {
        foreach ($arrBind as $key => $val) {
            $arrBind[$key] = self::quote($val);
        }
    }
    
    private static function quote($strValue)
    {
        
        if (is_int($strValue)) {
            return $strValue;
        } elseif (is_float($strValue)) {
            return sprintf('%F', $strValue);
        }
        
        return addcslashes($strValue, "\000\n\r\\'\"\032");
        
    }
    
}
