<tr>
  <td>
    <?php if($contentSended->getSended()):?>
      <?php echo __("newsletter_Enviado");?>
    <?php else: ?>
      <?php echo __("newsletter_No enviado");?>
    <?php endif;?>
  </td>
  <td>
    <?php if($contentSended->getForStatus() == mdNewsletterContentSended::FORALL):?>
      <?php echo __("newsletter_Enviado a todos");?>
    <?php elseif($contentSended->getForStatus() == mdNewsletterContentSended::FORUSERS): ?>
        <?php echo __("newsletter_Enviado a algunos");?>
    <?php else: ?>
        <?php 
        $info = array();
        $grupos = $contentSended->getMdNewsLetterGroupSended();
        foreach($grupos as $grupoRel){
          $grupo = $grupoRel->getMdNewsLetterGroup();
          array_push($info, $grupo->getName());
        }
        ?>
        <?php echo implode(', ', $info); ?>
    <?php endif;?>
  </td>
  <td>
    <?php echo format_date($contentSended->getSendingDate(), 'f');?>
  </td>
  <td>
    <?php if(!$contentSended->getSended()):?>
      <a href="javascript:void(0)" onclick="mdNeewsLetterBackend.getInstance().removeSendedContent('<?php echo url_for("mdNewsletterBackend/removeContentSended");?>', <?php echo $contentSended->getId()?>, this)"><img src="/mdNewsletterDoctrinePlugin/images/cross-circle.png" title="<?php echo __("newsletter_Cancelar envio");?>" /></a>
    <?php endif;?>
    <a href="<?php echo url_for("mdNewsletterBackend/showContentSended?id=".$contentSended->getId());?>" class="visualizar iframe"><img src="/mdNewsletterDoctrinePlugin/images/magnifier.png" title="<?php echo __("newsletter_Visualizar");?>" /></a>
    <!-- <a href="<?php //echo url_for("@export_newsletter_user?id=".$contentSended->getId());?>"><img src="/mdNewsletterDoctrinePlugin/images/arrow-270.png" title="<?php echo __("newsletter_Bajar lista de usuarios");?>" /></a> -->
    <a target='_blank' href="<?php echo url_for("mdNewsletterBackend/showUsersSended?id=".$contentSended->getId());?>"><img src="/mdNewsletterDoctrinePlugin/images/arrow-270.png" title="<?php echo __("newsletter_Bajar lista de usuarios");?>" /></a>
  </td>
</tr>
