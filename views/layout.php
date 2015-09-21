<?php 
    $objUser        = App_Auth::getInstance()->getUser();
    $arrMessageNew  = $objUser->getMessageArray(0, $bUnread = true);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Welcome, <?= $objUser->getFirstName() ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        
    </head>
    <body role="document">
        
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/index/profile">Welcome, <?= $objUser->getFirstName() ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                
                <?php if ($objUser->isBanned()) : ?>
                    <li><a href="#">You are banned</a></li>
                <?php else : ?>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Messages 
                          <?php if(count($arrMessageNew)) : ?><span class="badge"><?= count($arrMessageNew) ?></span><?php endif; ?><span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                        <?php foreach ($objUser->getRecipientArray() as $objRecipient): ?>
                            <li><a href="/index/get-user-message?user_id=<?= $objRecipient->getId() ?>">
                                <?= $objRecipient->getLogin() ?> 
                                <?php 
                                    $intNewMessage = 0; 
                                    foreach ($arrMessageNew as $objMessageNew) {
                                        if ($objMessageNew->getSenderId() == $objRecipient->getId()) {
                                            $intNewMessage++;
                                        }
                                    } 
                                ?>
                                <?php if ($intNewMessage > 0) : ?><span class="badge"><?= $intNewMessage ?></span><?php endif; ?>
                            </a></li>
                        <?php endforeach; ?>
                      </ul>
                    </li>
                <?php endif; ?>
                
                <?php if ($objUser->isAdmin()) : ?>
                <li><a href="/index/get-user">Users</a></li>
                <?php endif; ?>
                
              </ul>
              
              <ul class="nav navbar-nav pull-right">
                <li><a href="/auth/signout">Sign out</a></li>
              </ul>
              
            </div><!--/.nav-collapse -->
          </div>
        </nav>
                
        <div class="container theme-showcase" role="main" style="margin-top:80px;">
           
            <?= $strContent ?>
            
        </div>
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/public/app.js"></script>
        
    </body>
</html>
