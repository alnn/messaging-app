<?php
    if (! App_Auth::getInstance()->getUser()->isAdmin()) : 
?>
  <h2>You have no permitions here</h2>
<?php return; endif; ?>

<table class="table table-hover table-user-list">
  <thead>
    <tr>
      <th>ID #</th>
      <th>Login</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Admin</th>
      <th>Banned</th>
      <th>Password</th>
      <th style="width:120px;"></th>
    </tr>
  </thead>
  <tbody>
    <?php
        $objRowView = new App_View($this->_objCtrl, 'get-user-list');
        echo $objRowView->render();
    ?>
    
    <?php
      $objRowView = new App_View($this->_objCtrl, 'get-user-edit-form');
      $objRowView->objUser = new User;
      echo $objRowView->render();
    ?>
    
  </tbody>
</table>
