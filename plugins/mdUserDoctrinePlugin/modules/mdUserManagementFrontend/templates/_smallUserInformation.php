<?php 
    use_helper("mdAsset");
    use_plugin_javascript('mdUserDoctrinePlugin', 'mdUserManagmentFrontend.js','last');
?>
<div class="clear"></div>
<div class="col_3">
    <div class="box_1">
        <ul class="bhead">
            <li><?php echo __('mdUserDoctrine_text_myData') ?></li>
        </ul>
        <div class="bcont" id="user_info">

            
                <?php include_partial("mdUserManagementFrontend/smallUserInformationData");?>

        </div>
        <div class="bcont" id="user_edit_info">
            
        </div>
    </div>
</div>
<div class="clear"></div>