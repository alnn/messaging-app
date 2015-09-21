<?php

class Ctrl_Index extends App_Ctrl_Abstr {
    
    public function indexAction()
    {
        
    }
    
    public function getUserMessageListAction()
    {
        
        $objRecipient = User::fetchById($this->getParam('user_id'));
        if (! is_object($objRecipient)) {
            App::redirect('/index/404');
        }
        
        $this->view->objRecipient   = $objRecipient;
        $this->view->objUser        = App_Auth::getInstance()->getUser();
        
    }
    
    public function getUserMessageAction()
    {
        $this->getUserMessageListAction();
    }
    
    public function postMessageAction()
    {
        
        if (! $this->_isPost()) {
            return;
        }
        
        $objRecipient = User::fetchById($this->getParam('user_id'));
        
        try {
            
            if (! is_object($objRecipient)) {
                throw new Exception('Unknown Recipient');
            }
            
            $objMessage = App_Auth::getInstance()->getUser()->postMessage($objRecipient, $this->getParam('message'));
            
        } catch(Exception $e) {
            
            $this->view->result = ['error' => $e->getMessage()];
            return;
        }
        
        $objRowView = new App_View($this, 'get-user-message-list-row');
        $objRowView->objMessage     = $objMessage;
        $objRowView->objUser        = App_Auth::getInstance()->getUser();
        $objRowView->objRecipient   = $objRecipient;
        
        $this->view->result = [
            'row' => $objRowView->render()
        ];
        
    }
    
    public function readMessageAction()
    {
        
        $objSender      = User::fetchById($this->getParam('user_id'));
        App_Auth::getInstance()->getUser()->markMessageAllRead($objSender);
        
        $objRowView     = new App_View($this, 'get-user-message-list');
        $objRowView->objUser        = App_Auth::getInstance()->getUser();
        $objRowView->objRecipient   = $objSender;
        
        $this->view->result = [
            'list' => $objRowView->render() 
        ];
    }
    
    public function editUserAction()
    {
           
        $intUserID = $this->getParam('user_id');
        
        if (empty($intUserID)) {
            $objUser = new User;
        } else {
            $objUser = User::fetchById($intUserID);
        }
        
        if (! is_object($objUser)) {
            throw new Exception('User with id = ' . $intUserID . ' does not exist');
        }
        
        $objAuthUser = App_Auth::getInstance()->getUser();
        
        if (! $objAuthUser->isAdmin() && $objAuthUser->getId() != $objUser->getId()) {
            throw new Exception('You have no permition to create new user');
        }
        
        foreach ($objUser->toArray() as $strField => $strValue) {
            if ($this->hasParam($strField)) {
                $objUser->$strField = $this->getParam($strField);   
            }
        }
        
        if (! User::isUnique($objUser)) {
            
            $this->view->result = [
                'error' => 'User with login ' . $objUser->getLogin() . ' already exist',
            ];
            
            return;
        }
        
        $objUser->save();
        
        $this->view->result = $objUser->toArray();
        
    }
    
    public function removeUserAction()
    {
        
        $intUserID      = $this->getParam('user_id');
        $objAuthUser    = App_Auth::getInstance()->getUser();
        
        $objUser        = User::fetchById($intUserID);
        if (! is_object($objUser)) {
            throw new Exception('User with id = ' . $intUserID . ' does not exist');
        }
        
        if ($objUser->getId() == $objAuthUser->getId()) {
            throw new Exception('You can not remove user with id = ' . $intUserID);
        }
        
        $objUser->cleanMessageList(); 
        
        $objUser->delete();
        
        $this->view->result = [];
    }
    
    public function getUserEditFormAction()
    {
        
        $this->view->objUser = User::fetchById($this->getParam('user_id'));
        if (! is_object($this->view->objUser)){
            $this->view->objUser = new User;
        }
        
    }
    
    public function getUserListRowAction()
    {
        $this->getUserEditFormAction();
    }
    
    public function profileAction()
    {
    
        $this->view->objUser = App_Auth::getInstance()->getUser();
    
    }
    
}
