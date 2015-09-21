<?php

  $arrMesssage = $this->objUser->getMessageArray($this->objRecipient->getId());
  
  foreach ($arrMesssage as $objMessage) {
  
    $objRowView = new App_View($this->_objCtrl, 'get-user-message-list-row');
    $objRowView->objMessage     = $objMessage;
    $objRowView->objUser        = $this->objUser;
    $objRowView->objRecipient   = $this->objRecipient;
    echo $objRowView->render();
      
  }
  
?>