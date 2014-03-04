var groupsForDelete = new Array();

mdUserManagement = function(options){
	this._initialize();

}

mdUserManagement.instance = null;
mdUserManagement.getInstance = function (){
	if(mdUserManagement.instance == null)
		mdUserManagement.instance = new mdUserManagement();
	return mdUserManagement.instance;
}

mdUserManagement.prototype = {
    _initialize: function(){
        
    },

    changeMdUserSuperAdmin: function(mdUserId, url){
        mdShowLoading();
        $.ajax({
            url: url,
            data: {'mdUserId': mdUserId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){

                }else {

                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;
    },

    changeMdPassportIsActive: function(mdPassportId, url){
        mdShowLoading();
        $.ajax({
            url: url,
            data: {'mdPassportId': mdPassportId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){

                }else {

                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;
    },

    changeMdPassportIsBlocked: function(mdPassportId, url){
        mdShowLoading();
        $.ajax({
            url: url,
            data: {'mdPassportId': mdPassportId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){

                }else {

                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;
    },
    
    resetPassword: function(id, url) {
        //var url = 'mdUserManagement/resetUserPasswordAjax';
        AjaxLoader.getInstance().show();        
        $.ajax({
            url: url,
            data: { 'mdPassportId': id },
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){

                }else{

                }
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });
        
        return false;
    },

    submitMdPassportForm: function(id){
        var form = '#md_user_content_edit_form_' + id;

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#new_user').html(json.body);

                }else {
                    $('#new_user').prepend(json.body);
                }
            }
        });

        return false;
    },
            

    submitMdUserProfileForm: function(id){
        var form = '#md_user_profile_edit_form_' + id;

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#start_profiles').innerHTML = json.body;

                }else {
                    //ver esto para actualizar al nuevo backend
                    mdObjectList.saveFormObject(1, $('product_edit_form_1'), event);

                }
            }
        });

        return false;
    },

    getAddPermissionToUser: function(id){
        var url = 'mdUserManagement/getPermissionBoxAjax';
        var place = '#bloque_agregar_permiso_' + id;

        $.ajax({
            url: url,
            data: {'mdPassportId': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $(place).insert(results.get('body'));
                }
            }
        });

        return false;
    },

    closePermissionBox: function(){
        $('#add_permision_internal').remove();
        return false;
    },

    saveProfileAjax: function(profileId, userId){
        var form = "#user_new_profile_" + profileId;
        var input = $(form + ' > submit');

        input[0].value = "Saving...";
        
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                input[0].value = "Save";
            }
        });
        return false;
        
    },

    addPermissionToUser: function(id) {
        var application = $('#new_permission_application').attr('value');
        var value = $('#new_permission').attr('value');
        var url = 'mdUserManagement/addPermissionToUserAjax';
        var place = '#permission_list';
        
        $.ajax({
            url: url,
            data: {'mdPassportId': id, 'mdPermissionId': value, 'mdApplicationId': application},
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 1){
                    $(place).update(json.body);
                }
            }
        });
        return false;

    },

    changePermissionList: function(id){
        var sel = $('#new_group_application');
        var value = sel.options[sel.selectedIndex].value;
        var url = 'mdUserManagement/getPermissionOfApplicationAjax';
        var place = $('#new_permission');
        
        $.ajax({
            url: url,
            data: {'mdPassportId': id, 'mdApplicationId': value},
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 1){
                    for(var count = place.options.length - 1; count >= 0; count--){
                        place.options[count] = null;
                    }
                    
                    var list = json.body;

                    for(var i=0;i<list.length;i++){
                        var opt=document.createElement('option');
                        opt.text=list[i]['name'];
                        opt.value=list[i]['id'];
                        place.options.add(opt);
                    }
                }
            }
        });
    },

    addNewProfileToUser: function(passportId, mdUserId, url){
        AjaxLoader.getInstance().show();
        $.ajax({
            url: url,
            data: {'mdPassportId': passportId, 'mdUserId': mdUserId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                $('#new_user_profile_container_' + mdUserId).html(json);
                $('#new_user_profile_container_' + mdUserId + ' :button').button();
                $('#new_user_profile_container_' + mdUserId).slideDown(1000);
                
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });

    },

    addNewUser: function(passportId, mdUserId){
        var url = 'mdUserManagement/addNewUser';
        var parameterMdUserId = (mdUserId == '') ? '' : '&mdUserId=' + mdUserId;

        $.ajax({
            url: url,
            data: {'mdPassportId': passportId, 'mdUserId': mdUserId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                $('#new_user_profile_container_' + mdUserId).html(json);
                $('#new_user_profile_container_' + mdUserId).slideDown(1000);

                //ver esto cuando se actualice al nuevo backend
                mdObjectList.closeOpenObjects();
            }
        });
    },

    getProfiles: function(mdUserId){
        var parameterMdUserId = (mdUserId == '') ? '' : '&mdUserId=' + mdUserId;
        var mdAppId = $('#new_app_' + mdUserId).attr('value');
        var self;

        $.ajax({
            url: 'mdUserManagement/listProfiles',
            data: {'mdAppId': mdAppId, 'mdUserId': mdUserId},
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 1){
                    $('#list_profiles_' + mdUserId).html(json.body);
                    self.showProfile('');
                }
            }
        });
        
    },

    showProfile: function(){
        AjaxLoader.getInstance().show();
        $.ajax({
            url: $('#show_new_form_profile').attr('action'),
            data: $('#show_new_form_profile').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == "OK")
                {
                    $('#profile_form_').html(json.body);
                    if(typeof changeCountry == 'function') { 
                      changeCountry();
                    }
                }
                else
                {
                    $('#profile_form_').html("");
                }
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });
        return false;
    },
    
    
    showAddProfile: function(id){
        if(id == 0)
        {
          mdUserManagement.getInstance().showProfile();
          return false;
        }
        AjaxLoader.getInstance().show();
        $.ajax({
            url: $('#show_add_new_form_profile').attr('action'),
            data: $('#show_add_new_form_profile').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.response == "OK")
                {
                    $('#add_new_form_profile_container_'+id).html(json.body);
                }
                else
                {
                    $('#add_new_form_profile_container_'+id).html("");
                }
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });
        return false;
    },
    
    saveSimpleMdUser: function(mdUserId)
    {
        AjaxLoader.getInstance().show();
        var form = $("#md_user_edit_form_" + mdUserId);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(data){
                if(data.response == "OK")
                {
                    AjaxLoader.getInstance().hide();
                    mastodontePlugin.UI.BackendBasic.getInstance().close();  
                }
                else
                {
                    AjaxLoader.getInstance().hide();
                    $("#md_user_edit_div_" + mdUserId).replaceWith(data.options.body);
                }
            }
        });        
    },

    saveMdUser: function(mdUserId, mdPassportId, mdUserProfileId)
    {
        AjaxLoader.getInstance().show();
        var form = $("#md_user_edit_form_" + mdUserId);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(data){
                if(data.response == "OK")
                {
                    mdUserManagement.getInstance().saveMdPassport(mdPassportId, mdUserProfileId);
                }
                else
                {
                    AjaxLoader.getInstance().hide();
                    $("#md_user_edit_div_" + mdUserId).replaceWith(data.options.body);
                }
            }
        });
        
    },

    saveMdPassport: function(mdPassportId, mdUserProfileId)
    {
        var form = $("#md_user_md_passport_edit_form_" + mdPassportId);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(data){
                if(data.response == "OK")
                {
                    mdUserManagement.getInstance().saveMdUserProfileByAjax(mdUserProfileId);
                }
                else
                {
                    AjaxLoader.getInstance().hide();
                    $("#md_user_md_passport_edit_div_" + mdPassportId).replaceWith(data.options.body);
                }
            }
        });
        
    },

    saveMdUserProfileByAjax: function(mdUserProfileId)
    {
        var form = $("#md_user_profile_edit_form_" + mdUserProfileId);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(data){
                if(data.result == 1)
                {
                    AjaxLoader.getInstance().hide();
                    $("#md_user_profile_edit_div_" + mdUserProfileId).replaceWith(data.body);
                }
                else
                {
                    mdUserManagement.getInstance().saveExistingMdProfiles(0);
                }
            }
        });
    },
    
    saveExistingMdProfiles: function(position)
    {
        var list = $('.md_profile_form_class');
        if(list.length > 0 && position < list.length)
        {
            var form = list[position];
            $.ajax({
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if(data.response == "ERROR")
                    {
                        AjaxLoader.getInstance().hide();
                        $("#user_new_profile_div_" + data.options.mdProfileId).html(data.options.body);
                    }
                    else
                    {
                        mdUserManagement.getInstance().saveExistingMdProfiles(position + 1);
                    }
                }
            });  
        }
        else
        {
            AjaxLoader.getInstance().hide();
            mastodontePlugin.UI.BackendBasic.getInstance().close();
        }
        
    },
        
    saveNewProfile: function(mdUserId)
    {
        AjaxLoader.getInstance().show();
        var self = this;
        $.ajax({
            url: $('#user_new_profile_form_' + mdUserId).attr('action'),
            data: $('#user_new_profile_form_' + mdUserId).serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.response == "OK")
                {
                    mastodontePlugin.UI.BackendBasic.getInstance().getActivatedContent().html(json.options.body);
                    if(typeof initializeLightBox == 'function'){
                        initializeLightBox(json.options.id, json.options.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());
                    }
                    if(typeof changeCountry == 'function') { 
                      changeCountry($("#user_city_value").val());
                    }                        
                }
                else
                {
                    $('#add_new_form_profile_container_' + mdUserId).html(json.options.body);
                }
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });

        return false;
    },
    
    cancelProfile: function(mdUserId)
    {
        $('#new_user_profile_container_' + mdUserId).slideUp(1000,function() {
            $('#new_user_profile_container_' + mdUserId).html("");
        });
        
    },


    saveProfile: function(mdUserId) {
        var self = this;

        $.ajax({
            url: $('#user_new_form_' + mdUserId).attr('action'),
            data: $('#user_new_form_' + mdUserId).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){

                if(json.result == 1){
                    $('#open_user_' + mdUserId + ' > ,start_profiles:first-child').append(json.body);
                    $('#user_new_form_' + mdUserId).remove();

                }else{
                    $('#profile_form_' + mdUserId).html(json.body);

                }
                self.clickElement("button_to_save");
            }
        });

        return false;
    },

    addMdPassport : function(mdUserId, myUrl, saveText, cancelText)
    {
        $.ajax({
            url: myUrl,
            data: {'mdUserId': mdUserId},
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.response == "OK"){
                    
                    mdUserManagement.getInstance().createNewPassportModal(json.options.body, mdUserId);
                    
                }
            }
        });      
        
    },

    createNewPassportModal: function (body, mdUserId)
    {
        $("#add_md_passport_modal").html(body);
                   
        $("#add_md_passport_modal" ).dialog({
            resizable: false,
            modal: true,
            buttons: {
                save: function() {
                    AjaxLoader.getInstance().show();
                    $( this ).dialog( "destroy" );
                    mdUserManagement.getInstance().processNewMdUserProfilePassport(mdUserId);
                    
                    
                },
                cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });        
    },
    
    processNewMdUserProfilePassport: function(mdUserId)
    {
        $.ajax({
            url: $('#md_user_with_passport_form_' + mdUserId).attr('action'),
            data: $('#md_user_with_passport_form_' + mdUserId).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){

                if(json.response == "OK"){
                    mastodontePlugin.UI.BackendBasic.getInstance().getActivatedContent().html(json.options.body);
                    if(typeof initializeLightBox == 'function'){
                        initializeLightBox(json.options.id, json.options.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());
                    }
                    AjaxLoader.getInstance().hide();
                }else{
                    AjaxLoader.getInstance().hide();
                    mdUserManagement.getInstance().createNewPassportModal(json.options.body, mdUserId);

                }
                
            }
        });

        return false;
    },
    
    getAddCategoryForProduct: function(mdPassportId){
        var url = 'mdUserManagement/getGroupBoxAjax';
        var place = '#group_cc';

        $.ajax({
            url: url,
            data:  {'mdPassportId': mdPassportId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if($('#removeGroupsBox').length > 0){
                    $('#removeGroupsBox').remove();
                }

                if(json.result == 1){
                    $('#md_group_list').append(json.body);
                }

                $('.md_category_remove').each(function(index, item) {
                    item.show();
                });
            }
        });
        return false;
    },

    addGroupToUser: function(id){
        var application = $('#new_group_application').attr('value');
        var value = $('#new_group').attr('value');
        var url = 'mdUserManagement/addGroupToUserAjax';
        var place = '#md_group_list';
        var self = this;

        $.ajax({
            url: url,
            data: {'mdPassportId': id, 'mdGroupId': value, 'mdApplicationId': application},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $(place).innerHTML = json.body;
                    self.updatePermissions(id);

                    $('.md_category_remove').each(function(index, item) {
                        item.show();
                    });
                }
            }
        });


        return false;
    },

    discountGroupBox: function(id){
        var url = 'mdUserManagement/getDiscountGroupBox';

        $.ajax({
            url: url,
            data: {'id': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#discount_group_list').innerHTML = json.body;
                }
            }
        });
        
        return false;
    },


    addGroupsForRemove: function(id,name){
        var text = '';
        if(groupsForDelete.length == 0){
            text = name;
        }else{
            text = ', ' + name;
        }

        groupsForDelete.push(id);
        $('#grupos_para_eliminar').append(text);
    },


    processDeleteGroups: function(mdPassportId){
        for (i=0;i<groupsForDelete.length;i++){
            this.deleteGroup(mdPassportId,groupsForDelete[i]);
        }
        $('#grupos_para_eliminar').html('');
        groupsForDelete = new Array();
        return false;
    },

    submitNewMdUserProfileForm: function(url){
      AjaxLoader.getInstance().show();
      $.ajax({
            url: $('#user_new_form').attr('action'),
            data: $('#user_new_form').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 1){
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
                }else{
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxAdded(url + '?id='+json.user_id);

                }
            },
            complete: function(){
                AjaxLoader.getInstance().hide();
            }

        });
        return false;
    },

    createNewGroupBox: function(){
        var url = 'mdGroupAndPermissionsManagement/getNewGroupBoxAjax';

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){
                    $('#create_new_group_box').html(json.body);
                }
            }
        });
        
        return false;
    },

    createNewPermissionBox: function(){
        var url = 'mdGroupAndPermissionsManagement/getNewPermissionBoxAjax';

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){
                    $('#create_new_permission_box').html(json.body);
                }
            }
        });
        
        return false;
    },

    addPermissionToGroupBox: function(){
        var url = 'mdGroupAndPermissionsManagement/getAddPermissionToGroupBoxAjax';

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){
                    $('#create_new_permission_box').html(json.body);
                }
            }

        });

        return false;
    },

    addDiscountGroupBox: function(){
        var url = 'mdDiscountGroup/getNewDiscountGroupBoxAjax';

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){
                    $('#add_discount_group_box').html(json.body);
                }
            }
        });

        return false;
    },

    submitNewMdDiscountGroupForm: function(){
        var form = '#group_new_form';

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#discount_group_new_form_div').html(json.body);
                }else{
                    $('#discount_group_new_form_div').remove();
                }
            }
        });

        return false;
    },


    loadMdDiscountGroupInformation: function(){
        var mdDiscountGroupId = $('#change_md_discount_group').attr('value');
        var url = 'mdDiscountGroup/getDiscountGroupInfoAjax';

        $.ajax({
            url: url,
            data: {'mdDiscountGroupId': mdDiscountGroupId},
            dataType: 'json',
            type: 'post',
            success: function(json){
                if(json.result == 0){
                    $('#md_dicount_group_info').innerHTML = "";
                    $('#md_dicount_group_info').html(json.body);
                }
            }

        });

        return false;
    },

    deleteUser: function(id){
        var url = $('#delete_user').attr('href');
        AjaxLoader.getInstance().show(); 
        $.ajax({
            url: url,
            data: {'id': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
                }
            },
            complete: function(json)
            {
              AjaxLoader.getInstance().hide();
            }
        });

        return false;
    },

    deleteUserWithConfirmation: function(text, id)
    {
		 if(confirm(text))
         {
			 mdUserManagement.getInstance().deleteUser(id);
		 }
		 return false;
        
    },


    clickElement: function(elementid){
        var e = document.getElementById(elementid);
        if (typeof e == 'object') {
            /*if(typeof e.click != 'undefined') {
                e.click();
                alert('click');
                return false;
            }
            else */
            if(document.createEvent) {
                var evObj = document.createEvent('MouseEvents');
                evObj.initEvent('click',true,true);
                e.dispatchEvent(evObj);
                //alert('createEvent');
                return false;
            }
            else if(document.createEventObject) {
                e.fireEvent('onclick');
                //alert('createEventObject');
                return false;
            }
            else {
                e.click();
                //alert('click');
                return false;
            }
        }
    }
 
}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
    if(typeof initializeLightBox == 'function'){
        //Parche para resolver problemas de sincronizacion. Al abrir el primer box de un contenido
        //se ejecuta el afterOpen antes que los javascript del contenido y esto introducia bugs.
        //solo ocurria la primera ves.
        if(MdAvatarAdmin.getInstance().getDefaultAlbumId() == null)
        {
            setTimeout(function(){ initializeLightBox(json.id, json.className, MdAvatarAdmin.getInstance().getDefaultAlbumId()); }, 500);
        }
        else
        {
            initializeLightBox(json.id, json.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());
        }
    }
    if(typeof mdNewsFeedBackendManager.getInstance().initializeAll == 'function'){
      mdNewsFeedBackendManager.getInstance().initializeAll();
    }
    if(typeof changeCountry == 'function') { 
      changeCountry($("#user_city_value").val());
    }
    
    if(typeof afterOpenLocal == 'function') { 
      afterOpenLocal();
    }
}
