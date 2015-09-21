
<tr data-id="<?= $this->objUser->getId() ?>">
  <th scope="row"><?= $this->objUser->getId() ?></th>
  <td><?= $this->objUser->getLogin() ?></td>
  <td><?= $this->objUser->getFirstName() ?></td>
  <td><?= $this->objUser->getLastName() ?></td>
  <td><?= $this->objUser->isAdmin() ? 'Yes' : 'No' ?></td>
  <td><?= $this->objUser->isBanned() ? 'Yes' : 'No' ?></td>
  <td><?= $this->objUser->getPassword() ?></td>
  <td>
    <button type="button" class="btn btn-default btn-sm btn-edit">
      <span class="glyphicon glyphicon-pencil"></span> 
    </button>
    <button type="button" class="btn btn-default btn-sm btn-remove">
      <span class="glyphicon glyphicon-remove"></span> 
    </button>
  </td>
</tr>
