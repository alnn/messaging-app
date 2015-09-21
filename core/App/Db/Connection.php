<?php

class App_Db_Connection {

    private static $_instance;
    
    private $_connection;
    
    private function __construct(){}
    private function __clone(){}
    
    public function getInstance()
    {
        
        if (null === self::$_instance){
            self::$_instance = new self();
        }
        
        return self::$_instance;
        
    }
    
    public function connect($arrConf)
    {
        
        if ($this->isConnected()) {
            return $this;
        }
        
        try {
            
            $this->_connection = new PDO(
                "mysql:host={$arrConf['host']};dbname={$arrConf['name']}", 
                $arrConf['user'], 
                $arrConf['password']);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            
        } catch (PDOException $e) {
            
            die($e->getMessage());
            
        }
        
        return $this;
    }
    
    public function isConnected()
    {
        return is_object($this->_connection);    
    }
    
    public function get()
    {
        
        if ($this->isConnected()) {
            return $this->_connection;
        } else {
            throw new Exception('Database connection was not established');
        }
        
    }
    
}
