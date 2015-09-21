<?php

abstract class App_Ctrl_Abstr
{
    
    protected $_strID;
    protected $view;
   
    /**
     * 
     * @return boolean
     */
    protected function _isPost()
    {
        $strRequestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
        return ($strRequestMethod == 'POST' || $strRequestMethod == 'PUT');
    }

    public function __construct($strID, $arrParam = [])
    {
        
        $this->_strID = $strID;
        $this->_arrParams = $arrParam;

        if (! isset($arrParam['layout'])) {
            $arrParam['layout'] = 'layout';
        }

        $this->view = new App_View($this, $arrParam['action'], $arrParam['layout']);
        
        if ($this->_isPost()) {
            $this->view->ignoreLayout();
        }
        
    }
    
    public function getView()
    {
        return $this->view;
    }
    
    public function getParam($strParam, $strDefault = '')
    {
        return isset($this->_arrParams[$strParam]) ? $this->_arrParams[$strParam] : $strDefault;  
    }
    
    public function hasParam($strParam)
    {
        return isset($this->_arrParams[$strParam]);
    }
    
    public function getID()
    {
        return $this->_strID;    
    }
    
    public function __call($strMethod, $arrArgument) 
    {
        
        if ('Action' === substr($strMethod, -6)) {
            
        }
        
    }
    
}
