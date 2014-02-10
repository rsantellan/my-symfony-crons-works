<div id="users_right_box" class="md_right_shadow">
  <div class="md_center_right">
      <div class="md_content_right">
          <div id="add-content"> 
          
            <div id='group_new_form_div'>
              <h2>
                <input type="checkbox" name="options" value="<?php echo __("newsletter_no seleccionar a ninguno") ?>" onclick="if($(this).is(':checked')){mdNeewsLetterBackend.getInstance().selectAll()}else{mdNeewsLetterBackend.getInstance().deselectAll()}" />
                <?php echo __("newsletter_seleccionar usuarios") ?>
              </h2>
              <?php
              $clase  = "";
              $horario = "";
              $open_div = false;
              ?>
              <div id="group_form_holder" class="users_holder">
                <?php foreach($users as $user): ?>
                <?php
                if($clase != $user['u_clase'] || $horario != $user['u_horario']):
                  $clase = $user['u_clase'];
                  $horario = $user['u_horario'];
                  if($open_div):
                  ?>
                  </div>
                  <?php
                  endif;
                  ?>
                <h2><a href="javascript:void(0)" onclick="$('#conjunto_mails_<?php echo $horario.$clase;?>').toggle()"><?php echo $horario;?> - <?php echo $clase;?></a></h2>
                <div id="conjunto_mails_<?php echo $horario.$clase;?>" class="hidden">
                <?php
                  $open_div = true;
                endif;
                ?>
                <?php
                    /*var_dump($user["id"]);
                    var_dump($user["email"]);
                    var_dump($user["nombre"]);*/
                ?>
                  <?php if(!empty($user["mn_email"])): ?>
                    <input type="checkbox" name="user" value="<?php echo $user["mn_id"]; ?>" onclick="mdNeewsLetterBackend.getInstance().addUsersForSending();" /> 
                  <?php endif; ?>
                  Alumno:<?php echo $user["u_nombre"]. " ".$user["u_apellido"];?><br/>
                  Padre: <?php echo $user['p_nombre'];?>
                  <strong><?php echo (empty($user["mn_email"]))? "No tiene mail ingresado" : $user["mn_email"];?></strong><br/>
                  <?php //print_r($users->toArray()); ?>
                  <hr/>
                <?php endforeach;
                  if($open_div):
                  ?>
                  </div>
                  <?php
                  endif;
                  ?>
              </div>
            </div>     
          
          </div>
      </div>
  </div>
</div>
