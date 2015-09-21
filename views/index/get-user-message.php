<?php if ($this->objUser->isBanned()) : ?>
  <h2>You are banned</h2>
<?php return; endif; ?>
<button class="btn btn-update-message-list">
  <i class="icon-refresh"></i>
  Refresh
</button>

<table class="table table-striped table-message-list" style="width:500px;">
  <thead>
    <tr>
      <th style="width:240px;"><?= $this->objUser->getFirstName(), ' ', $this->objUser->getLastName() ?></th>
      <th></th>
      <th style="width:240px;text-align:right;">
        <?= $this->objRecipient->getFirstName(), ' ', $this->objRecipient->getLastName() ?>
        <?= $this->objRecipient->isBanned() ? ' (Banned)' : '' ?>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php
        $objRowView = new App_View($this->_objCtrl, 'get-user-message-list');
        $objRowView->objUser        = $this->objUser;
        $objRowView->objRecipient   = $this->objRecipient;
        echo $objRowView->render();
     ?>
  </tbody>
</table>

<?php 
  $objRowView = new App_View($this->_objCtrl, 'get-post-message-form');
  $objRowView->objRecipient   = $this->objRecipient;
  echo $objRowView->render();
?>
