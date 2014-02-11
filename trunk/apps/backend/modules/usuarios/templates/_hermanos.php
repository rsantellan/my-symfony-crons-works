<?php use_helper('mdAsset') ?>

<?php // esto ya se incluyo en el componente de los padres ?>
<?php //use_plugin_stylesheet('mastodontePlugin', 'autoSuggest.css', 'last'); ?>
<?php //use_plugin_javascript('mastodontePlugin', 'jquery/plugins/autosuggest/jquery.autoSuggest.js', 'last'); ?>
<!-- <style type="text/css">
  .cursor-pointer{
    cursor: pointer;
  }
</style> -->

<div class="hermanos">
  <h3><?php echo __('Usuarios_Hermanos', array(), 'messages') ?></h3>
  
  <?php if($usuario->hasHermanos()): ?>
  
    <ul id="jardin-hermanos-list">
      <?php foreach($hermanos as $hermano): ?>
        
        <li>
          <a href="<?php echo url_for('@usuario_edit?id=' . $hermano->getUserTo()->getId()); ?>"><?php echo $hermano->getUserTo()->getNombre() . ' ' . $hermano->getUserTo()->getApellido(); ?></a>
          <img class="cursor-pointer" src="/images/ierror.png" alt="" onclick="removeHermano(this, <?php echo $usuario->getId(); ?>, <?php echo $hermano->getUserTo()->getId() ?>)" />
        </li>
        
      <?php endforeach; ?>
    </ul>
  
  <?php else: ?>
  
    <ul id="jardin-hermanos-list" style="display: none;"></ul>
    <p id="jardin-no-hermanos" style="margin-bottom: 1em;"><?php echo str_replace('{usuario}', $usuario->getNombre() . ' ' . $usuario->getApellido(), __('Usuarios_No tiene hermanos')) ; ?></p>
  
  <?php endif; ?>

  
  <p style="margin-bottom: 1em;">Escriba el nombre que desea buscar</p>
  
  <div class="autosuggest">  
    <form action="#" method="post" name="buscar">
      <input type="text" id="jardin-usuarios" autocomplete="off" name="chugas" class="as-input" />
    </form>
  </div>
</div>

<script type="text/javascript">
  var _USUARIO_FROM = '<?php echo $usuario->getId(); ?>';
  
  function initialize(){
    $.ajax({
        url:   '<?php echo url_for('usuarios/getUsuarios')?>',
        type: 'post',
        dataType: 'json',
        success: function(json){
          if(json.response == "OK"){
            initAutosuggest("jardin-usuarios", json.options.usuarios);
          }
        },
        complete: function(){},
        error: function(){}
    });
    return false;
  }

  /*function initAutosuggestTon(inputId, items){
    $("#" + inputId).autoSuggest(__MD_CONTROLLER_BACKEND_SYMFONY + "/usuarios/getUsuarios2", {
        startText: "",
        emptyText: "",
        limitText: "",
        selectedItemProp: "name",
        searchObjProps: "name",
        minChars: 1,
        selectionLimit: 20,
        matchCase: false,
        keyDelay: 400,
        showResultList: true,
        showTags: false,
        resultClick: addHermano
    });  
  }*/

  function initAutosuggest(inputId, items){
    $("#" + inputId).autoSuggest(items, {
        startText: "",
        emptyText: "",
        limitText: "",
        selectedItemProp: "name",
        searchObjProps: "name",
        minChars: 1,
        selectionLimit: 20,
        matchCase: false,
        showResultList: true,
        showTags: false,
        resultClick: addHermano
        /*,
        formatList: function(data, elem){
            var link = data.link;
            var new_elem = elem.html("<a href='" + link + "'>" + data.name + "</a>");
            return new_elem;
        }*/
    });  
  }
  
  function addHermano(data){
    var _TEMPLATE_LI = '<li><a href="' + __MD_CONTROLLER_BACKEND_SYMFONY + '/usuarios/{usuario_to}/edit' + '">{name}</a><img class="cursor-pointer" src="/images/ierror.png" alt="" onclick="removeHermano(this, {usuario_from}, {usuario_to})" /></li>';
    mdShowLoading();
    $.ajax({
        url:   '<?php echo url_for('usuarios/addHermano')?>',
        type: 'post',
        dataType: 'json',
        data: [{name: "usuario_from", value: _USUARIO_FROM}, {name: "usuario_to", value: data.attributes.value}],
        success: function(json){
          mdHideLoading();
          if(json.response == "OK"){
            $('#jardin-no-hermanos').hide();
            $('#jardin-hermanos-list').append(_TEMPLATE_LI.replace('{name}', data.attributes.name).replace('{usuario_from}', _USUARIO_FROM).replace('{usuario_to}', data.attributes.value).replace('{usuario_to}', data.attributes.value)).show();
          }
          else
          {
            mdShowMessage(json.options.message);
          }
        },
        complete: function(){},
        error: function(){}
    });
    return false;    
  }

  function removeHermano(obj, usuario_from, usuario_to){
    mdShowLoading();
    $.ajax({
        url:   '<?php echo url_for('usuarios/removeHermano')?>',
        type: 'post',
        dataType: 'json',
        data: [{name: "usuario_from", value: usuario_from}, {name: "usuario_to", value: usuario_to}],
        success: function(json){
          mdHideLoading();
          if(json.response == "OK"){
            $(obj).parent().remove();
          }
        },
        complete: function(){},
        error: function(){}
    });
    return false;    
  }  
  
  $(document).ready(function() {
    initialize();
    //initAutosuggestTon("jardin-usuarios");
  });
  
</script>
