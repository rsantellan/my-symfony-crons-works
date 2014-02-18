<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<style>
form.custom-form{
  margin-top: 15px;
}
form.custom-form fieldset input, form.custom-form fieldset textarea, form.custom-form fieldset select {
    border-color: #C4C4C4 #E9E9E9 #E9E9E9 #C4C4C4;
    border-style: solid;
    border-width: 1px;
    color: #777777;
    padding: 4px;
}
#sf_admin_content2 label {
    color: #666666;
    display: block;
    font-weight: normal !important;
    padding: 0 1em 3px 0;
    text-align: left;
}
fieldset {
    border: 0 none;
    margin: 0;
    padding: 0;
}
.autosuggest ul li {display:block !important; margin-right: 0px !important;}
#sf_admin_content2 ul li {display:inline;margin-right: 15px;}
#sf_admin_content2 ul {padding:0;}
#sf_admin_content2 ul.right {float:right;}
#sf_admin_content2 ul.right li {display:list-item; list-style:none;}
#sf_admin_content2 ul.right li button {
    float: right;
    margin-top: 20px;
}
#sf_admin_container2 ul li.sf_admin_action_list a {
    background: url("/sfDoctrinePlugin/images/list.png") no-repeat scroll 0 0 transparent;
}
#sf_admin_container2 ul.sf_admin_actions li {
    display: inline;
    list-style-type: none;
    margin-right: 10px;
}
#sf_admin_container2 ul.sf_admin_actions li a, #sf_admin_container2 ul.sf_admin_td_actions li a {
    background: url("/sfDoctrinePlugin/images/default.png") no-repeat scroll 0 0 transparent;
    padding-left: 20px;
}
#sf_admin_container2 ul li.sf_admin_action_delete a {
    background: url("/sfDoctrinePlugin/images/delete.png") no-repeat scroll 0 0 transparent;
    padding-left: 20px;
}
#sf_admin_container2 a:hover
{
  color: #000;
  text-decoration: underline;
}
.actividades ul li{
  margin-right: 10px;
}
.checkbox_list label{
  display: inherit !important;
}
#sf_admin_container2 .error {
    background: url("/sfDoctrinePlugin/images/error.png") no-repeat scroll 10px 4px #FF3333;
    border-bottom: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
    color: #FFFFFF;
    margin: 4px 0;
    padding: 4px 4px 4px 30px;
}
#sf_admin_container2 .errors {
    border: 1px solid #FF2222;
}
#sf_admin_container2 .notice {
    background: url("/sfDoctrinePlugin/images/tick.png") no-repeat scroll 10px 4px #FFFFCC;
    border-bottom: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
    margin: 4px 0;
    padding: 4px 4px 4px 30px;
}
</style>

<div class="sf_admin_form2">
  <?php echo form_tag_for($form, '@usuario', array('class' => 'custom-form')) ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    
    <fieldset>
        <ul class="right">
          <li>
              Referencia Bancaria:
			  <?php if($form->getObject()->isNew()): ?>
				  <?php echo $form['referencia_bancaria']->render(array('class' => ($form['referencia_bancaria']->hasError() ? 'errors' : ''))); ?>
				  <?php if($form['referencia_bancaria']->hasError()): ?>
					  <label style="color: red"><?php echo $form['referencia_bancaria']->getError();?></label>
				  <?php endif; ?>
			   <?php else: ?>
				   <strong><?php echo $form->getObject()->getReferenciaBancaria();?></strong>
			   <?php endif;?>	  
		  </li>
      <?php if($form->getObject()->isNew()): ?>
          <li><button type="button" onclick="checkBankReference('<?php echo url_for('@checkBankReference'); ?>'); return false;">Verificar Referencia Bancaria</button></li>
      <?php endif;?>	  
          <li><button type="button" for="<?php echo url_for('@exportar'); ?>" onclick="exportPdf(this); return false;">CUOTA</button></li>
        </ul>
      
        <ul>
          <li>Año
            <?php echo $form['anio_ingreso']->render(array('class' => ($form['anio_ingreso']->hasError() ? 'errors' : ''))); ?>
          </li>
          <li>Clase 
            <?php echo $form['clase']->render(array('class' => ($form['clase']->hasError() ? 'errors' : ''))); ?>
          </li>
          <li>Horario 
            <?php echo $form['horario']->render(array('class' => ($form['horario']->hasError() ? 'errors' : ''))); ?>
          </li>
          <li>Egresado 
            <?php echo $form['egresado']->render(array('class' => ($form['egresado']->hasError() ? 'errors' : ''))); ?>
          </li>          
        </ul>

        <ul>

          <li>Nombre <?php echo $form['nombre']->render(array('class' => ($form['nombre']->hasError() ? 'errors' : ''))); ?></li>

          <li>Apellido <?php echo $form['apellido']->render(array('class' => ($form['apellido']->hasError() ? 'errors' : ''))); ?></li>
        </ul>

        <ul>
          <li>Fecha de nacimiento <?php echo $form['fecha_nacimiento']->render(array('class' => ($form['fecha_nacimiento']->hasError() ? 'errors' : ''))); ?></li>
        </ul>

        <ul>
          <li>Futruo Colegio 
            <?php echo $form['futuro_colegio']->render(array('class' => ($form['futuro_colegio']->hasError() ? 'errors' : ''))); ?>
          </li>
        </ul>
      
    </fieldset>
  
    <h3>Actividades</h3>
    <fieldset class="actividades">

      <?php echo $form['actividades_list']->render(array('class' => ($form['actividades_list']->hasError() ? 'errors' : ''))); ?>

    </fieldset>
  
    <h3>Otros datos</h3>
    <fieldset>
      <ul>
        <li>Emergencia Médica 
          <?php echo $form['emergencia_medica']->render(array('class' => ($form['emergencia_medica']->hasError() ? 'errors' : ''))); ?>
        </li>
        <li>Sociedad Médica 
          <?php echo $form['sociedad']->render(array('class' => ($form['sociedad']->hasError() ? 'errors' : ''))); ?>
        </li>
      </ul>

      <ul>
        <li>Descuento especial <?php echo $form['descuento']->render(array('class' => ($form['descuento']->hasError() ? 'errors' : ''))); ?></li>
      </ul>
    </fieldset>
    
    <?php include_partial('usuarios/form_actions', array('usuario' => $usuario, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>  

<form id="sf_admin_content_form" action="<?php echo url_for('usuario_collection', array('action' => 'batch')) ?>" method="post">
  <input type="hidden" class="" value="<?php echo $usuario->getId(); ?>" name="ids[]" />
</form>

<script type="text/javascript">
function exportPdf(obj){
  var form = $('#sf_admin_content_form');
  form.attr('action', $(obj).attr('for'));
  form.submit();
}

function checkBankReference(myUrl)
{
  mdShowLoading();
  $.ajax({
      url: myUrl,
      data: {'referencia': $('#usuario_referencia_bancaria').val()},
      type: 'post',
      dataType: 'json',
      success: function(json){
          if(json.response == "OK")
          {
            mdShowMessage(json.options.message);
          }
          
      }, 
      complete: function()
      {
        mdHideLoading();
      }
  });

  return false; 
  
}
</script>
