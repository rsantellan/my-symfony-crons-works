<?php if(count($mdProfiles) > 0): ?>
<select id='new_profile_' name='mdProfileId' onchange="mdUserManagement.getInstance().showAddProfile(<?php echo $mdUserId?>);">
    <option value="0"></option>
    <?php foreach($mdProfiles as $mdProfile):?>
        <option value="<?php echo $mdProfile->getId()?>"><?php echo $mdProfile->getName()?></option>
    <?php endforeach;?>
</select>
<?php endif; ?>
