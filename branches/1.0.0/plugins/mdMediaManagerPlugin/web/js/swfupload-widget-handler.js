if(typeof SWFUpload === "undefined")
{
  throw "Swfupload must be installed to get the queue working";
}

/**
 * Array.indexOf workaround
 */
if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}



var swfu_widget =
{

  handlers: {
    //Este metodo se llama una sola vez cuando se carga el flash
    onLoad: function(){
        MethodsForEvents.calledOnLoad(this);

    },
    onFileDialogStart: function(){
        MethodsForEvents.calledOnFileDialogStart();

    },
    onFileQueued: function(file){
        MethodsForEvents.calledOnFileQueued(file, this);
    },
    onFileQueueError: function(file, error_code, message){
        MethodsForEvents.calledOnFileQueueError(file, error_code, message);
    },
    onFileDialogComplete: function(number_of_files_selected, number_of_files_queued, total_number_of_files_in_queue){
        MethodsForEvents.calledOnFileDialogComplete(number_of_files_selected, number_of_files_queued, total_number_of_files_in_queue, this);
    },
    onUploadStart: function(file){
        MethodsForEvents.calledOnUploadStart(file, this);
    },

    onUploadProgress: function(file, bytes_complete, total_bytes){
        MethodsForEvents.calledOnUploadProgress(file, bytes_complete, total_bytes, this);
    },
    onUploadError: function(file, error_code, message){
        MethodsForEvents.calledOnUploadError(file, error_code, message, this);
    },
    onUploadSuccess: function(file, server_data, received_response){
        MethodsForEvents.calledOnUploadSuccess(file, server_data, received_response, this);
    },
    onUploadComplete: function(file){
        MethodsForEvents.calledOnUploadComplete(file, this);
    },
    onQueueComplete: function(){
        MethodsForEvents.calledOnQueueComplete();
    },
    onPreLoad: function(){
        MethodsForEvents.calledOnPreLoad();
    },
    onLoadFailed: function(){
        MethodsForEvents.calledOnLoadFailed();
    }
  }
  
}

//Implementacion de los metodos disparados por los eventos.
var MethodsForEvents = {

    /**
     * Se llama cuando carga el SWFUpload, es el segundo metodo en ser llamado
     */
    calledOnLoad: function(swf_object){
        var flash_object = swf_object.movieElement;

        flash_object.style.height   = document.getElementById('image-browse').offsetHeight + "px";
        flash_object.style.width    = document.getElementById('image-browse').offsetWidth + "px";
        flash_object.style.left     = document.getElementById('image-browse').offsetLeft + "px";
        flash_object.style.position = "absolute";
        flash_object.style.zIndex   = "1";
        
        document.getElementById('image-browse').style.zIndex = "0";


        flash_object.setAttribute('height', document.getElementById('image-browse').offsetHeight);
        flash_object.setAttribute('width', document.getElementById('image-browse').offsetWidth);
    },

    /**
     * Se invoca cuando se selecciona una imagen para subir (tercero en ser invocado)
     *
     */
    calledOnFileDialogStart: function(){
    },

    /**
     * Es llamado mientras se van encolando imagenes (cuarto en ser invocado)
     *
     */
    calledOnFileQueued: function(file, swf_object){
        try {
//            var progress = new FileProgress(file, swf_object.customSettings.progressTarget);
//            progress.setStatus("Pending...");
//            progress.toggleCancel(true, swf_object);
            var flash_object = swf_object.movieElement;
            var self = this;
            var size = Math.round((file.size /1024) *100)/100 ;
            var size_string = size + ' Kb';
            if(size > 1024){
                size_string = Math.round((size /1024)*100)/100 + ' Mb';
            }
            
            var tableTr = __MD_UPLOAD_FILE_TEMPLATE.replace('{id}',file.id).replace('{name}',file.name).replace('{sizefix}',size_string);

            if(typeof __MD_ALBUM_SELECTED !== "undefined" && __MD_ALBUM_SELECTED !== "")
            {
                tableTr = tableTr.replace('{album}', __MD_ALBUM_SELECTED);

                $('#files > tbody').append((tableTr));

                Feature.addFileParam(file.id, 'album_id', __MD_ALBUM_SELECTED_ID);
                Feature.addFileParam(file.id, 'filename', file.name);

                if($('#'+file.id+' > td > a.rename')[0] !== undefined){
                    $($('#'+file.id+' > td > a.rename')[0]).click(function(){
                        Feature.change(this);
                        self.reposicionateFlash(flash_object);
                    });
                }
                if($('#'+file.id+' > td > a.change')[0] !== undefined){
                    $($('#'+file.id+' > td > a.change')[0]).click(function(){
                        Feature.change(this);
                        self.reposicionateFlash(flash_object);
                    });
                }
            }
            else
            {
                $('#files > tbody').append((tableTr));

                Feature.addFileParam(file.id, 'filename', file.name);

                if(typeof __MD_ALBUM_SELECTED_ID !== "undefined" && __MD_ALBUM_SELECTED_ID !== "")
                {
                    Feature.addFileParam(file.id, 'album_id', __MD_ALBUM_SELECTED_ID);
                }

                if($('#'+file.id+' > td > a.rename')[0] !== undefined){
                    $($('#'+file.id+' > td > a.rename')[0]).click(function(){
                        Feature.change(this);
                        self.reposicionateFlash(flash_object);
                    });
                }
            }

            $('#'+file.id+' > td > a.remove').click(function(){
                swf_object.cancelUpload(file.id, false);
                $('#'+file.id).remove();

                    document.getElementById('stats').innerHTML = $('#files > tbody >tr').length;
                    var flash_object = swf_object.movieElement;
                    self.reposicionateFlash(flash_object);

                    if($('#files > tbody >tr').length == 0){
                        document.getElementById('image-browse').style.display = 'block';
                        document.getElementById('fileblock').style.display = 'none';
                        document.getElementById('status').style.display = 'none';
                        $('#selectview > div.uploadtype').show();

                        flash_object.style.height   = document.getElementById('image-browse').offsetHeight + "px";
                        flash_object.style.width    = document.getElementById('image-browse').offsetWidth + "px";
                        flash_object.style.left     = document.getElementById('image-browse').offsetLeft + "px";
                        flash_object.style.top      = "0px";
                    }

            });

        } catch (ex) {
        }
    },
    calledOnFileQueueError: function(file, error_code, message){
    },

    /**
     * Luego que termino de encolar todas las imagenes se invoca este metdo,
     * Este metodo es el que llama al SWFUpload para decirle que empiece a subir las imagenes (quinto en ser invocado)
     */
    calledOnFileDialogComplete: function(number_of_files_selected, number_of_files_queued, total_number_of_files_in_queue, swf_object){
//        if(number_of_files_queued > 0){
//            swf_object.startUpload();
//        }

        if(number_of_files_queued > 0){
            document.getElementById('image-browse').style.display = 'none';
            $('#selectview > div.uploadtype').hide();
            document.getElementById('fileblock').style.display = 'block';
            document.getElementById('status').style.display = 'none';
            $('#uploadstart').show();
            
            var flash_object = swf_object.movieElement;

            $('#uploadstart').click(function(){
                swf_object.startUpload();
                $('#uploadstart').hide();
                document.getElementById('status').style.display = 'block';

                flash_object.style.height   = document.getElementById('addmore').offsetHeight + "px";
                flash_object.style.width    = document.getElementById('addmore').offsetWidth + "px";
                flash_object.style.left     = document.getElementById('addmore').offsetLeft + "px";
                flash_object.style.top      = document.getElementById('addmore').offsetTop + "px";
            });

            if($('#addmore') != null){
                flash_object.style.height   = document.getElementById('addmore').offsetHeight + "px";
                flash_object.style.width    = document.getElementById('addmore').offsetWidth + "px";
                flash_object.style.left     = document.getElementById('addmore').offsetLeft + "px";
                flash_object.style.top      = document.getElementById('addmore').offsetTop + "px";
            }

            document.getElementById('stats').innerHTML = total_number_of_files_in_queue;
        }
        
    },
    calledOnUploadStart: function(file, swf_object){
        //console.log('startUpload');
        try {
            
//            var progress = new FileProgress(file, swf_object.customSettings.progressTarget);
//            progress.setStatus("Uploading...");
//            progress.toggleCancel(true, swf_object);
        }
        catch (ex) {}

        return true;
    },


    /**
     * Es invocado varias veces mientras se va subiendo cada imagen
     * dando los bites completados hasta ese momento y los demas datos del
     * archivo que se esta subiendo (sexto metodo en ser invocado)
     *
     */
    calledOnUploadProgress: function(file, bytes_complete, total_bytes, swf_object){
        //console.log('calledOnUploadProgress');
        try {
            var percent = Math.ceil((bytes_complete / file.size) * 100);
            
            document.getElementById('progressbar').style.width = percent + '%';

            var progressInfo = document.getElementById('progressinfo');

            var progressText = file.name + " " + bytes_complete + " bytes " + total_bytes + " bytes";
            progressInfo.innerHTML = progressText;
            $('#'+file.id + ' > td.status')[0].innerHTML = percent + '%';

//            var progress = new FileProgress(file, swf_object.customSettings.progressTarget);
//            progress.setProgress(percent);
//            progress.setStatus("Uploading...");

        } catch (exception) {
            
        }
    },
    calledOnUploadError: function(file, error_code, message, swf_object){
        try {

            if (error_code === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
                alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
                return;
            }

            var progress = new FileProgress(file, swf_object.customSettings.progressTarget);
            progress.setError();
            progress.toggleCancel(false);

            switch (error_code) {
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                progress.setStatus("File is too big.");
                this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                progress.setStatus("Cannot upload Zero Byte files.");
                this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                progress.setStatus("Invalid File Type.");
                this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            default:
                if (file !== null) {
                    progress.setStatus("Unhandled Error");
                }
                this.debug("Error Code: " + error_code + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            }
        } catch (ex) {
        }
    },

    /**
     * Si ocurrio todo ok se llama este metodo (septimo metodo)
     *
     */
    calledOnUploadSuccess: function(file, server_data, received_response, swf_object){
        try {
            $(file.id).remove();
//            var progress = new FileProgress(file, swf_object.customSettings.progressTarget);
//            progress.setComplete();
//            progress.setStatus("");
//            progress.setServerData(server_data);
//
//            progress.toggleCancel(false);

        } catch (ex) {
            
        }
    },

    /**
     * Es llamado luego que se completa la subida de cada archivo,
     * (octavo metodo en ser invocado)
     *
     *
     */
    calledOnUploadComplete: function(file, swf_object){
        //console.log('uploadComplete');
        //si todavia hay imagenes para subir llamo el startUpload
        if(swf_object.getStats().files_queued > 0){
            swf_object.startUpload();
        }
    },

    /**
     * Es invocado cuando se completo del upload de todos los archivos
     */
    calledOnQueueComplete: function(){
        document.getElementById('image-browse').style.display = 'block';
        document.getElementById('fileblock').style.display = 'none';
        document.getElementById('status').style.display = 'none';
        $('#selectview > div.uploadtype').show();
        var flash_object = $('#SWFUpload_0');
        flash_object.css('height', document.getElementById('image-browse').offsetHeight + "px");
        flash_object.css('width', document.getElementById('image-browse').offsetWidth + "px");
        flash_object.css('left', document.getElementById('image-browse').offsetLeft + "px");
        flash_object.css('top', "0px");
        
        if(typeof __MD_OBJECT_ID !== "undefined" && __MD_OBJECT_CLASS !== ""){
            if(parent.MdAvatarAdmin !== undefined)
            {
                parent.MdAvatarAdmin.getInstance().updateContentAlbums(__MD_OBJECT_ID, __MD_OBJECT_CLASS);
            }
            if(typeof parent.calledOnQueueCompleteUploaderCallBack == 'function') {
                parent.calledOnQueueCompleteUploaderCallBack(__MD_OBJECT_ID, __MD_OBJECT_CLASS);
            }
        } else if(typeof __MD_OBJECT_CATEGORY !== "undefined"){
            if(parent.mdImageFileGallery !== undefined)
            {
                parent.mdImageFileGallery.getInstance().mdImageFileGallery_UpdateImageAlbum(__MD_OBJECT_CATEGORY);
            }
        }
    },

    /**
     * Metodo que se invoca primero antes cuando se carga la pagina
     */
    calledOnPreLoad: function(){

            
    },
    calledOnLoadFailed: function(){
    },

    reposicionateFlash: function(flash_object){
        if($('#addmore') != null){
            flash_object.style.height   = document.getElementById('addmore').offsetHeight + "px";
            flash_object.style.width    = document.getElementById('addmore').offsetWidth + "px";
            flash_object.style.left     = document.getElementById('addmore').offsetLeft + "px";
            flash_object.style.top      = document.getElementById('addmore').offsetTop + "px";
        }
    }

}