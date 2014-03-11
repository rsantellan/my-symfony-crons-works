<li class="sf_admin_action_print"><a href="<?php echo url_for('@printSave'); ?>" onclick="return printUsers(this);">Imprimir</a></li>

<a id="users-print" class="iframe" href="<?php echo url_for('@print'); ?>" style="display:none;">This goes to iframe</a>

<script type="text/javascript">
  function printUsers(obj){
    var form = $('#sf_admin_content form');
    form.attr('action', $(obj).attr('href'));
    $.ajax({
      url: form.attr('action'),
      data: form.serialize(),
      type: 'post',
      dataType: 'json',
      success: function(json){
        $("a#users-print").trigger('click');
      },
      error: function(){
      }
    });
    return false;
  }

  $(document).ready(function() {
    $("a#users-print").fancybox({
        width: 780,
        height: 400
    });
  });
</script>