<div id="users_right_box" class="md_right_shadow">
  <div class="md_center_right">
      <div class="md_content_right">
          <div id="add-content"> 
          
            <div id='group_new_form_div'>
              <h2>
                <input type="checkbox" name="options" value="<?php echo __("newsletter_no seleccionar a ninguno") ?>" onclick="if($(this).is(':checked')){mdNeewsLetterBackend.getInstance().selectAll()}else{mdNeewsLetterBackend.getInstance().deselectAll()}" />
                <?php echo __("newsletter_seleccionar usuarios") ?>
              </h2>
              <div id="group_form_holder" class="users_holder">
                <?php foreach($users as $user): ?>
                <?php 
                    /*var_dump($user["id"]);
                    var_dump($user["email"]);
                    var_dump($user["nombre"]);*/
                ?>
                  <input type="checkbox" name="user" value="<?php echo $user["id"]; ?>" onclick="mdNeewsLetterBackend.getInstance().addUsersForSending();" /> <?php echo $user["nombre"];?><br/><strong><?php echo  $user["email"];?></strong><br/>
                  <?php //print_r($users->toArray()); ?>
                  
                <?php endforeach;?>
              </div>
            </div>     
          
          </div>
      </div>
  </div>
</div>
