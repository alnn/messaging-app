<?php

class Ctrl_Auth extends App_Ctrl_Abstr {
    
    public function __construct($strID, $arrParam)
    {
        
        parent::__construct($strID, $arrParam);
        
        $this->view->ignoreLayout();
        
    }
    
    public function indexAction()
    {
    }
    
    public function loginAction()
    {
        
    }
    
}
