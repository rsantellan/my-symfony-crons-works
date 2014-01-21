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
