mdTranslatorViewHandler = function(module){
	this.module = module;
    this.containerId = '#datos';
    this.activatedContent = null;
    this._initialize();

}

mdTranslatorViewHandler.prototype = {
	_initialize : function(){
        var self = this;
        
        this.accordion_options = {
            collapsible: true,
            active: false,
            icons: false,
            header: 'div.accordion-header',
            autoHeight: false,
            changestart: function(event, ui){
                var page = $(this).find('.ui-state-active').attr('text-page');

                if($(ui.oldContent).length > 0){
                    $(ui.oldContent).html('');
                }
                if(page !== undefined){
                    self.setActivatedContent(ui.newContent);
                    self.loadTexts(page, ui.newContent);
                } else {
                    $(ui.oldContent).html('');
                    //self.showHeader(ui.oldContent, $(ui.oldContent).find('div:first').attr('ajax-url'));
                    //if(!self.hasNew){
                      //  $(ui.newContent).html(TEMPLATES.LOADING_TEMPLATE);
                    //}

                }
            }

        };
    },

    setActivatedContent: function(content){
        this.activatedContent = content;
    },

    getActivatedContent: function(){
        return this.activatedContent;
    },

    getActivatedHeader: function(){
        return $(this.getActivatedContent()).prev('div.accordion-header');
    },

    init: function(){
        $(this.containerId).accordion('destroy').accordion(this.accordion_options);
    },

    getTexts: function(obj){
        //this.highlight_div(obj);
        if(obj.checked){
            this.loadTextBoxes(obj.value );
        }else{
            if($(obj.value) != null){
                $('div.' + obj.value).each(function(index, element){
                  var parent = $(element).prev();
                  $(element).remove();
                  $(parent).remove();
                });
                $(this.containerId).accordion('destroy').accordion(this.accordion_options);
            }
        }
    },

    loadTexts: function(page, content){
        url = __MD_CONTROLLER_SYMFONY + '/mdTranslator/getContentToEdit';
        
        var full_key = $(content).prev('div.accordion-header').find('input.full_key').attr('value');
        
        $.ajax({
            url: url,
            data: {'app': $('#application').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value'), 'full_key': full_key, 'key': page, 'base': $('#base_language').attr('value'), 'search': $('#search').val(), 'search_target': $('#search_target').is(':checked')},
            dataType: 'html',
            type: 'post',
            success: function(html){
                $(content).html(html);
            }
        });
    },


    /**
     *  Recibe la pagina para la cual tiene que traer los textos,
     *  trae el box cerrado armado y lo agrega al DOM
     */
    loadTextBoxes: function(page){
        mdShowLoading();        
        url = __MD_CONTROLLER_SYMFONY + '/'+this.module+'/getTranslationsFormsHeader';
        var self = this;
        $.ajax({
            url: url,
            data: {'app': $('#application').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value'), 'page': page, 'index': index, 'baselang': $('#base_language').attr('value'), 'search': $('#search').val(), 'search_target': $('#search_target').is(':checked')},
            dataType: 'html',
            type: 'post',
            success: function(html){
                mdHideLoading();                
                $('#datos').append(html);
                $(self.containerId).accordion('destroy').accordion(self.accordion_options);
            }
        });
    },

    close: function(){
        mdTranslator.getInstance().removeTinyTextArea();
        $(this.containerId).accordion("option", "active", false);
        $(this.getActivatedContent()).html('');
    },

    updateHeader: function(value){
        var len = 100;
        if(value.length > len){
            value = value.substring(0, len);
            value = value.replace(/\w+$/, '');
            value += '...';
        }
        $(this.getActivatedHeader()).find('span.translation_text').html(value);
    }

}
