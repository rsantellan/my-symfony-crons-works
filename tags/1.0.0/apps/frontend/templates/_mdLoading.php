<div style="display:none" class="upload_container" id="upload_container_overlay"></div>

<div style="display:none" class="upload_progress" id="upload_container">
   <div class="progressWindow"><?php echo __('Inicio_Procesando, por favor espere ...'); ?></div>
   <img src="/mastodontePlugin/images/ajax-loader.gif" alt="" />
</div>

<div style="display:none" class="upload_progress" id="message_container">
   <div class="progressWindow" style="padding-top: 33px;"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {  
  $( '#message_container' ).live('click', function(event){ event.preventDefault(); $(this).hide(); });
});
</script>
