<?php

if ($md_galeria->hasAvatar()) {
  $src = $md_galeria->retrieveAvatar(array(mdWebOptions::WIDTH => 50, mdWebOptions::HEIGHT => 50, mdWebOptions::CODE => mdWebCodes::CROPRESIZE));
  echo '<img src="' . $src . '" />';
}