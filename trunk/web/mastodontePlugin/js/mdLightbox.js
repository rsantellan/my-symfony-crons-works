/**
 * Extiende el objeto String
 * Convierte una cadena de texto en un Elemento
 * La cadena debe ser un template html ("<div>peteco</div>")
 * @return {Element}
 */
String.prototype.toElement = function(){
	var div = document.createElement("div");
	div.innerHTML = this;
	return div.childNodes[0];
}

/**
 * Extiende el objeto Function
 * Delega un objeto a un metodo
 * @param {Object} instance
 * @param {Function} method
 * @return {Function}
 */
Function.delegate = function $delegate(instance, method) {
	return function() {
		return method.apply(instance, arguments);
	}
}

function isArray(obj) {
   //alert(obj.constructor);
   return Object.prototype.toString.call(obj) === '[object Array]';
}

Util = {
	getTotalWidth : function $util_get_total_width(e){
        /*outerWidth() es el ancho mas el padding y margin*/
		return e.getWidth() + (isNaN(parseInt(e.getStyle("margin-left"))) ? 0 : parseInt(e.getStyle("margin-left"))) + (isNaN(parseInt(e.getStyle("margin-right"))) ? 0 : parseInt(e.getStyle("margin-right")));
	},
	getTotalHeight : function $util_get_total_height(e){
		return e.getHeight() + (isNaN(parseInt(e.getStyle("margin-top"))) ? 0 : parseInt(e.getStyle("margin-top"))) + (isNaN(parseInt(e.getStyle("margin-bottom"))) ? 0 : parseInt(e.getStyle("margin-bottom")));
	},
	getOuterHTML : function(element){
		var div = $(document.createElement("div"));
		div.append(element.clone());
		return div.html();
	}
}

var ModalPoint = Class.create({
    initialize: function(x, y){
        this._x = x;
        this._y = y;
        return {x: this._x, y: this._y}
    }
});

//Manager de los Popups para agruparlos
var mdLightboxManager = Class.create({
	initialize : function (){
            this._popupCollection = {};
            this._count = 0;
            this._currentPopup = null;

            this.setOptions(options);
    },

	addPopup : function(name, popup){
		//if(typeof(this._popupCollection[name]) != "undefined")
			//throw new Error("The name is used by another popup");
		popup._parent = this;
		popup._name = name;
		this._popupCollection[name] = popup;
		this._count ++;
	},
	createAddPopup : function (name, target, options){

	},
	closeCurrentPopup : function(){
		if(this._currentPopup != null){
			this._currentPopup.close();
		}
	},
	notifyOpened : function(popup){
		this._currentPopup = this._popupCollection[popup._name];
	},
	getPopup : function(id){
		return this._popupCollection[id];
	}
});

var mdLightbox = Class.create({
    initialize: function(targetId, options, prevoptions) {
        var self = this;

        this.prevoptions = Object.extend({
            style:         'lightbox', // 'nostyle'
            mainContainerId: 'mdLightboxMainContainer',
            contentContainerId: 'login_content',
            width: '300',
            order: 1,
            height: '300'
        }, prevoptions || {});

        this.createContent();

        this.target = $(targetId) || null;

        this.options = Object.extend({
            opener:         null,
            openerName:     'opener-el',
            relativeTo:     null,
            overlay:        null,
            mode:           Modal.Mode.NORMAL,
            type:           Modal.Type.NORMAL,
            position:       Modal.Position.ABSOLUTE,
            halign:         Modal.HAlign.CENTER,
            valign:         Modal.VAlign.MIDDLE,
            autoPos:        true,
            animate:        false,
            iframe:         false,
            url:            null,
            updateIframe:   false,
            contentId:      null,
            autoScroll:     true,
            initViewportScroll: document.viewport.getScrollOffsets().top,
            contentExtraStyleClass: null,
            modalWidth: null,
            fixTarget:      true,
            overlayTemplate: Modal.Templates.OVERLAY,
            showOverlay:    false,
            overlayOpacity: 0.5,
            overlayColor:   '#000000',
            delay:          500,
            draggable:      true,
            automaticEscClose: true,
            addContentAfterIframe: null,
            ligthboxContent: null,
            iframeWidth: '100%',
            iframeHeight: '100%',
            extra_param: null,
            loadingIcon: 'ajax-loader.gif',


            minimized:      false,
            minWidth:       300,
            minHeight:      300,
            minHAlign:      Modal.HAlign.RIGHT,
            minVAlign:      Modal.VAlign.BOTTOM,
            maxWidth:       0,
            maxHeight:      0,
            maxHAlign:      Modal.HAlign.CENTER,
            maxVAlign:      Modal.VAlign.MIDDLE,

            _onOpeningHandler: null,
            _onOpenedHandler: null,
            _onClosingHandler: null,
            _onClosedHandler: null,

            overOpener: '',

            handler_opener_OnClick : Function.delegate(this, this._opener_OnClick),
            handler_opener_OnMouseOver : Function.delegate(this, this._opener_OnMouseOver),
            handler_opener_OnMouseOut : Function.delegate(this, this._opener_OnMouseOut),

            _name : "noname",
            _parent : null,
            currentOpener : null,
            odlOpener : null,
            opened : false,
            timerPosition : null,
            _target_clickHandler : Function.delegate(this, this._target_OnClick),
            _window_resizeHandler : Function.delegate(this, this._window_OnResize),
            _window_scrollHandler : Function.delegate(this, this._window_OnScroll),
            _window_closeHandler : Function.delegate(this, this._window_OnClose),
            _body_clickHandler : Function.delegate(this, this._body_OnClick)

        }, options || {});

        if(this.options.fixTarget){
            //this.target.setStyle({});
        }

        //extra content
        //this.createExtraContent();

        this.target.hide();

        this.setOpener(this.options.opener);

        if(!this.options.overlay){
            this.options.overlay = $(this.options.overlayTemplate.toElement());
            this.rePositionateOverlay();
            this.options.overlay.id = this.target.id + "_overlay";
            this.options.overlay.setStyle({
                position : "absolute",
                backgroundColor: self.options.overlayColor,
                opacity: self.options.overlayOpacity
            });
            if(Prototype.Browser.IE){
                this.options.overlay.setStyle({
                    opacity: 0,
                    background: "#000000"
                });
                /*this._target.css({
                        "opacity": 0,
                        "background-image": url("pics/spotlight_loader.gif")
                });*/
                var div = $(document.createElement("div"));
                div.setStyle({
                    position: "absolute",
                    left: "0px",
                    top: "0px",
                    right: "0px",
                    bottom: "0px",
                    background: "#000000",
                    opacity: 0,
                    zIndex:-1
                });
                //agregar metodo insertBefore
                //this.target.prepend(div);

            }
            this.options.overlay.hide();
            $(document.body).appendChild(this.options.overlay);
        }

        if(this.options.type == Modal.Type.MODAL){
            this.options.showOverlay = true;
        }
        this._addPopupHandlers();
//        if(this.options.position == Modal.Position.ABSOLUTE){
//            if(this.options.draggable){
//                $(target).select("." + Modal.Names.DRAG).setStyle({"cursor": "move"});
//                this.target.draggable({
//                    handle: "." + Adultmeeter.UI.Popup.Names.DRAG,
//                    helper: "original"
//                });
//            }

            //observador del onclick en el boton de cerrar
            this.target.select("." + Modal.Names.CLOSE).invoke('observe', 'click', this._closeButton_OnClick.bind(this));
    },

    getModalWidth: function(){
      return this.options.modalWidth;
    },

    setModalWidth: function(val){
      this.options.modalWidth = val
    },

    createContent: function(){

        var mainContainer = document.createElement('div');
        mainContainer.id = this.prevoptions.mainContainerId;
        mainContainer.className = "lightbox_container";

        var closeButton = document.createElement('div');
        closeButton.className = "popup_close_button closeButton";

        var contentContainer = document.createElement('div');
        contentContainer.id = this.prevoptions.contentContainerId;
        contentContainer.style.display = "block";

        if(this.prevoptions.style !== 'nostyle'){
            contentContainer.className = "lightbox";
        } else {
            contentContainer.style.width = this.prevoptions.width + 'px';
        }

        contentContainer.style.height = this.prevoptions.height + 'px';

        mainContainer.appendChild(closeButton);
        mainContainer.appendChild(contentContainer);

        document.body.appendChild(mainContainer);
    },

    createIframeContent: function(){
        var self = this;
        if(this.options.iframe !== null){
            var iframeContent = document.createElement('iframe');
            iframeContent.id = 'iframe-el';
            iframeContent.width = this.options.iframeWidth;
            iframeContent.height = this.options.iframeHeight;
            iframeContent.frameBorder = '0';
            $(this.prevoptions.contentContainerId).appendChild(iframeContent);

        }

        if(this.options.url === null && this.options.opener !== null && !isArray(this.options.opener)){
            if(this.options.opener.readAttribute('href') != null){
                this.options.url = $(this.options.opener).readAttribute('href');
            }
        } else {
			this.options.url = this.options.url;
        }

        if(this.options.addContentAfterIframe !== null){
            if($(this.options.addContentAfterIframe) !== null && $(this.options.addContentAfterIframe) !== undefined)
                $(this.options.addContentAfterIframe).remove();
        }
        $('iframe-el').insert({'after' : self.getLightboxAddedContent()});
        
    },

    setUrl: function(url){
        this.options.url = url;
    },

    addContentToLightbox: function(content){
        this.options.ligthboxContent = content;
    },

    getLightboxAddedContent: function(){
        return this.options.ligthboxContent;
    },

    loadIframe: function() {
        this.destroyIframeContent();
        this.options.iframe = true;
        this.createIframeContent();
    },

    destroyIframeContent: function(){
        if($('iframe-el') !== null){
            $('iframe-el').remove();
            this.options.url = null;
        }
    },

    createExtraContent: function(){

        this.createIframeContent();

        if(this.options.contentId !== null){
            $(this.prevoptions.contentContainerId).appendChild($(this.options.contentId));
        }

        if(this.options.contentExtraStyleClass !== null){
            $(this.prevoptions.contentContainerId).addClassName(this.options.contentExtraStyleClass);
        }
    },

    _getXY : function(){
        var x, y;
        if(this.options.relativeTo != null){
            var opener = this.options.relativeTo;
            var parent_location = this.options.relativeTo.getOffsetParent().positionOffset();
            var opener_location = this.options.relativeTo.positionOffset();
            opener_location.left = opener_location.left - parent_location.left;
            opener_location.top = opener_location.top - parent_location.top;
		}else{
            
			if(this.options.currentOpener != null){
                var opener = $(this.options.currentOpener);
                var parent_location = opener.getOffsetParent().positionedOffset();
				var opener_location = opener.positionedOffset();
                opener_location.left = opener_location.left - parent_location.left;
				opener_location.top = opener_location.top - parent_location.top;
			}
		}

        switch(this.options.halign){
			case Modal.HAlign.LEFT:
				x = (this.options.position == Modal.Position.ABSOLUTE) ? 0 + document.viewport.getScrollOffsets().left : opener_location.left + opener.outerWidth() - Util.getTotalWidth(this.target);
				break;
			case Modal.HAlign.RIGHT:
				x = (this.options.position == Modal.Position.ABSOLUTE) ? document.viewport.getWidth() - Util.getTotalWidth(this.target) + document.viewport.getScrollOffsets().left : opener_location.left;
				break;
			case Modal.HAlign.CENTER:
			default:
                x = (this.options.position == Modal.Position.ABSOLUTE) ? (document.viewport.getWidth() - Util.getTotalWidth(this.target))/2 + document.viewport.getScrollOffsets().left : opener_location.left + ((opener.getWidth() /*outerWidth() es el width con padding y margin*/ -  Util.getTotalWidth(this.target))/2);
                break;
        }
        switch(this.options.valign){
			case Modal.VAlign.TOP:
				y = (this.options.position == Modal.Position.ABSOLUTE) ? 0 + document.viewport.getScrollOffsets().top : opener_location.top - Util.getTotalHeight(this.target) + ((this.options.overOpener) ? opener.getHeight()/*outerHeight*/ : 0 );
				break;
			case Modal.VAlign.BOTTOM:
				y = (this.options.position == Modal.Position.ABSOLUTE) ? document.viewport.getHeight() - Util.getTotalHeight(this.target) + document.viewport.getScrollOffsets().top : opener_location.top + opener.getHeight() /*outerHeight*/- ((this.options.overOpener) ? + opener.getHeight() : 0 );
				break;
			case Modal.VAlign.MIDDLE:
			default:
                y = (this.options.position == Modal.Position.ABSOLUTE) ? (document.viewport.getHeight() - Util.getTotalHeight(this.target))/2 + document.viewport.getScrollOffsets().top : opener_location.top + ((opener.getHeight()/*outerHeight()*/ -  Util.getTotalHeight(this.target))/2);
                break;
        }
		return new ModalPoint(x, y);

    },
    setOpener : function(opener){


        var self = this;
        if(opener != null){

            if(isArray(opener)){
                if(this.options.opener != null){
                    if(isArray(this.options.opener)){
                        opener.each(function(opener_element){
                            opener_element.stopObserving("click");
                        });
                    } else {
                        this.options.opener.stopObserving("click");
                    }
                }

                opener.each(function(opener_element){
                    if(self.options.mode == Modal.Mode.NORMAL){
                        opener_element.observe("click", self.options.handler_opener_OnClick.bind(self));
                    }
                });
            } else {
                if(this.options.opener != null){
                    this.options.opener.stopObserving("click");
                    this.options.opener.stopObserving("mouseover");
                    this.options.opener.stopObserving("mouseout");

                }

                
                this.options.opener = opener;
                if(this.options.mode == Modal.Mode.NORMAL){
                    this.options.opener.observe("click", self.options.handler_opener_OnClick.bind(self));
                }else if(this._mode == Modal.Mode.TOOLTIP){
                    this.options.opener.observe("mouseover", self.options.handler_opener_OnMouseOver.bind(self));
                    this.options.opener.observe("mouseout", self.options.handler_opener_OnMouseOut.bind(self));
                }
            }
		}
    },
    _clearPosition : function(){
        this.target.setStyle({
			left: "auto",
			top: "auto"
		});
    },
    _addHandlers : function(){
//        if(this._automaticEscClose){
//			$(window).bind("keyup", this._window_closeHandler);
//		}
//		$(window).fire("resize", this._window_resizeHandler);

		if(this.options.position == Modal.Position.ABSOLUTE){
                var self = this;

                Event.observe(window, 'scroll', self._window_OnScroll.bind(self));
//function(event){
               // self._window_OnScroll(event);
            //});

        }

//        if(this._type == Adultmeeter.UI.Popup.Type.SEMI_MODAL){
//			$(document.body).bind("click", this._body_clickHandler);
//		}
//		this._target.bind("click", this._target_clickHandler);

    },
    _removeHandlers : function(){
        var self = this;
//        if (this._automaticEscClose) {
//			$(window).unbind("keyup", this._window_resizeHandler);
//		}
//		$(window).unbind("resize", this._window_resizeHandler);
		if(this.options.position == Modal.Position.ABSOLUTE){
                    Event.stopObserving(window, "scroll");
                }
            

//        if(this.options.type == Modal.Type.SEMI_MODAL)
//			$(document.body).unbind("click", this._body_clickHandler);
//		this._target.unbind("click", this._target_clickHandler);
    },
    _addPopupHandlers : function(){
        if(this.options._onOpeningHandler != null)
			this.addOnOpening(this.options._onOpeningHandler);
        if(this.options._onOpenedHandler != null)
			this.addOnOpened(this.options._onOpenedHandler);
		if(this.options._onClosingHandler != null)
			this.addOnClosing(this.options._onClosingHandler);
		if(this.options._onClosedHandler != null)
			this.addOnClosed(this.options._onClosedHandler);
    },
    _window_OnResize : function(event){
        this.rePositionate();
		if(this.options.showOverlay)
			this.rePositionateOverlay();
    },
    _window_OnScroll : function(event){
        this.rePositionate();
		if(this.options.showOverlay)
			this.rePositionateOverlay();
    },
    _body_OnClick : function(event){
        if(this.options.type == Modal.Type.SEMI_MODAL){
			if(this.isOpened())
				this.close();
		}
    },
    _window_OnClose : function(event){

    },
    _opener_OnClick : function(event){
        this._oldOpener = this.options.currentOpener;
		this.options.currentOpener = event.target;

        if(this.isOpened() && this.options.currentOpener !== null && this.options.opener.index(this.options.currentOpener) != this.options.opener.index(this._oldOpener)){
//			this.close(Function.delegate(this, function(){
//				this.open();
//			}));
		}
		if($(event.target).readAttribute('href') != null && $(event.target).readAttribute('href') != ''){
	        this.setUrl(event.target.readAttribute('href'));
	    } else if(event.target.up('.'+this.options.openerName) !== undefined && event.target.up('.'+this.options.openerName).readAttribute('href') != null && event.target.up('.'+this.options.openerName).readAttribute('href') != '' ){
	        this.setUrl(event.target.up('.'+this.options.openerName).readAttribute('href'));
	    } else if(event.target.up('#'+this.options.openerName) !== undefined && event.target.up('#'+this.options.openerName).readAttribute('href') != null && event.target.up('#'+this.options.openerName).readAttribute('href') != ''){
			this.setUrl(event.target.up('#'+this.options.openerName).readAttribute('href'));
	    }

		if(!this.isOpened()){
			this.open();
		}else{
			this.close();
		}

        Event.stop(event);
		return false;
    },
    _opener_OnMouseOver : function(event){
        this._oldOpener = this.options.currentOpener;
		this._currentOpener = event.target;
		if(!this.isOpened()){
			//this._timerOpen = setTimeout(Function.delegate(this, this.open), this._delay);
		}
    },
    _opener_OnMouseOut : function(event){
        window.clearInterval(this._timerOpen);
    },
    _target_OnClick : function(event){
        event.stopPropagation();
    },
    _closeButton_OnClick : function(event){
        if((this.closeButtonOnClickCallback !== null) && (typeof(this.closeButtonOnClickCallback) == 'function')){
            this.closeButtonOnClickCallback();
        }
        this.close();
    },

    closeButtonOnClickCallback: null,

    _minimizeButton_OnClick : function(event){
        this.minimize();
    },
    _maximizeButton_OnClick : function(event){
        this.maximize();
    },

    /* METODOS PUBLICOS */

    rePositionate : function (animate){
        var pos = this._getXY();

        if(typeof(animate) != "undefined"){
//			this._target.stop().animate({
//				left: pos.x + "px",
//				top: pos.y + "px"
//			}, animate, "swing");
        }else{
            var container_height = $(this.prevoptions.contentContainerId).getStyle('height');
            var c_height = container_height.toString().replace("px", '');

            if(document.viewport.getDimensions().height < c_height){
                this.options.autoScroll = false;
            } else {
                this.options.autoScroll = true;
            }

            if(this.options.autoScroll){
                var posY = pos._y
            } else {
                var posY = this.options.initViewportScroll;
            }
            
            this.target.setStyle({
                left: pos._x + "px",
                top: posY + "px"
            });
        }        
    },

    rePositionateOverlay : function(){
        this.options.overlay.setStyle({
			top: 0 + document.viewport.getScrollOffsets().top + "px",
			left: 0 + document.viewport.getScrollOffsets().left + "px",
			bottom : 0 - document.viewport.getScrollOffsets().top + "px",
			right : 0 - document.viewport.getScrollOffsets().left + "px"
		});
    },

    open : function (){
        var self = this;
        var el = $(this.target);

        var vpHeight = document.viewport.getDimensions().height / 2;
        var vpLeft = document.viewport.getDimensions().width / 2;
        var orden = 10000 + (this.prevoptions.order * 10) + 1;
        $(self.prevoptions.mainContainerId + '_overlay').innerHTML = '<div style="position:absolute; left:'+vpLeft+'px; top:'+vpHeight+'px;z-index: '+orden+'"><img style="" src="/images/'+self.options.loadingIcon+'" /></div>';
        
        this.setZIndexOrder();
        
        this.options.initViewportScroll = document.viewport.getScrollOffsets().top;

        el.fire(Modal.Events.OPENING, function(event){
            //self.options.currentOpener
        });
        if(this.options._parent != null) this.options._parent.closeCurrentPopup();
		this._addHandlers();
		if(this.options.autoPos)
			this.rePositionate();
        if(this.options.type == Modal.Type.MODAL || (this.options.type == Modal.Type.SEMI_MODAL && this.options.showOverlay)){
			this.rePositionateOverlay();
			this.options.overlay.show();
		}

        if(this.options.url != null){
            if(this.options.updateIframe){
                 $(self.target).show();
                    self.options.opened = true;
                    el.fire(Modal.Events.OPENED, function(event){
                        //self.options.currentOpener;
                    });
                
                if(self.options._onOpenedHandler !== null){
                    self.options._onOpenedHandler();
                }
                
                 $('iframe-el').src = this.options.url;

                 if((self.onWindowOpenCallback !== null) && (typeof(self.onWindowOpenCallback) == 'function')){

                    self.onWindowOpenCallback();
                 }

                 self.updateModalSize();

            } else if(this.options.iframe){
                $(self.target).show();
                    self.options.opened = true;
                    el.fire(Modal.Events.OPENED, function(event){
                        //self.options.currentOpener;
                    });

                if(self.options._onOpenedHandler !== null){
                    self.options._onOpenedHandler();
                }
                
                if($('iframe-el').src === null || $('iframe-el').src == ''){
                    $('iframe-el').src = this.options.url;
                }

                if((this.onWindowOpenCallback !== null) && (typeof(this.onWindowOpenCallback) == 'function')){

                    this.onWindowOpenCallback();
                }

                self.updateModalSize();

            } else {
                var ajaxReq = new Ajax.Request(
                    self.options.url,
                    {
                        method: 'post',
                        onSuccess: function (r, json){
                            
                            var response = "";
                            try
                            {

                                var json_data = r.responseText.evalJSON(true);
                                response = json_data.body;

                            }
                            catch(err)
                            {
                                response = r.responseText;
                            }
                            
                        
                            myScripts = response.extractScripts();
                            var myReturnedValues = myScripts.map(function(script) {
                              return eval(script);
                            });
                            $(self.prevoptions.contentContainerId).innerHTML = response.stripScripts();

                            $(self.prevoptions.mainContainerId +'_overlay').innerHTML = '';
                            if(self.options.animate){
                                self.target.show();
                                self.options.opened = true;
                                if(self.options.parent != null) self.options._parent.notifyOpened(self);
                                el.fire(Modal.Events.OPENED, function(event){
                                    //self.options.currentOpener;
                            });
                        }else{
                            $(self.target).show();
                            self.options.opened = true;
                            el.fire(Modal.Events.OPENED, function(event){
                                //self.options.currentOpener;
                            });
                        }
                        if(self.options._onOpenedHandler !== null){
                            self.options._onOpenedHandler();
                        }
				
                        if((self.onWindowOpenCallback !== null) && (typeof(self.onWindowOpenCallback) == 'function')){

                            self.onWindowOpenCallback();
                        }
                        self.updateModalSize();

                        if(self.options.autoPos)
                            self.rePositionate();
                        if(this.options.type == Modal.Type.MODAL || (this.options.type == Modal.Type.SEMI_MODAL && this.options.showOverlay)){
                            self.rePositionateOverlay();
                            self.options.overlay.show();
                        }

                        

                    }
                });
            }
        } else {
            $("div_content").show();
            $(self.prevoptions.contentContainerId).insert($("div_content"));
            $(self.target).show();
                self.options.opened = true;
                el.fire(Modal.Events.OPENED, function(event){
                    //self.options.currentOpener;
                });

            if(self.options._onOpenedHandler !== null){
                self.options._onOpenedHandler();
            }
        }

        
    },

    setZIndexOrder: function(){
        var ordenOverlay = 10000 + (this.prevoptions.order * 10);
        var orden = 10000 + (this.prevoptions.order * 10) + 1;

        $(this.prevoptions.mainContainerId).setStyle({zIndex : orden});
        $(this.prevoptions.mainContainerId + '_overlay').setStyle({zIndex : ordenOverlay});
    },

    updateModalSize: function(){

        if($(this.prevoptions.contentContainerId).firstDescendant() !== null && $(this.prevoptions.contentContainerId).firstDescendant().id != 'iframe-el'){
            if($(this.prevoptions.contentContainerId).firstDescendant().style.height != ''){
                $(this.prevoptions.contentContainerId).style.height = $(this.prevoptions.contentContainerId).firstDescendant().style.height;
            } else if($(this.prevoptions.contentContainerId).firstDescendant().getStyle('width') && $(this.prevoptions.contentContainerId).firstDescendant().getStyle('height') !== null){
                $(this.prevoptions.contentContainerId).style.height = $(this.prevoptions.contentContainerId).firstDescendant().getStyle('height');
            }

            if($(this.prevoptions.contentContainerId).firstDescendant().style.width != ''){
                $(this.prevoptions.contentContainerId).style.height = $(this.prevoptions.contentContainerId).firstDescendant().style.width;
            } else if($(this.prevoptions.contentContainerId).firstDescendant().getStyle('width') && $(this.prevoptions.contentContainerId).firstDescendant().getStyle('width') !== null){
                $(this.prevoptions.contentContainerId).style.width = $(this.prevoptions.contentContainerId).firstDescendant().getStyle('width');
            }
        }
    },

    onWindowCloseCallback: null,

    onWindowOpenCallback: null,

    close : function (callback){
        $(this.target).fire(Modal.Events.CLOSING, function(event){

        });

        if((this.onWindowCloseCallback !== null) && (typeof(this.onWindowCloseCallback) == 'function')){
            this.onWindowCloseCallback();
        }

		this._removeHandlers();
		if(this.options.type == Modal.Type.MODAL || (this.options.type == Modal.Type.SEMI_MODAL && this.options.showOverlay))
			this.options.overlay.hide();
		if(this.options.animate){
			this.target.hide();
            this.options.opened = false;
            if(callback)
                callback.call(this);
            $(this.target).fire(Modal.Events.CLOSED);


		}else{
			this.target.hide();
			this.options.opened = false;
				if(callback)
					callback.call(this);
			$(this.target).fire(Modal.Events.CLOSED);
		}
    },

    minimize : function (){

    },

    maximize : function (){

    },

    isOpened : function(){
		return this.options.opened;
	},
    removeOpener : function(opener){

    },
    addOnOpening : function(handler){

    },
    removeOnOpening : function(handler){
    },
    addOnOpened : function(handler){

    },
    removeOnOpened : function(handler){
    },
    addOnClosing : function(handler){
    },
    removeOnClosing : function(handler){
    },
    addOnClosed : function(handler){
    },
    removeOnClosed : function(handler){
    },
    addOnMinimizing : function(handler){
    },
    addOnMinimized : function(handler){
    },
    addOnMaximizing : function(handler){
    },
    addOnMaximized : function(handler){
    }

});

var Modal = {
    Names: {
        CLOSE : "popup_close_button",
        MINIMIZE : "popup_minimize_button",
        MAXIMIZE : "popup_maximize_button",
        DRAG : "popup_drag_button"
    },
    Mode: {
        NORMAL : "normal",
        TOOLTIP : "tooltip",
        NONE : "none"
    },

    Type: {
        MODAL : "modal",
        SEMI_MODAL : "semi_modal",
        NORMAL : "normal"
    },
    Position: {
        ABSOLUTE : "absolute",
        RELATIVE : "relative"
    },
    HAlign: {
        LEFT : "left",
        CENTER : "center",
        RIGHT: "right"
    },
    VAlign: {
        TOP : "top",
        MIDDLE : "middle",
        BOTTOM : "bottom"
    },
    Templates: {
        OVERLAY : "<div id='modal_overlay' class='md_overlay'></div>"
    },
    Events: {
        OPENING : "opening",
        OPENED : "opened",
        CLOSING : "closing",
        CLOSED : "closed",
        MINIMIZING : "minimizing",
        MINIMIZED : "minimized",
        MAXIMIZING : "maximizing",
        MAXIMIZED : "maximized"

    },

    Status: {
        INACTIVE : "inactive",
        ACTIVE : "active",
        MINIMIZED : "minimized",
        MAXIMIZED : "maximized"
    }

}
