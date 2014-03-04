<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice"><?php echo __('Usuario_' . $sf_user->getFlash('notice'), array(), 'md_admin') ?></div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo __('Usuario_' . $sf_user->getFlash('error'), array(), 'md_admin') ?></div>
<?php endif; ?>
