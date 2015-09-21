<tr class="<?= $this->objMessage->getSenderId() == $this->objRecipient->getId() && $this->objMessage->isUnread() ? 'info' : '' ?>">
  <td>
    <?php if ($this->objMessage->getSenderId() == $this->objUser->getId()) : ?>
    <span><?= $this->objMessage->getContent() ?></span>
    <?php endif; ?>
  </td>
  <td></td>
  <td>
    <?php if ($this->objMessage->getSenderId() == $this->objRecipient->getId()) : ?>
    <span><?= $this->objMessage->getContent() ?></span>
    <?php endif; ?>
  </td>
</tr>
