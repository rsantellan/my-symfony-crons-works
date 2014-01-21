/**
 * La clase MdContentList es un Contendor de objetos MdContentBox,
 * MdContentList es un singleton, y se accede con la variable mdContentList.
 *
 * - crear un objeto mdContentBox
 * var mdContentBox = new MdContentBox({
 *     id: <String>,
 *     url: <String>
 * });
 *
 * - agrear un mdContentBox al mdContentList:
 *
 * mdContentList.setContentBox(mdContentBox);
 *
 * - cargar contenido en el box:
 * - si el objeto <el> tiene seteado un href el contenido
 * lo carga por ajax
 * MdContentList.showContentBox(<id>, <el>, event);
 *
 * -Callback afterLoadContent es llamado en el success del ajax y
 * contiene el response del ajax, este metodo lo definimos nosotros cuando
 * creamos la instancia de cada MdContentBox con lo querramos
 * hacer con el contenido:
 *
 * MdContentBox.afterLoadContent
 *
 * - Si queremos que la ventana acompa;e el scroll tenemos que decirle con
 * MdContentList.mooveContentBox(<objToMoove>)
 *
 *
 *
 */

var MdContentList = Class.create({
    initialize: function(options) {
        this.options = Object.extend({
            contentBox: new Array()
        }, options || {});
    },

    setContentBox: function(objectBox){
        this.options.contentBox.push(objectBox);
    },

    showContentBox: function(id, el, event){
        var loadContentAfterOpen = (arguments[3] !== undefined)? true : false;
        var self = this;
        Event.stop(event);
        
        this.options.contentBox.each(function(contentBox, index){
            if(contentBox.getId() == id){
                contentBox.setVisible();

                if(el.href !== null && loadContentAfterOpen){
                    contentBox.setUrl(el.href);
                    self.loadContent(id, event);
                }
            }
        });
    },

    getContentObject: function(id){
        var obj = null;
        this.options.contentBox.each(function(contentBox, index){
            if(contentBox.getId() == id){
                obj = contentBox;
            }
        });
        return obj;
    },

    hideContentBox: function(id, event){
        Event.stop(event);
        this.options.contentBox.each(function(contentBox, index){
            if(contentBox.getId() == id){
                contentBox.setHidden();
            }
        });
    },

    loadContent: function(id, event){
        Event.stop(event);
        this.options.contentBox.each(function(contentBox, index){
            if(contentBox.getId() == id){
                contentBox.loadContent();
            }
        });
    },

    mooveContentBox: function(objToMoove){
        var offsetOfCategoryTop = objToMoove.viewportOffset().top;
        var offsetOfcategoryLeft = objToMoove.viewportOffset().left;
        Event.observe(document, 'scroll', function(){
            if(document.viewport.getScrollOffsets().top < offsetOfCategoryTop){
                objToMoove.style.position = "relative";
                objToMoove.style.left = "0px";
            } else {
                objToMoove.style.position = "fixed";
                objToMoove.style.left = offsetOfcategoryLeft + "px";
            }
        });
    }
  
    
});

var mdContentList = new MdContentList();

var MdContentBox = Class.create({
    initialize: function(options) {
        this.options = Object.extend({
            id: null,
            url: null
        }, options || {});
    },
    
    getId: function(){
        return this.options.id;
    },

    setUrl: function(url){
        this.options.url = url;
    },

    setVisible: function(){
        $(this.options.id).style.visibility='visible';
    },

    setHidden: function(){
        $(this.options.id).style.visibility='hidden';
    },

    loadContent: function(){
        var self = this;
        var params = (this.options.url.match(/\?.*([a-z]*)/) !== null)? this.options.url.match(/\?.*([a-z]*)/)[0].replace(/\?/, '') : '';

        var myAjax = new Ajax.Request(this.options.url, {
            method: 'post',
            parameters: params,
            onLoading: function(){
            },

            onFailure: function(){
            },

            onSuccess: function (response){
                if(self.afterLoadContent !== null){
                    self.afterLoadContent(response);
                }
            }
        });
    },

    afterLoadContent: null
});
