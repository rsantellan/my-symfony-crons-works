var __DEFAULT_ALBUM_ID = null;
MdAvatarAdmin = function(options){
	this._initialize();

}

MdAvatarAdmin.instance = null;
MdAvatarAdmin.getInstance = function (){
	if(MdAvatarAdmin.instance == null)
		MdAvatarAdmin.instance = new MdAvatarAdmin();
	return MdAvatarAdmin.instance;
}

MdAvatarAdmin.prototype = {
    _initialize: function(){
        
    },

    setAlbumsDraggablesDroppables: function(){
        var self = this;

        $( ".md_draggable" ).each(function(index, item){
            $(item).draggable({
                revert: true,
                zIndex: 2700,
                containment: "#images_block",
                scroll: false
            });
        });

        $( ".droppableObject" ).each(function(index, item){
            $(item).droppable({
                drop: function( event, ui ) {
                    var url = __MD_CONTROLLER_BACKEND_SYMFONY + '/mdMediaContentAdmin/changeAvatar';
                    var draggableId = $(ui.draggable).attr('id');
                    var elements = draggableId.split("_");

                    $.ajax({
                        url: url,
                        data: {'content_class': elements[2], 'content_id': elements[3], 'object_id': elements[5], 'album_id': elements[4], 'object_class_name': elements[6]},
                        type: 'post',
                        dataType: 'json',
                        success: function(json){
                            if(json.response == "OK"){
                                $('#md_avatar_' + elements[4]).children('img').attr('src', json.options.avatarUrl);
                            }
                        }
                    });
                }
            });
        });

    },

    updateContentSlider: function(obj_id, obj_name, album_id){
        var self = this;
        
        $.ajax({
            url: __MD_CONTROLLER_BACKEND_SYMFONY + '/mdMediaContentAdmin/updateContentSlider',
            data: {'object_class_name': obj_name, 'object_id': obj_id, 'album_id': album_id},
            type: 'post',
            dataType: 'json',
            success: function(json){

                //quitar draggable y dropable
                $( ".md_draggable" ).each(function(index, item){
                    $(item).draggable( "destroy" );
                });

                $( ".droppableObject" ).each(function(index, item){
                    $(item).droppable( "destroy" );
                });

                //$('#album_' + album_id).replaceWith($.trim(json.content));

                self.setAlbumsDraggablesDroppables();

                new MdMouseOverObserver($('div.over_images div img'), 'div.md_remove_thumbs');
                new MdMouseOverObserver($('div.over_images div img'), 'div.media-content-container');
                if($('#loading_avatar') !== null) $('#loading_avatar').hide();
            }
        });
    },

    /**
     * @param obj_id - Objeto duenio del contenido
     * @param obj_name  - Objeto duenio del contenido
     */
    updateContentAlbums: function(obj_id, obj_name)
    {
        var self = this;

        $.ajax({
            url: __MD_CONTROLLER_BACKEND_SYMFONY + '/mdMediaContentAdmin/updateContentAlbums',
            data: {'object_class_name': obj_name, 'object_id': obj_id },
            dataType: 'html',
            type: 'post',
            success: function(response){
                //ver si tengo que hacer evalScripts para IE/Chrome despues de agregar
                $('#user_images').html($.trim(response));

                self.setAlbumsDraggablesDroppables();

                new MdMouseOverObserver($('div.over_images div img'), 'div.md_remove_thumbs');
                new MdMouseOverObserver($('div.over_images div img'), 'div.media-content-container');

                if(typeof initializeLightBox == 'function'){
                    initializeLightBox(obj_id, obj_name, MdAvatarAdmin.getInstance().getDefaultAlbumId());
                }

                if($('#loading_avatar') !== null) $('#loading_avatar').hide();
            }
        });
    },


    removeContent: function(concrete_id, concrete_class,  obj_id, obj_class, album_id, object){
        var url = __MD_CONTROLLER_BACKEND_SYMFONY + '/mdMediaContentAdmin/removeContent';
        var self = this;
        
        $.ajax({
            url: url,
            data: {'object_id': concrete_id, 'object_class': concrete_class},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    MdAvatarAdmin.getInstance().updateContentAlbums(obj_id, obj_class);

//                    $('div.over_images div img').unbind();
//                    new MdMouseOverObserver($('div.over_images div img'), 'div.md_remove_thumbs');
//                    new MdMouseOverObserver($('div.over_images div img'), 'div.media-content-container');
                }
            }
        });
        
        return false;
    },

    setDefaultAlbumId: function(value){
        __DEFAULT_ALBUM_ID = value;
    },

    getDefaultAlbumId: function(){
        return __DEFAULT_ALBUM_ID;
    },

    resetDefaultAlbumId: function(){
        __DEFAULT_ALBUM_ID = null;
    }

}
