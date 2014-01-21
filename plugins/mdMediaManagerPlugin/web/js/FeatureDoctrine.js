var Feature = (function()
{
    var onChange    = null;
    var onBlur      = null;
    var _linkAlbum  = null;
    var _linkName   = null;

    var swfUpload   = null;
    
    //Constructor
    function constructor(){}

    function setSwfUpload(o){ swfUpload = o; }

    function setOnChange(f){ onChange = f; }

    function setOnBlur(f){ onBlur = f; }

    function getLinkAlbum(){ return _linkAlbum; }

    function getLinkName(){ return _linkName; }

    function getSwfUpload(){ return swfUpload; }

    function addFileParam(file_id, name, value){ swfUpload.addFileParam(file_id, name, value); }

    function removeFileParam(file_id, name){ swfUpload.removeFileParam(file_id, name); }

    function change(obj)
    {
        //Obtengo el elemento DOM (input | select)
        var element = document.getElementById(obj.className);
        element.value = obj.firstChild.nodeValue;
        element.style.display = 'block';

        var type = $(element).attr('tipo');

        if(type == 'text') _linkName = obj;
        if(type == 'select') _linkAlbum = obj;

        //RESTAURAR EL ANTERIOR
        if(document.getElementById(obj.className).parentNode.id != 'multiupload_view'){
            document.getElementById(obj.className).parentNode.firstChild.style.display = 'block';
        }
        //Ocultamos el obj donde hacemos click
        obj.style.display = 'none';

        //Quitamos todos los observadores
        $(element).unbind();

        //Seteamos los callback
        if(type == 'text'){
            $(element).blur(function(){
                if(onBlur != null){
                    onBlur();
                }
            });
        }
            
        if(type == 'select'){
            //Setearle el seleccionado
            document.getElementById('change').options[getIndex(document.getElementById('change'), _linkAlbum.parentNode.childNodes[1].value)].selected = true;

            $(element).change(function(){
                if(onChange != null){
                    onChange();
                }
            });
        }

        //Lo elimino del DOM
        document.getElementById(obj.className).parentNode.removeChild(document.getElementById(obj.className));

        //Insertamos el elemento hermano al objeto donde hacemos click
        obj.parentNode.appendChild(element);
        //Le damos el foco al input
        if(type == 'text'){ element.focus(); }
    }

    constructor.change          = change;
    constructor.setOnChange     = setOnChange;
    constructor.setOnBlur       = setOnBlur;
    constructor.setSwfUpload    = setSwfUpload;
    constructor.getSwfUpload    = getSwfUpload;
    constructor.getLinkAlbum    = getLinkAlbum;
    constructor.getLinkName     = getLinkName;
    constructor.addFileParam    = addFileParam;
    constructor.removeFileParam = removeFileParam;
    return constructor;

})();

function getIndex(obj, value)
{
    for(var i = 0; i < obj.options.length; i++){
        if(value == obj.options[i].value)
            return i;
    }
    return -1;
}

//Seteo callback sobre el input
Feature.setOnBlur(function(){
    //Aprontamos el input
    var element = document.getElementById(Feature.getLinkName().className);
    var filename = element.value;
    element.value = "";
    element.style.display = 'none';
    
    //Lo elimino del DOM
    document.getElementById(Feature.getLinkName().className).parentNode.removeChild(document.getElementById(Feature.getLinkName().className));

    Feature.getLinkName().firstChild.nodeValue = filename;

    //Agregarlo como parametro
    Feature.addFileParam(Feature.getLinkName().parentNode.parentNode.id, 'filename', filename);

    //Mostramos el vinculo
    Feature.getLinkName().style.display = 'block';

    //Lo insertamos a lo ultimo
    document.getElementById('multiupload_view').appendChild(element);
});

Feature.setOnChange(function(){    
    //Obtengo el select global guardando una copia a el
    var element = document.getElementById(Feature.getLinkAlbum().className);

    //Lo ocultamos
    element.style.display = 'none';

    //Lo elimino del DOM
    document.getElementById(Feature.getLinkAlbum().className).parentNode.removeChild(document.getElementById(Feature.getLinkAlbum().className));

    //Mostramos el vinculo
    Feature.getLinkAlbum().style.display = 'block';

    //Lo insertamos a lo ultimo oculto
    document.getElementById('multiupload_view').appendChild(element);

    //Seteamos el parametro en el File
    Feature.addFileParam(Feature.getLinkAlbum().parentNode.parentNode.id, 'album_id', document.getElementById('change').options[document.getElementById('change').selectedIndex].value);

    //Seteamos el parametro en el a
    Feature.getLinkAlbum().firstChild.nodeValue = document.getElementById('change').options[document.getElementById('change').selectedIndex].text;

    //seleccionamos el primero
    Feature.getLinkAlbum().parentNode.childNodes[1].value = document.getElementById('change').options[document.getElementById('change').selectedIndex].value;

});


function basicUpload(){
    document.getElementById('multiupload_view').style.display = 'none';
    document.getElementById('singleupload_view').style.display = 'block';
}

function swfUpload(){
    document.getElementById('multiupload_view').style.display = 'block';
    document.getElementById('singleupload_view').style.display = 'none';
}

function startUpload(){
    document.getElementById('upload_container_overlay').style.display = 'block';
    document.getElementById('upload_container').style.display = 'block';
    document.getElementById('uploadForm_0').submit();
}

function endUpload(){
    //Limpiar el formulario
    if(typeof document.getElementById('uploadForm_0').filename != 'undefined'){
        document.getElementById('uploadForm_0').filename.value = "";        
    }
    document.getElementById('uploadForm_0').upload.value = "";
    document.getElementById('upload_container_overlay').style.display = 'none';
    document.getElementById('upload_container').style.display = 'none';

    if(parent.MdAvatarAdmin !== undefined)
    {
        parent.MdAvatarAdmin.getInstance().updateContentAlbums(arguments[0], arguments[1]);
    }
    if(parent.mdImageFileGallery !== undefined)
    {
        parent.mdImageFileGallery.getInstance().mdImageFileGallery_UpdateImageAlbum(arguments[0]);
    }
    if(typeof parent.calledOnQueueCompleteBasicUploaderCallBack == 'function') {
        parent.calledOnQueueCompleteBasicUploaderCallBack(__MD_OBJECT_ID, __MD_OBJECT_CLASS);
    } 
}
