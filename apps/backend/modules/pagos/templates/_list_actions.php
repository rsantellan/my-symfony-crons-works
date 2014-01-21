<li class="sf_admin_action_print"><a id="pagos-print" class="iframe" href="<?php echo url_for('@print_pagos'); ?>">Imprimir</a></li>

<script type="text/javascript">
$(document).ready(function() {
  $("a#pagos-print").fancybox({
      width: 780,
      height: 400
  });
});
</script>
