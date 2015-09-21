<?php

class User extends App_Db_Row implements App_User_Interface {
    
    private $_arrMessage = [];
    
    public static function fetchById($intID)
    {
        
        $arrRow = App_Db::read("SELECT * FROM user WHERE id = :id LIMIT 1", [
            ':id' => $intID,
        ])->fetch(PDO::FETCH_ASSOC);
        
        if (empty($arrRow)) {
            return;
        }
        
        return new User($arrRow);

    }
    
    public static function getByLoginPassword($strLogin, $strPassword)
    {
        
        $arrRow = App_Db::read("SELECT * FROM user WHERE login = :login AND password = :password", [
            ':login' => $strLogin,
            ':password' => $strPassword,
        ])->fetch(PDO::FETCH_ASSOC);
        
        if (empty($arrRow)) {
            return;
        }
        
        return new User($arrRow);
        
    }
    
    public static function isUnique(User $objUser) 
    {
        
        $arrRow = App_Db::read("SELECT count(*) AS total FROM user WHERE login = :login AND id <> :id", [
            ':login' => $objUser->getLogin(),
            ':id' => $objUser->getId(),
        ])->fetch(PDO::FETCH_ASSOC);
        
        return $arrRow['total'] == 0;
        
    }
    
    public function getFirstName()
    {
        return $this->first_name;        
    }
    
    public function getLastName()
    {
        return $this->last_name;
    }

    public function isBanned()
    {
        return (boolean) $this->ban;
    }

    public function getLogin()
    {
        return $this->login;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function isAdmin()
    {
        return (boolean) $this->admin;
    }
    
    public function getRecipientArray($bActive = false)
    {
        
        $arrRecipient = [];
        
        $arrResult = App_Db::read('SELECT * FROM user WHERE id <> :id', [
            ':id' => $this->getId()
        ])->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($arrResult as $arrRow) {
            array_push($arrRecipient, new User($arrRow));
        }
        
        return $arrRecipient;
         
    }
    
    public function getMessageArray($intUserID = 0, $bUnread = false) 
    {
        
        $strKey = $intUserID . '-'. ((string) $bUnread);
        
        if (isset($this->_arrMessage[$strKey])) {
            return $this->_arrMessage[$strKey];
        }
            
        $arrMessage = [];
        
        $arrBind    = [];
        
        $strQuery   = 'SELECT * FROM message WHERE';
        
        if ($bUnread) {
            
            $arrBind[':my_id']      = $this->getId();
            $strQuery .= ' (recipient_id = :my_id)';
            
            if ($intUserID) {
                $arrBind[':user_id']   = $intUserID;
                $strQuery .= ' AND (sender_id = :user_id)';
            }
            
            $strQuery .= ' AND unread = 1';
            
        } else {
            
            $arrBind[':my_id']      = $this->getId();
            $strQuery .= ' (sender_id = :my_id OR recipient_id = :my_id)';
            
            if ($intUserID) {
                $arrBind[':user_id']   = $intUserID;
                $strQuery .= ' AND (sender_id = :user_id OR recipient_id = :user_id)';
            }
            
        }
       
        $arrResult = App_Db::read(
            $strQuery, 
            $arrBind
        )->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($arrResult as $arrRow) {
            array_push($arrMessage, new Message($arrRow));
        }
        
        $this->_arrMessage[$strKey] = $arrMessage;
        
        return $arrMessage;
    }
    
    /**
     *
     * @return Message
     */
    public function postMessage(User $objRecipient, $strContent)
    {
        
        $strContent = trim($strContent);
        
        if ($objRecipient->isBanned() || $objRecipient->getId() == $this->getId()) {
            throw new Exception('Can\'t send message to ' . $objRecipient->getLogin());    
        }
        
        if (empty($strContent)) {
            throw new Exception('Can\'t send empty message to ' . $objRecipient->getLogin());  
        }
        
        $objMessage = new Message([
            'sender_id'     => $this->getId(),
            'recipient_id'  => $objRecipient->getId(),
            'unread'        => 1,
            'message'       => $strContent,
        ]);
        
        $objMessage->save();
        
        return $objMessage;
        
    }
    
    public function markMessageAllRead(User $objSender)
    {
        
        App_Db::write("UPDATE message SET unread=0 WHERE sender_id = :sender_id AND recipient_id = :recipient_id",[
            ':recipient_id' => $this->getId(),
            ':sender_id' => $objSender->getId(),
        ]);
        
    }
    
    public function cleanMessageList()
    {
        
        foreach ($this->getMessageArray() as $objMessage) {
            $objMessage->delete();
        }
        
    }
    
}
