
<button class="btn btn-default btn-user-edit" data-edit-mode="0">Edit</button>

<form class="form-horizontal form-edit-user">
  <input type="hidden" name="user_id" value="<?= $this->objUser->getId() ?>"/>
  <div class="form-group">
    <label class="col-sm-2 control-label">Login</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $this->objUser->getLogin() ?></p>
    </div>
    
    <div class="col-sm-10" style="display:none;width:300px;">
      <input type="text" class="form-control" id="login" name="login" placeholder="Login" value="<?= $this->objUser->getLogin() ?>">
    </div>
    
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $this->objUser->getFirstName() ?></p>
    </div>
    
    <div class="col-sm-10" style="display:none;width:300px;">
      <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $this->objUser->getFirstName() ?>">
    </div>
    
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Last Name</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $this->objUser->getLastName() ?></p>
    </div>
    
    <div class="col-sm-10" style="display:none;width:300px;">
      <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $this->objUser->getLastName() ?>">
    </div>
    
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <p class="form-control-static">******</p>
    </div>
    <div class="col-sm-10" style="display:none;width:300px;">
      <input type="password" class="form-control" id="password" name="password" value="<?= $this->objUser->getPassword() ?>">
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Admin</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $this->objUser->isAdmin() ? 'Yes' : 'No' ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Banned</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $this->objUser->isBanned() ? 'Yes' : 'No' ?></p>
    </div>
  </div>
  
</form>
