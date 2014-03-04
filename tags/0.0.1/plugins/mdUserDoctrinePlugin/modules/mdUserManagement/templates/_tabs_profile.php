<ul id="tabs_example_two" class="subsection_tabs">
    <li class="tab"><a href="#v1"><?php echo __('homero_Vehiculo 1'); ?></a></li>
    <li class="tab"><a href="#v2"><?php echo __('homero_Vehiculo 2'); ?></a></li>
    <li class="tab"><a href="#v3"><?php echo __('homero_Vehiculo 3'); ?></a></li>
    <li class="tab"><a href="#v4"><?php echo __('homero_Vehiculo 4'); ?></a></li>
</ul>

<div class="clear"></div>

<div id="v1">
    <?php include_partial('homero/profile_form', array('form' => $forms[0], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[0])); ?>
</div>
<div id="v2">
    <?php include_partial('homero/profile_form', array('form' => $forms[1], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[1])); ?>
</div>
<div id="v3">
    <?php include_partial('homero/profile_form', array('form' => $forms[2], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[2])); ?>
</div>
<div id="v4">
    <?php include_partial('homero/profile_form', array('form' => $forms[3], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[3])); ?>
</div>


<script language="JavaScript" type="text/javascript">
 var tabs_example_two = new Control.Tabs('tabs_example_two',{
    beforeChange: function(old_container, new_container)
    {
    }
 });
</script>