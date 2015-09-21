<?php

class Message extends App_Db_Row {
    
    public function getSenderId()
    {
        return $this->sender_id;
    }
    
    public function getSender()
    {
        if ($this->getSenderId()) {
            $objConn        = Application::getInstance()->getConnection();
            $objStatement   = $objConn->prepare("SELECT * FROM user WHERE id = :id");
            $objStatement->execute(array(":id" => $this->getUserId()));
            $arrRow         = $objStatement->fetch( PDO::FETCH_ASSOC );
        }else{
            $arrRow["login"] = "Admin";
        }
        
        return new User($arrRow);
    }
    
    public function getRecipientId()
    {
        return $this->recipient_id;
    }
    
    public function getContent()
    {
        return stripslashes($this->message);
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function isUnread()
    {
        return (boolean) $this->unread;    
    }
    
}