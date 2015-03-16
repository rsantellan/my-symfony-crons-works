var __MD__POST_REGISTER = ''; 

mdUserManagementFrontend = function(options){
    this._initialize();

}

mdUserManagementFrontend.instance = null;
mdUserManagementFrontend.getInstance = function (){
    if(mdUserManagementFrontend.instance == null)
        mdUserManagementFrontend.instance = new mdUserManagementFrontend();
    return mdUserManagementFrontend.instance;
}

mdUserManagementFrontend.prototype = {
    _initialize: function(){

    },

    editProfile: function(url){
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                    $("#user_info").hide();
                    $("#user_edit_info").show();
                    $("#user_edit_info").html(json.options.body);
                }
            }
        });
    },

    finishEditProfile: function(url){
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                    $("#user_info").html(json.options.body);
                    $("#user_info").show();
                    $("#user_edit_info").hide();
                    $("#user_edit_info").html("");
                }
            }
        });
    },

    sendChangeEmail: function(){
        var form = '#change_email_form';
        $("#button_change_mail").hide();
        $("#loader_button_change_mail").show();
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $("#email_error_container").html(" ");
                    $("#loader_button_change_mail").hide();
                    $("#button_change_mail").show();
                    $('#change_email_container').fadeTo("slow", 0.4);
                    $('#change_email_container').fadeTo("slow", 1);
                }else {
                    $("#change_email_container").html(json.options.body);
                }
            }
        });

        return false;
    },

    sendChangePassword: function(){
        var form = '#form_change_password_ajax';
        $("#button_change_pass").hide();
        $("#loader_button_change_pass").show();
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $("#pass_error_container").html(" ");
                    $("#loader_button_change_pass").hide();
                    $("#button_change_pass").show();
                    $('#change_password_container').fadeTo("slow", 0.4);
                    $('#change_password_container').fadeTo("slow", 1);
                }else {
                    $("#change_password_container").html(json.options.body);
                }
            }
        });
        return false;
    },

    sendChangeUserData: function()
    {
        var form = '#md_user_profile_edit_form';
        $("#button_change_user_data").hide();
        $("#loader_button_change_user_data").show();
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $(".user_error_container").html(" ");

                    $('#change_user_container').fadeTo("slow", 0.4);
                    $('#change_user_container').fadeTo("slow", 1);
                    mdUserManagementFrontend.getInstance().saveExistingMdProfiles(0);
                }else {
                    $("#change_user_container").html(json.options.body);
                }
            }
        });
        return false;
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
                        $("#user_new_profile_div_" + data.options.mdProfileId).html(data.options.body);
                        $("#loader_button_change_user_data").hide();
                        $("#button_change_user_data").show();
                    }
                    else
                    {
                        mdUserManagementFrontend.getInstance().saveExistingMdProfiles(position + 1);
                    }
                }
            });
        }
        else
        {
            $("#loader_button_change_user_data").hide();
            $("#button_change_user_data").show();
        }

    },

    sendRegisterForm: function()
    {
        var form = '#register_form';
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function(json) {
                if(json.result == 1){
                    $('#div_registro').html(json.body);
                    $('#register_error').html(json.error);
                    $.fancybox.resize();
                }else{
                    if(json.share != 0){
                        document.location = json.share;
                    } else {
                        if(__MD__POST_REGISTER != ''){
                            document.location = __MD__POST_REGISTER;
                        }else{
                            document.location.reload();
                        }
                    }
                }
            }
        });

        return false;
    },

    setPostRegister: function(page){
        __MD__POST_REGISTER = page;
    }
}

function submitFormAjax(form){
    if($('#user_new_btn') && $('#user_new_loader')){
        $('#user_new_btn').hide();
        $('#user_new_loader').show();
    }

    $.ajax({
        url: $(form).attr('action'),
        data: $(form).serialize(),
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if(json.response == 'OK'){
                document.location.reload();
            }else{
                $('#user_data').html(json.options.body);
                if($('#user_new_btn') && $('#user_new_loader')){
                    $('#user_new_btn').show();
                    $('#user_new_loader').hide();
                }
            }
        }
    });
    return false;
}
