<div>
    <?php echo __('mastodontePlugin_text_configurationGroupName');?> <?php echo $mdXmlGroup->getName();?>
    <br/>
    <?php if($mdXmlGroup->getRequiered()):?>
        <?php echo __('mastodontePlugin_text_configurationGroupRequiered');?>
    <?php else:?>
        <?php echo __('mastodontePlugin_text_configurationGroupNotRequiered');?>
    <?php endif;?>
</div>