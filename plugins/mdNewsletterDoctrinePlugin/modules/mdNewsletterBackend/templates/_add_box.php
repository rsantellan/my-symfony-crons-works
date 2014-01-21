<div>
    <form action='<?php echo url_for('mdNewsletterBackend/saveMdNewsLetterContent'); ?>' method="post" id='new_newsletter_content'>
        <div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">

            <?php echo $form->renderHiddenFields()?>
            <?php include_partial('newsletter_content_basic_info', array('form' => $form)) ?>

            <div style="float: right" id="md_object_save_cancel_button">
                <input type="button" onclick="return mdNeewsLetterBackend.getInstance().saveNewsletterContent();" value="<?php echo __('newsletter_save') ?>"  />
                <input type="button" value="<?php echo __('newsletter_cancel');?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();" />
            </div>
        </div>
    <!--FIN ABIERTO TOP-->
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $("input:button", "#md_object_save_cancel_button").button();
        $("a", "#md_object_delete").button();
    });
</script>
