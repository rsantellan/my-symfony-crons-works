var __textoEstaSeguro = "";
var __textoError = "";
var mdNeewsLetterBackend = function(options){
    this._initialize();
}

mdNeewsLetterBackend.instance = null;
mdNeewsLetterBackend.getInstance = function (){
	if(mdNeewsLetterBackend.instance == null)
		mdNeewsLetterBackend.instance = new mdNeewsLetterBackend();
	return mdNeewsLetterBackend.instance;
}

mdNeewsLetterBackend.prototype = {
    _initialize : function(){
        this.modal = null;
    },

    addRow: function(com, grid)
    {
        //var objectId = $('#_MD_Object_Id').attr('value');
        //var className = $('#_MD_Object_Class_Name').attr('value');
        var src = __MD_CONTROLLER_SYMFONY + "/newsletterBackend/newNewsLetterUser";

        $('#iframe-relation-content').attr('src', src);
        
        $( "#dialog-modal" ).dialog({
            width: 'auto',
            height: 'auto',
            modal: true,
            title: 'Aqui usted podra asociar nuevos contenidos'
        });
    },

    addEmail: function()
    {
        parent.mdShowLoading();
        var form = "#newsletter_new_form";
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    parent.$("#flex1").flexReload();
                    parent.$('#dialog-modal').dialog('close');
                }else {
                    $("#new_newsletter_form_container").html(json.options.body);
                }
            },
            complete: function(json){
                parent.mdHideLoading(function(){parent.mdShowMessage("Se ha agregado el mail correctamente")});
            }
        });

        return false;
    },

    cancelAddEmail: function()
    {
        parent.$('#dialog-modal').dialog('close');
    },

    deleteRow: function(com, grid)
    {
        if($('.trSelected', grid).length > 0){
            if(confirm(__textoEstaSeguro)){
                var items = $('.trSelected', grid);
                var ids = '';
                for(i = 0; i < items.length; i++){
                    ids+= $($(items[i]).children()[0]).text();
                    if(i < (items.length - 1)){
                        ids+="-";
                    }
                }
                itemList = [{name : '_MD_Newsletter_Ids', value: ids }];
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: __MD_CONTROLLER_SYMFONY + "/newsletterBackend/removeNewsLetter",
                    data: itemList,
                    success: function(response){
                        $("#flex1").flexReload();
                    }
                });
            }
        } else {
            return false;
        }
        return false;
    },

    addNewEmail: function()
    {
        mdShowLoading();
        var form = "#newsletter_new_form";
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $("#new_newsletter_container").html(json.options.body);
                    $("#add_new_user_success").show().delay(2500).fadeOut("slow");
                    $("#newsletter_cantidad").html(json.options.quantity);
                }else {
                    $("#new_newsletter_container").html(json.options.body);
                }
            },
            complete: function(json){
                mdHideLoading();
            }
        });

        return false;
    },

    removeEmail: function()
    {
        mdShowLoading();
        var form = "#newsletter_remove_form";
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $("#remove_newsletter_container").html(json.options.body);
                    if(json.options.exists == true)
                    {
                      $("#remove_user_success").show().delay(2500).fadeOut("slow");
                    }
                    else
                    {
                      $("#remove_user_no_exists_error").show().delay(2500).fadeOut("slow");
                    }
                    $("#newsletter_cantidad").html(json.options.quantity);
                }else {
                    $("#remove_newsletter_container").html(json.options.body);
                }
            },
            complete: function(json){
                mdHideLoading();
            }
        });

        return false;
    },
    
    saveNewsletterContent: function()
    {
      mdShowLoading();
      $.ajax({
          url: $('#new_newsletter_content').attr('action'),
          data: $('#new_newsletter_content').serialize(),
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.result == 1){
                  mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxAdded('/backend.php/mdNewsletterBackend/closedBox?id='+json.id);
              }else{
                  mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
                  if(typeof multiselectExistsAndIsUsable == 'function'){
                    multiselectExistsAndIsUsable();
                  }                  
              }
          },
          complete: function()
          {
            mdHideLoading();
          }
      });

      return false;      
    },
    
    editNewsletterContent: function(id)
    {
      mdShowLoading();
      $.ajax({
          url: $('#newsletter_edit_form_'+id).attr('action'),
          data: $('#newsletter_edit_form_'+id).serialize(),
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.result == 1){
                  mastodontePlugin.UI.BackendBasic.getInstance().close();
              }else{
                  mastodontePlugin.UI.BackendBasic.getInstance().getActivatedContent().html(json.body);                
              }
          },
          complete: function()
          {
            mdHideLoading();
          }
      });

      return false;      
    },
    
    saveNewsLetterSending: function()
    {
      mdShowLoading();
      $.ajax({
          url: $('#sending_form').attr('action'),
          data: $('#sending_form').serialize(),
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.response == "OK"){
                  $("#table_body_of_sended").prepend(json.options.table_row);
                  $("#table_body_of_sended tr:first").effect("highlight", {}, 3000);
                  $("a.visualizar").fancybox({
                    autoDimensions: false,
                    width: 850
                  });                  
              }
              $("#sending_container").html(json.options.body);
              mastodontePlugin.UI.BackendFloating.getInstance().remove('create_group_right_box');
              
          },
          complete: function()
          {
            mdHideLoading();
          }
      });

      return false;      
    },
    
    removeSendedContent: function(url, id, obj)
    {
      mdShowLoading();
      $.ajax({
            url: url,
            data: {'id': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                  $(obj).parent().parent().fadeOut(300, function() { $(this).remove(); });
                  
                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;      
    },
    
    refreshUsersSelectEmails: function()
    {
        mdShowLoading();
        var url = $("#refreshSelectUsersData").val();
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                  mastodontePlugin.UI.BackendFloating.getInstance().add(json.options.body);
                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;        
    },
    
    refreshGroupsSelectEmails: function()
    {
        mdShowLoading();
        var url = $("#refreshSelectGroupData").val();
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                  mastodontePlugin.UI.BackendFloating.getInstance().add(json.options.body);
                }
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        return false;        
    },
    
    addGroupsForSending: function()
    {
      $("#send_groups").val("");
      
      $("#news_letter_group_form_holder").find(':checkbox').filter(":checked").each(function(index, item){
       var aux = $("#send_groups").val();
       if(aux == "")
       {
         $("#send_groups").val($(item).val());
       }
       else
       {
         aux = aux + "," + $(item).val();
         $("#send_groups").val(aux);
       }
      });
    }, 
    
    groupDeselectAll: function()
    {
      $("#news_letter_group_form_holder").find(':checkbox').attr('checked', false);
      mdNeewsLetterBackend.getInstance().addGroupsForSending();
    },
    
    groupSelectAll: function()
    {
      $("#news_letter_group_form_holder").find(':checkbox').attr('checked', true);
      mdNeewsLetterBackend.getInstance().addGroupsForSending();
    }, 
    
    deselectAll: function()
    {
      $("#group_form_holder").find(':checkbox').attr('checked', false);
    },
    
    selectAll: function()
    {
      $("#group_form_holder").find(':checkbox').attr('checked', true);
      mdNeewsLetterBackend.getInstance().addUsersForSending();
    },
    
    addUsersForSending: function()
    {
      $("#send_users").val("");
      
      $("#group_form_holder").find(':checkbox').filter(":checked").each(function(index, item){
       var aux = $("#send_users").val();
       if(aux == "")
       {
         $("#send_users").val($(item).val());
       }
       else
       {
         aux = aux + "," + $(item).val();
         $("#send_users").val(aux);
       }
      });
    },

    confirmDeleteMdNewsletterContent: function(message, url){
      if(confirm(message))
      {
        mdNeewsLetterBackend.getInstance().deleteMdNewsletterContent(url);
      }
    },

    deleteMdNewsletterContent: function(url){
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
                }
            }
        });

        return false;
    }

}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
  $("a.visualizar").fancybox({
    autoDimensions: false,
    width: 850
  });
}

$(document).ready(function() {
  $("a#import_link").fancybox();
});
