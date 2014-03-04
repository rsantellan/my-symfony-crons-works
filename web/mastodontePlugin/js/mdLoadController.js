var mdLoadController = function(options){
    this._initialize(options);
}

mdLoadController.instance = null;
mdLoadController.getInstance = function (){
    if(mdLoadController.instance == null)
        mdLoadController.instance = new mdLoadController();
    return mdLoadController.instance;
}

mdLoadController.prototype = {
    _initialize : function(options){
        $(window).scroll(function(){
            $('#upload_container').css("top", $(window).height()/2 + $(window).scrollTop() + "px");
            $('#message_container').css("top", $(window).height()/2 + $(window).scrollTop() + "px");
            $('#message_container').live('click', function(){ mdHideMessage(); });
        });
    },

    show: function(){
         $('#upload_container').css("top", $(window).height()/2 + $(window).scrollTop() + "px");
         $('#upload_container_overlay').css("height", $(document).height());
         $('#upload_container_overlay').show();
         $('#upload_container').show();
    },

    hide: function(){
         $('#upload_container_overlay').hide();
         if(typeof arguments[0] != undefined){
             $('#upload_container').fadeOut('slow', arguments[0]);
         } else{
             $('#upload_container').fadeOut('slow', function() {});
         }

    }
}

//shortcuts to use this controller more easy
mdLoadController.getInstance();

function mdShowLoading(){ mdLoadController.getInstance().show(); }

function mdHideLoading(f){ mdLoadController.getInstance().hide(f); }

function mdShowMessage(text){
    var timer = (arguments[1] != undefined) ? arguments[1] : 5000;
    var hide = (arguments[2] != undefined) ? arguments[2] : true;
    //console.log(hide);
    //console.log(timer);
    $('#message_container').css("top", $(window).height()/2 + $(window).scrollTop() + "px");
    //console.log($('#message_container'));
    $('#message_container .progressWindow').html(text);
    //console.log($('#message_container'));
    $('#message_container').fadeIn('slow', function() {
                 setTimeout(function(){
                    mdHideMessage();
                        }, timer);
        });


}

function mdHideMessage(){
    $('#message_container').fadeOut('slow', function(){});
}
