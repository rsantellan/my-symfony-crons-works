mdMediaFrontend = function(options){
    this._initialize();

}

mdMediaFrontend.instance = null;
mdMediaFrontend.getInstance = function (){
    if(mdMediaFrontend.instance == null)
        mdMediaFrontend.instance = new mdMediaFrontend();
    return mdMediaFrontend.instance;
}

mdMediaFrontend.prototype = {
    _initialize: function(){

    },

    changeAlbumDefault: function(url, idAlbum, idImagen)
    {
        if(typeof calledPreOnChangeAlbumDefault == 'function') {
            calledPreOnChangeAlbumDefault();
        }
        var dataString = 'idAlbum=' + idAlbum + '&idImagen='+idImagen;
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: dataString,
            success: function(data){
                if(data.response == "OK"){
                if(typeof calledOnChangeAlbumDefault == 'function') {
                        calledOnChangeAlbumDefault(idAlbum);
                    }
                }else{

                }
            },
            complete: function(data)
            {
                if(typeof calledOnChangeAlbumDefaultComplete == 'function') {
                        calledOnChangeAlbumDefaultComplete(idAlbum);
                    }
            }

        });
        return false;
    },

    changeDefault: function(url, idImagen)
    {
        if(typeof calledPreOnChangeDefault == 'function') {
            calledPreOnChangeDefault();
        }
        var dataString = 'idImagen='+idImagen;
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: dataString,
            success: function(data){
                if(data.response == "OK"){
                    if(typeof calledOnChangeDefault == 'function') {
                        calledOnChangeDefault();
                    }
                }else{

                }
            },
            complete: function(data)
            {
                if(typeof calledOnChangeDefaultComplete == 'function') {
                        calledOnChangeDefaultComplete(idAlbum);
                    }
            }

        });
        return false;
    }
  
}