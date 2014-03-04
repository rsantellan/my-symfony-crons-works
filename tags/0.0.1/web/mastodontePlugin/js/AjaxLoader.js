AjaxLoader = function(options){
	this.height = $(document).height();
    this.width = $(document).width();
    this.middleHeight = $(window).height()/2 + $(window).scrollTop();
    this.middleWidth = $(window).width()/2;
    $('<div id="ajax-loader" style="position:absolute; display:none; height:'+this.height+'px;width:'+this.width+'px;background-color:#FFF;opacity:0.7;z-index:2000"><img style="margin-top:'+this.middleHeight+'px;margin-left:'+this.middleWidth+'px;" src="/mastodontePlugin/images/green-circle-ajax-loader.gif" /></div>').prependTo('body');
}

AjaxLoader.instance = null;
AjaxLoader.getInstance = function (){
	if(AjaxLoader.instance == null)
		AjaxLoader.instance = new AjaxLoader();
	return AjaxLoader.instance;
}

AjaxLoader.prototype = {
	_initialize : function(){
    },

    show: function(){
        $('#ajax-loader').css({
            height: $(document).height() + 'px',
            width: $(document).width() + 'px'
        });
        $('#ajax-loader > img').css({
            marginTop: $(window).height()/2 + $(window).scrollTop() + 'px',
            marginLeft: $(window).width()/2 + 'px'
        });

        $('#ajax-loader').show()
    },

    hide: function(){
        $('#ajax-loader').hide()
    }
}

$(document).ready(function(){
    AjaxLoader.getInstance()._initialize();
});