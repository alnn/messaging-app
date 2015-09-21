<?php

class App_View {
    
    private $_objCtrl;
    private $_strName;
    private $_strContent;
    private $_objLayout;
    private $_strPath;
    
    public function __construct($objCtrl, $strName, $strLayout='') 
    {
        
        $this->_objCtrl     = $objCtrl;
        $this->_strName     = $strName;
        
        if (! empty($strLayout)) {
            $this->_objLayout   = new App_View($objCtrl, $strLayout);
            $this->_objLayout->setPath(__DIR__ . '/../../views/');
        }
        
    }
    
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : '';
    }
    
    public function render($strContent = '')
    {
        
        if ($this->_strContent) {
            return $this->_strContent;
        }
        
        if (null === $this->_strPath) {
            $this->_strPath = __DIR__ . '/../../views/' . $this->_objCtrl->getID() . '/';
        }
        
        $strViewFile = $this->_strPath . $this->_strName . '.php';
        
        if (! file_exists($strViewFile)) {
            $strViewFile = $this->_strPath . '404.php';
            if (! file_exists($strViewFile)) {
                throw new Exception("View for 404 page was not provided \n Path: " . $this->_strPath);
            }
        }
        
        ob_start();
        
        require $strViewFile;
        
        $this->_strContent = ob_get_contents();
        
        ob_end_clean();
        
        if (is_object($this->_objLayout)) {
            $this->_strContent = $this->_objLayout->render($this->_strContent);
        }
        
        return $this->_strContent;
    }
    
    public function getParam($strParam, $strDefault = '')
    {
        return $this->_objCtrl->getParam($strParam, $strDefault);    
    }
    
    public function setPath($strPath)
    {
        $this->_strPath = $strPath;    
    }
    
    public function getPath()
    {
        return $this->_strPath;
    }
    
    public function ignoreLayout()
    {
        $this->_objLayout = null;    
    }
    
}