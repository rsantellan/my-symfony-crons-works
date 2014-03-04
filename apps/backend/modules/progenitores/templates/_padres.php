<?php use_helper('mdAsset') ?>

<?php use_plugin_stylesheet('mastodontePlugin', 'autoSuggest.css', 'last'); ?>
<?php use_plugin_javascript('mastodontePlugin', 'jquery/plugins/autosuggest/jquery.autoSuggest.js', 'last'); ?>
<style type="text/css">
  .cursor-pointer{
    cursor: pointer;
  }
</style>

<div class="padres">
  <h3>Padres</h3>
  <?php if($progenitores): ?>
  
    <ul id="jardin-padres-list">
      <?php foreach($progenitores as $progenitor): ?>
        
        <li>
          <a href="<?php echo url_for('@progenitor_edit?id=' . $progenitor->getId()); ?>"><?php echo $progenitor->getNombre() . ' - ' . $progenitor->getMail(); ?></a>
          <img class="cursor-pointer" src="/images/ierror.png" alt="" onclick="removePadre(this, <?php echo $usuario->getId(); ?>, <?php echo $progenitor->getId(); ?>)" />
        </li>
        
      <?php endforeach; ?>
    </ul>
  
  <?php else: ?>
  
    <ul id="jardin-padres-list" style="display: none;"></ul>
    <p id="jardin-no-padres" style="margin-bottom: 1em;"><?php echo str_replace('{usuario}', $usuario->getNombre() . ' ' . $usuario->getApellido(), __('Usuarios_No tiene padres')) ; ?></p>
  
  <?php endif; ?>

  
  <p style="margin-bottom: 1em;">Escriba el nombre que desea buscar</p>
  
  <div class="autosuggest">  
    <form action="#" method="post" name="buscar">
      <input type="text" id="jardin-padres" autocomplete="off" name="ton" class="as-input" />
    </form>
  </div>
  
  <div id="sf_admin_container">
      <ul class="sf_admin_actions">
        <li class="sf_admin_action_new"><a href="<?php echo url_for('@progenitor_new') . '?usuario_id=' . $usuario->getId(); ?>">Nuevo</a></li>
      </ul>
  </div>  
</div>

<script type="text/javascript">
  var _USUARIO_ID = '<?php echo $usuario->getId(); ?>';
  function initializePadres(){
    $.ajax({
        url:   __MD_CONTROLLER_BACKEND_SYMFONY + "/progenitores/getProgenitores",
        type: 'post',
        dataType: 'json',
        success: function(json){
          if(json.response == "OK"){
            initAutosuggestPadres("jardin-padres", json.options.usuarios);
          }
        },
        complete: function(){},
        error: function(){}
    });
    return false;
  }
  
  function initAutosuggestPadres(inputId, items){
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
        resultClick: addPadre
        /*,
        formatList: function(data, elem){
            var link = data.link;
            var new_elem = elem.html("<a href='" + link + "'>" + data.name + "</a>");
            return new_elem;
        }*/
    });  
  }
  
  function addPadre(data){
    var _TEMPLATE_LI = '<li><a href="' + __MD_CONTROLLER_BACKEND_SYMFONY + '/progenitores/{progenitor_id}/edit' + '">{name}</a><img class="cursor-pointer" src="/images/ierror.png" alt="" onclick="removePadre(this, {usuario_id}, {progenitor_id})" /></li>';
    mdShowLoading();
    $.ajax({
        url:   __MD_CONTROLLER_BACKEND_SYMFONY + "/progenitores/addProgenitor",
        type: 'post',
        dataType: 'json',
        data: [{name: "usuario_id", value: _USUARIO_ID}, {name: "progenitor_id", value: data.attributes.value}],
        success: function(json){
          mdHideLoading();
          if(json.response == "OK"){
            $('#jardin-no-padres').hide();
            $('#jardin-padres-list').append(_TEMPLATE_LI.replace('{name}', data.attributes.name).replace('{usuario_id}', _USUARIO_ID).replace('{progenitor_id}', data.attributes.value).replace('{progenitor_id}', data.attributes.value)).show();
          }
        },
        complete: function(){},
        error: function(){}
    });
    return false;    
  }

  function removePadre(obj, usuario_id, progenitor_id){
    mdShowLoading();
    $.ajax({
        url:   __MD_CONTROLLER_BACKEND_SYMFONY + "/progenitores/removeProgenitor",
        type: 'post',
        dataType: 'json',
        data: [{name: "usuario_id", value: usuario_id}, {name: "progenitor_id", value: progenitor_id}],
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
    initializePadres();
  });
  
</script>
