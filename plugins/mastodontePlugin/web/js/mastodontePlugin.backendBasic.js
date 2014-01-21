TEMPLATES = {
    LOADING_TEMPLATE: '<img src="/mastodontePlugin/images/md-ajax-loader.gif" />'
}

jType.registerNamespace('mastodontePlugin.UI');

mastodontePlugin.UI.BackendBasic = function(options){
	this._initialize();
    
}

mastodontePlugin.UI.BackendBasic.instance = null;
mastodontePlugin.UI.BackendBasic.getInstance = function (){
	if(mastodontePlugin.UI.BackendBasic.instance == null)
		mastodontePlugin.UI.BackendBasic.instance = new mastodontePlugin.UI.BackendBasic();
	return mastodontePlugin.UI.BackendBasic.instance;
}

mastodontePlugin.UI.BackendBasic.prototype = {
	_initialize : function(){
        var self = this;
        this.hasNew = false;
        this.stop = false;
        this.activatedContent = null;
        this.containerId = "#md_objects_container";
        this.addingNew = false;
        this.isSortable = true;
        this.eventStart = "click";
        
        this.sortable_options = {
                axis: "y",
                handle: "div.accordion-header",
                stop: function(event, ui) {
                    self.stop = true;
                    var ids = new Array();
                    var classNames = new Array();
                    var priorities = new Array();
                    var _priorities, _ids, _classNames;
                    $( "div.accordion-header" ).each(function(index, item){
                        ids[index] = $(item).find('input[name=_MD_OBJECT_ID]').attr('value');
                        classNames[index] = $(item).find('input[name=_MD_OBJECT_CLASS_NAME]').attr('value');
                        priorities[index] = (index+1);
                        _ids        = ids.join('|');
                        _classNames = classNames.join('|');
                        _priorities = priorities.join('|');
                    });
                    $.ajax({
                        url: __MD_CONTROLLER_SYMFONY + "/mdSortable/sortable",
                        dataType: 'json',
                        type: 'POST',
                        data: [{name : '_MD_Object_Ids', value: _ids}, {name: '_MD_Object_Class_Names', value: _classNames}, {name: '_MD_Priorities', value: _priorities}],
                        success: function(json){
                            switch(json.response)
                            {
                                case 'OK':break;
                                case 'ERROR':alert(json.options.message);break;
                                default:alert('Internal Server Error');break;
                            }
                        }
                    });
                    
                }
            };
    },

    getActivatedContent: function(){
        return this.activatedContent;
    },

    setActivatedContent: function(activated){
        this.activatedContent = activated;
    },

    setSortable: function(value){
        this.isSortable = value;
    },

    init : function(){
        this.containerId = (arguments[0] != undefined) ? arguments[0] : this.containerId;
        this.eventStart = (arguments[1] != undefined) ? arguments[1] : this.eventStart;
        this.isSortable = (arguments[2] != undefined) ? arguments[2] : this.isSortable;
        var self = this;
      $( "div.accordion-header" ).click(function( event ) {
			if ( self.stop ) {
				event.stopImmediatePropagation();
				event.preventDefault();
				self.stop = false;
			}
		});

        if(this.isSortable){
            $(this.containerId).accordion(self.retrieveAccordionOptions())
                .sortable(this.sortable_options);
        } else {
            $(this.containerId).accordion(self.retrieveAccordionOptions());
        }
        
	},
  
    retrieveAccordionOptions: function()
    {
      var accordion_options = {
            collapsible: true,
            active: false,
            icons: false,
            header: 'div > div.accordion-header',
            autoHeight: false,
            event: this.eventStart,
            changestart: function(event, ui){
                var url = $(this).find('.ui-state-active div:first').attr('ajax-url');

                if(url !== undefined){
                    if($(ui.oldContent).length > 0){
                        $(ui.oldContent).html(TEMPLATES.LOADING_TEMPLATE);
                    }

                try{

                    if(typeof(tinyMCE.activeEditor) != "undefined")
                        tinyMCE.activeEditor.remove();

                }catch(e){
                    //alert(e);
                }

                    mastodontePlugin.UI.BackendBasic.getInstance().setActivatedContent(ui.newContent);
                    mastodontePlugin.UI.BackendBasic.getInstance().getDetails(url);
                } else {
                    mastodontePlugin.UI.BackendBasic.getInstance().showHeader(ui.oldContent, $(ui.oldContent).find('div:first').attr('ajax-url'));
                    if($(ui.oldContent).length > 0){
                        $(ui.oldContent).html(TEMPLATES.LOADING_TEMPLATE);
                    }
                    if(!mastodontePlugin.UI.BackendBasic.getInstance().hasNew){
                        $(ui.newContent).html(TEMPLATES.LOADING_TEMPLATE);
                    }
                    
                }
                if(mastodontePlugin.UI.BackendFloating !== undefined)
                {
                    mastodontePlugin.UI.BackendFloating.getInstance().remove();
                }
            }

        };
        return accordion_options;
    },

    getDetails: function(url){
        //respuesta del ajax:
        //{content: 'html con contenido'}
        
        var self = this;
        
        $(this.getActivatedContent()).html(TEMPLATES.LOADING_TEMPLATE);
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(json){
                if($('#new-box-header').length > 0 && $('#new-box-body').length > 0){
                    $('#new-box-header').remove();
                    $('#new-box-body').remove();
                }

                $(self.getActivatedContent()).html(json.content);

                if(typeof(self.afterOpen) == 'function'){
                    self.afterOpen(json);
                }
            }
        });

    },

    showHeader: function(objectContent, url){
        var self= this;
        if(url !== undefined){
            $.ajax({
                url: url,
                dataType: 'json',
                success: function(json){
                    $(objectContent).prev('.accordion-header').html(json.content);

                    if(typeof(self.afterClose) == 'function'){
                        self.afterClose(json);
                    }
                }
            });
        }
    },

    afterOpen: null,
    afterClose: null,
    afterAdd: null,

    removeNew: function(){
        $('#new-box-header').remove();
        $('#new-box-body').remove();
        this.hasNew = false;

        if(this.isSortable){
            $(this.containerId).accordion('destroy').accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions())
                .sortable(this.sortable_options);
        } else {
            $(this.containerId).accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions());
        }

    },

    removeActiveBox: function(){
        $(this.containerId).find('.ui-state-active').next('div.accordion-body').remove();
        $(this.containerId).find('.ui-state-active').remove();

        if(this.isSortable){
            $(this.containerId).accordion('destroy').accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions())
                .sortable(this.sortable_options);
        } else {
            $(this.containerId).accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions());
        }
    },

    close: function(){
        //Esto lo comento por que en la funcion del accordeon cuando cierra llama a este metodo
        //this.showHeader($(this.getActivatedContent()), $(this.getActivatedContent()).find('div:first').attr('ajax-url'));
        if($('#new-box-header').length > 0 && $('#new-box-body').length > 0){
            $('#new-box-header').slideUp("normal", function() { $(this).remove(); } );
            $('#new-box-body').slideUp("normal", function() { $(this).remove(); } );
            return true;
        }
        $(this.containerId).accordion("option", "active", false);

        $(this.getActivatedContent()).html(TEMPLATES.LOADING_TEMPLATE);
    },
    
    openManually: function(id){
      $(this.containerId).accordion( "activate", "#accordion_header_id_" + id );
    },

    addBox: function(){
        var self = this;
        this.hasNew = true;

        this.close();
        
        if($('#new-box-header').length == 0 && $('#new-box-body').length == 0 && !this.addingNew){
            this.addingNew = true;
            $.ajax({
                url: $('#addBox').attr('href'),
                dataType: 'json',
                success: function(json){
                    var closed = '<div id="new-box-header" class="accordion-header"></div>';
                    var open = '<div id="new-box-body" class="accordion-body">'+json.content+'</div>';

                    $(self.containerId).prepend(open);
                    $(self.containerId).prepend(closed);

                    self.addingNew = false;
                    if(typeof(self.afterAdd) == 'function'){
                        self.afterAdd(json);
                    }                    
                }
            });
        }
        
    },

    /**
     * Se debe llamar en el Success de cuando se creo un nuevo box (noticia, usuario etc...)
     * debe recibir la url que trae el contenido cerrado que a su vez tiene el id del nuevo contenido
     *
     */
    onNewBoxAdded: function(closedUrl){
        if($('#new-box-header').length > 0 && $('#new-box-body').length > 0){
            var self = this;
            $('#new-box-header').remove();
            $('#new-box-body').remove();
            self.hasNew = false;
            $.ajax({
                url: closedUrl,
                dataType: 'json',
                success: function(json){
                    var closed = '<div class="accordion-header">'+json.content+'</div>';
                    var open = '<div class="accordion-body">'+TEMPLATES.LOADING_TEMPLATE+'</div>';
                    $(self.containerId).prepend('<div></div>');
                    
                    $(self.containerId + "> div:first-child").prepend(open);
                    $(self.containerId + "> div:first-child").prepend(closed);
                    
                    
                    if(self.isSortable){
                         $(self.containerId).accordion('destroy').accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions())
                            .sortable(self.sortable_options);
                    } else {
                        $(self.containerId).accordion('destroy').accordion(mastodontePlugin.UI.BackendBasic.getInstance().retrieveAccordionOptions());
                    }
                    
                    $(self.containerId).accordion("option", "active", false);
                    $(self.containerId).accordion("activate", 0);

                    if(typeof(self.afterOpen) == 'function'){
                        self.afterOpen(json);
                    }

                }
            });

            
        }
    },

    onNewBoxError: function(content){
        $('#new-box-body').html(content);
    },

    destroy: function()
    {
      $(this.containerId).accordion('destroy');
      mastodontePlugin.UI.BackendBasic.instance = null;
    },
    
    disable: function()
    {
      $(this.containerId).accordion( "option", "disabled", true );
    },
    
    enable: function()
    {
      $(this.containerId).accordion( "option", "disabled", false );
    },

    doPager: function(url, page)
    {
        if($('#page_filter_id').length > 0)
        {
            //console.log(url + page);
            $('#page_filter_id').val(page);
            //console.log($('#md_filter'));
            $('#md_filter').submit();
        }
        else
        {
            window.location = url;
        }
    }
    
}
