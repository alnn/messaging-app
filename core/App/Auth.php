<?php

class App_Auth {
    
    private static $_instance;
    
    private $_objUser;
    
    public static function init()
    {
        
        $objAuth = self::getInstance();
        
        if (App::getCurrentRoute() == '/auth/signout') {
            self::getInstance()->signOut();
        }
        
        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['signin'])) {
            
            $strUserCls = self::getUserClass();
            
            $objUser = $strUserCls::getByLoginPassword($_POST['login'], $_POST['password']);
            
            if (is_object($objUser)) {
                
                self::getInstance()->signIn($objUser);
                
            }
            
        }
        
        if (! is_object($objAuth->getUser()) && App::getCurrentRoute() !== '/auth/index') {
            App::redirect('/auth/index');   
        }
        
    }
    
    private function __construct(){}
    
    public function getInstance()
    {
        
        if (null === self::$_instance) {
            self::$_instance = new self();
            
            if (! empty($_SESSION['user'])) {
                
                $strUserCls = self::getUserClass();
                self::$_instance->_objUser = $strUserCls::fetchById($_SESSION['user']);
                
            }
            
        }
        
        return self::$_instance;
        
    }
    
    public function signIn($objUser)
    {
        
        $_SESSION['user'] = $objUser->getId();    
        
        App::redirect('/index/profile');
    }
    
    public function signOut()
    {
        unset($_SESSION['user']);
        
        App::redirect('/auth/index');
    }
    
    public function getUser()
    {
        return $this->_objUser;    
    }
    
    /**
     * 
     * @return boolean
     */
    public function isAuthorized()
    {
        return is_object($this->_objUser);
    }
    
    public static function getUserClass()
    {
        
        $arrCnf = App::getInstance()->getConf();
            
        $strUserCls = isset($arrCnf['auth_user_class']) ? $arrCnf['auth_user_class'] : 'User';
        
        if (! ((new $strUserCls) instanceof App_User_Interface)) {
            throw new Exception('User class must implements App_User_Interface');
        }
        
        return $strUserCls;
        
    }
    
}
