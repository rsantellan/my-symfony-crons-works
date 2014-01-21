<div style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for('mdNewsletterBackend/openBox?id='.$object->getId()) ?>">
    <input type="hidden" name="_MD_OBJECT_ID" value="<?php echo $object->getId(); ?>" />
    <ul class="md_closed_object">
        <li class="md_height_fixed close" id="md_object_<?php echo $object->getId() ?>">
            <ul class="md_closed_object">
                <li class="md_object_name">
                    <div class="md_object_owner">
                        <div><?php echo $object->getSubject()?></div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

</div>
