<?php if (! $this->objRecipient->isBanned()) : ?>

  <form class="form-inline form-post-messsage">
    <input type="hidden" name="user_id" value="<?= $this->objRecipient->getId() ?>"/>
    <div class="form-group">
      <input type="text" class="form-control" id="user-message" name="message" placeholder="Type your message...", style="width:435px;">
    </div>
    <a href="javascript:void(0)" class="btn btn-default btn-send-message">Send</a>
  </form>

<?php endif; ?>
