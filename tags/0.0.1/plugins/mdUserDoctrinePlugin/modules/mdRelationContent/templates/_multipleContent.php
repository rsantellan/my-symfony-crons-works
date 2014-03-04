<?php ?>

<div id="relation-multiple-select">
    <p><?php echo __('mdUserDoctrine_text_contentSelect'); ?></p>
    <form id="relation-multiple-form" action="mdRelationContent/newRelationInContent">
        <input type="hidden" id="_MD_Object_Id_Owner" name="_MD_Object_Id" value="<?php echo $_MD_Content_Concrete_Owner->getId(); ?>" />
        <input type="hidden" id="_MD_Object_Class_Name_Owner" name="_MD_Object_Class_Name" value="<?php echo $_MD_Content_Concrete_Owner->getObjectClass(); ?>" />
        <select id="select-dynamic-content" name="select-dynamic-content">
            <?php foreach($_MD_Content_Configuration as $config): ?>
                <option value="<?php echo $config['className'] . '-' . $config['profileId']; ?>"><?php echo $config['profileName']; ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div id="relation-multiple-content-error"></div>

<div id="relation-multiple-content"></div>

<script type="text/javascript">
    function showRelationContent(){
        $('#upload_container_overlay').css('display', 'block');
        $('#upload_container').css('display', 'block');

        var value = $('#select-dynamic-content').attr('value');
        var arrayValue = value.split('-');

        var _MD_Object_Id_Owner = $('#_MD_Object_Id_Owner').attr('value');
        var _MD_Object_Class_Name_Owner = $('#_MD_Object_Class_Name_Owner').attr('value');
        var _MD_Object_Class_Name = arrayValue[0];
        var _MD_Profile_Id = arrayValue[1];

        var data = [{name : '_MD_Object_Id_Owner', value : _MD_Object_Id_Owner}, {name : '_MD_Object_Class_Name_Owner', value : _MD_Object_Class_Name_Owner}, {name : '_MD_Object_Class_Name', value : _MD_Object_Class_Name}, {name : '_MD_Profile_Id', value : _MD_Profile_Id}];

        $.ajax({
            type: "POST",
            dataType: "json",
            url: __MD_CONTROLLER_SYMFONY + "/mdRelationContent/newRelationInContent",
            data: data,
            success: function(response){
                if(response.response == 'OK'){
                    $('#relation-multiple-content').html(response.body);

                    $('#upload_container_overlay').css('display', 'none');
                    $('#upload_container').css('display', 'none');

                }
                else if(response.response == 'ERROR'){
                    $('#relation-multiple-content-error').html(response.body);
                }
                else{

                    alert('Internal Error');

                }
            },
            error: function(){

                alert('Internal Error');

            }
        });
    }
    
    $('#select-dynamic-content').change(function() {
        showRelationContent();
    });

    $(function() {
        showRelationContent();
    });
    
</script>
