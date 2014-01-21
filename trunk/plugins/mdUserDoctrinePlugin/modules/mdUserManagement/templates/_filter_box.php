<form id="md_filter" action="<?php echo url_for('mdUserManagement/searchmdUserManagement'); ?>" method="GET">
    <div style="float: left;">
        <?php echo $formFilter->renderHiddenFields() ?>
        <h2><?php echo $formFilter['email']->renderLabel() ?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['email']->render(array(), array('class' => 'largeInput')) ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float: left;">
        <h2><?php echo __('mdUserDoctrine_text_createdAt');?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['created_at']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float: left;">
        <h2><?php echo __('mdUserDoctrine_text_country');?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['country']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float: left;">
        <h2><?php echo __('mdUserDoctrine_text_blocked');?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['blocked']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div> 
    <input type="hidden" value="1" name="page" id="page_filter_id"/>
    <hr>
    <input id="md_object_submit_button" type="submit" value="<?php echo __('mdUserDoctrine_text_search');?>" />
</form>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#md_filter" ).button();
    });
</script>
