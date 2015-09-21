<?php $objUser = $this->objUser ?>
<tr class="tr-edit-user" data-id="<?= $objUser->getId() ?>">
  <th>
    <button type="button" class="btn btn-default btn-save">
      <span class="glyphicon glyphicon-floppy-save"></span> 
    </button>
  </th>
  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="user-login" name="login" placeholder="Login" value="<?= $objUser->getLogin() ?>">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="user-firt-name" name="first_name" placeholder="First Name" value="<?= $objUser->getFirstName() ?>">
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="user-last-name" name="last_name" placeholder="Last Name" value="<?= $objUser->getLastName() ?>">
    </div>
  </td>
  <td>
    <div class="form-group">
      <select class="form-control" id="user-admin" name="admin" style="width:80px;">
        <option value="0">No</option>
        <option value="1" <?= $objUser->isAdmin() ? 'selected="selected"' : '' ?>>Yes</option>
      </select>
    </div>
  </td>
  <td>
    <div class="form-group">
      <select class="form-control" id="user-banned" name="ban" style="width:80px;">
        <option value="0" selected="selected">No</option>
        <option value="1" <?= $objUser->isBanned() ? 'selected="selected"' : '' ?>>Yes</option>
      </select>
    </div>
  </td>
  <td>
    <div class="form-group">
      <input type="password" class="form-control" id="user-password" name="password" placeholder="Default Password" value="<?= $objUser->getPassword() ?>">
    </div>
  </td>
</tr>
