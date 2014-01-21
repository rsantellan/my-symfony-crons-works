<?php $mdUser = mdUserHandler::retrieveMdUser($id);?>
<?php $mdUserProfile = mdUserHandler::retrieveMdUserProfileWithMdUserId($id);?>
<?php $mdUserPassport = mdUserHandler::retrieveMdPassportWithMdUserId($id);?>
<img width='46' height='46' src="<?php echo $mdUserProfile->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46, mdWebOptions::CODE => mdWebCodes::RESIZE)); ?>" />
<h2><?php echo $mdUserProfile->getFullName();?></h2>
<ul>
  <li><strong>Usuario:</strong> <?php echo $mdUserPassport->getUsername()?></li>
  <li><strong>Email:</strong> <?php echo $mdUser->getEmail()?></li>
</ul>
