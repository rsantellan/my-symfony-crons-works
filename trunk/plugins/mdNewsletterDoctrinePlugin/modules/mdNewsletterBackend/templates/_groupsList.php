<div id="users_right_box" class="md_right_shadow">
  <div class="md_center_right">
      <div class="md_content_right">
          <div id="add-content"> 
          
            <div id='group_new_form_div'>
              <h2><?php echo __("newsletter_seleccionar grupo") ?></h2>
              <div id="news_letter_group_form_holder" class="users_holder">
                <?php foreach($groups as $group): ?>
                
                <input type="checkbox" name="newsletter_group" value="<?php echo $group->getId(); ?>" onclick="mdNeewsLetterBackend.getInstance().addGroupsForSending();" /> <?php echo $group->getName();?><br/>
                <?php endforeach;?>
              </div>
              <input type="button" name="options" value="<?php echo __("newsletter_no seleccionar a ninguno") ?>" onclick="mdNeewsLetterBackend.getInstance().groupDeselectAll()" />
              <input type="button" name="options" value="<?php echo __("newsletter_seleccionar todos") ?>" onclick="mdNeewsLetterBackend.getInstance().groupSelectAll()" />
            </div>     
          
          </div>
      </div>
  </div>
</div>
