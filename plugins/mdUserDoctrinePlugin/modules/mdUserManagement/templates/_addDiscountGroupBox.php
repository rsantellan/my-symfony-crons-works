<div style="display: block;" id="removeDiscountGroupBox" class="md_block_add">
    <div class="md_add_block_shadow" style="">
        <div class="md_center_block_add">
            <div class="md_content_add_block">
                <div class="md_background_title">
                    <h3>
                        Grupo de Descuentos
                        <a href="<?php echo url_for('mdDiscountGroup/getNewDiscountGroupBoxAjax'); ?>" onclick="mdContentList.showContentBox('right_menu', this, event, true);">crear grupo</a>
                        <a href="javascript:void(0)" onclick="$('removeDiscountGroupBox').remove();"><?php echo image_tag ( 'cerrar.png' )?></a>
                    </h3>
                </div>
                <div class="md_content_block">
                    <?php include_component('mdDiscountGroup','userDiscountList', array('userId'=>$userId))?>
                </div>
            </div>
        </div>
    </div>
</div>