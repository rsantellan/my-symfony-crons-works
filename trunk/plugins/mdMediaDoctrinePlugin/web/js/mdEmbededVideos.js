
mdEmbededVideos = function(options){
	this._initialize();

}

mdEmbededVideos.instance = null;
mdEmbededVideos.getInstance = function (){
	if(mdEmbededVideos.instance == null)
		mdEmbededVideos.instance = new mdEmbededVideos();
	return mdEmbededVideos.instance;
}

mdEmbededVideos.prototype = {
    _initialize: function(){
        
    },
    
    sendVideo: function(obj)
    {
      var type = $(obj).find("input[name='mdVideoType']").val();
      $("#button_submit_video").hide();
      $("#loader_submit_video").show();
      $.ajax({
        type: "POST",
        url: $(obj).attr('action'),
        dataType: "json",
        data: $(obj).serialize(),
        success: function(data){
            if(data.response == "OK"){
                
                //$("#boxes").replaceWith(data.options.body);
                
                if(typeof parent.$.fancybox == 'function') {
                  parent.$.fancybox.close();
                }
                
                //$("#videos_container").prepend(data.options.bodyVideo);
                
                var obj_id = data.options.object_id;
                var obj_class = data.options.object_class_name;
                if(typeof parent.MdAvatarAdmin == 'function') { 
                  parent.MdAvatarAdmin.getInstance().updateContentAlbums(obj_id, obj_class);
                }
                
            }else{
                if(data.options.hasOwnProperty('body')){
                  $("#mdForm_" + type).html(data.options.body);
                }
                if(data.options.hasOwnProperty('message')){
                  parent.mdShowMessage(data.options.message);
                }
            }
        },
        complete: function(json){
            $("#button_submit_video").show();
            $("#loader_submit_video").hide();
        }

      });
    
      return false;      
    }
    
  }
/*
function setYouTubeImage()
{

    $(".youtube_image img").each(function(index) {
        var src = $.jYoutube($(this).attr("youtubesrc"), 'small');
        $(this).attr("src", src);
    });
}
function sendVideo()
{
    mdShowLoading();
    $.ajax({
        type: "POST",
        url: $('#addvideo').attr('action'),
        dataType: "json",
        data: $('#addvideo').serialize(),
        success: function(data){
            if(data.response == "OK"){
                $("#boxes").replaceWith(data.options.body);
                $.fancybox.close();
                $("#videos_container").prepend(data.options.bodyVideo);
                setYouTubeImage();
                var obj_id = data.options.object_id;
                var obj_class = data.options.object_class_name;
                MdAvatarAdmin.getInstance().updateContentAlbums(obj_id, obj_class);
                clearForm("addvideo");
            }else{
                $("#boxes").replaceWith(data.options.body);
            }
        },
        complete: function(json){
            mdHideLoading();
        }

    });
    
    return false;
}

function clearForm(formId)
{
  $(':input','#'+formId)
   .not(':button, :submit, :reset, :hidden')
   .val('')
   .removeAttr('checked')
   .removeAttr('selected');  
}
*/
