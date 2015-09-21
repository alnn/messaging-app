<?php

  $arrUser = App_Auth::getInstance()->getUser()->getRecipientArray();
  
  foreach ($arrUser as $intKey => $objUser) {
  
    $objRowView           = new App_View($this->_objCtrl, 'get-user-list-row');
    $objRowView->objUser  = $objUser;
    echo $objRowView->render();
    
  }
  