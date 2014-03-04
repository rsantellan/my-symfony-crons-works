mdTranslatorPublish = function(options){
	this._initialize();

}

mdTranslatorPublish.instance = null;
mdTranslatorPublish.getInstance = function (){
	if(mdTranslatorPublish.instance == null)
		mdTranslatorPublish.instance = new mdTranslatorPublish();
	return mdTranslatorPublish.instance;
}

mdTranslatorPublish.prototype = {
	_initialize : function(){
    },

    hasToPublish: function(){
        this.reset();
        $('#message_text').show();
    },

    publishing: function(){
        $('#message_text').find('span#text_to_publish').hide();
        $('#message_text').find('input').hide();
        $('#message_text').find('span#text_publishing').show();
    },

    publishComplete: function(){
        $('#message_text').css({backgroundColor: 'green'});
        $('#message_text').find('span#text_publishing').hide();
        $('#message_text').find('span#text_publishing_complete').show();

        var self = this;
        setTimeout(function(){
            $('#message_text').hide();
            self.reset();
        }, 2000);
    },

    reset: function(){
        $('#message_text').css({backgroundColor: 'red'});
        $('#message_text').find('span#text_to_publish').show();
        $('#message_text').find('input').show();
        $('#message_text').find('span#text_publishing').hide();
        $('#message_text').find('span#text_publishing_complete').hide();
    }
}