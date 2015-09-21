<?php

class App {
    
    private $_objCtrl;
    
    private $_arrConf;
    
    static private $_instance;
    
    private $_appID;
    
    private function __construct()
    {
        
        $strConfFile = __DIR__ . '/../config/app.php';
        
        if (file_exists($strConfFile)) {
            $this->_arrConf = include $strConfFile;    
        } else {
            $this->_arrConf = [];
        }
        
    }

    private function __clone(){}
    
    /**
     * 
     * @return \App
     */
    public function getInstance()
    {
        if( null === self::$_instance  ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function run()
    {
        
        if ($this->_appID) {
            return;
        }
        
        session_start();
        
        $this->_appID = md5(time());
        
        App_Db::connect(include __DIR__ . '/../config/db.php');
        
        App_Auth::init();
        
        $strUrl     = preg_replace( '/\?.*$/', '', $_SERVER['REQUEST_URI']);
        
        $arrUrlPart = explode('/', $strUrl);
            
        $strCtrl    = !empty($arrUrlPart[1]) ? $arrUrlPart[1] : 'index';
        $strAction  = !empty($arrUrlPart[2]) ? $arrUrlPart[2] : 'index';
        
        $strCtrlCls = 'Ctrl_' . ucfirst(self::transUrlPart($strCtrl));
        
        $arrParam   = $_REQUEST;
        
        $arrParam['action'] = $strAction;
        
        if (! class_exists($strCtrlCls)) {
            $arrParam['action'] = '404';
            $this->_objCtrl = new Ctrl_Index('index', $arrParam);
        } else {
            $this->_objCtrl = new $strCtrlCls($strCtrl, $arrParam);
        }
        
        $this->_objCtrl->{self::transUrlPart($strAction) . 'Action'}();
        
        echo $this->_objCtrl->getView()->render();
        
    }
    
    public static function transUrlPart($strPrt)
    {
        $arrChunk = explode('-', $strPrt);
        
        array_walk($arrChunk, function(&$item, $key){
            $item = $key > 0 ? ucfirst(strtolower($item)) : strtolower($item);
        });
        
        return implode('', $arrChunk);
    }
    
    public function redirect($strUrl)
    {
        
        if (headers_sent() || empty($_SERVER["SERVER_NAME"])) {
            
            throw new Exception('Can\'t redirect to ' . $_SERVER["SERVER_NAME"] . $strUrl);
            
            return;
        }
        
        header('Status: 302');
        header('Location: http://' . $_SERVER["SERVER_NAME"] . $strUrl);
        die();
        
    }
    
    public static function getCurrentRoute()
    {
        return $_SERVER['REDIRECT_URL'];
    }
    
    /**
     *
     * @return array
     */
    public function getConf()
    {
        return $this->_arrConf;    
    }
    
    public function patch()
    {
        
        App_Db::connect(include __DIR__ . '/../config/db.php');
        
        if (class_exists('Patch')) {
            (new Patch())->run();
        }
        
    }
    
    public static function debug($mxData)
    {
        echo "<pre>" . print_r($mxData, 1) . "</pre>";
    }
    
}
