var index = 0;
var indexPages = 0;
var __MD_CONTROLLER_SYMFONY_PLUGIN_TRANSLATOR_OBJECT = '/backend_dev.php';

var mdPluginTranslatorObjectDoctrine = function(options){


}

mdPluginTranslatorObjectDoctrine.instance = null;
mdPluginTranslatorObjectDoctrine.getInstance = function (){
	if(mdPluginTranslatorObjectDoctrine.instance == null)
		mdPluginTranslatorObjectDoctrine.instance = new mdPluginTranslatorObjectDoctrine();
	return mdPluginTranslatorObjectDoctrine.instance;
}

mdPluginTranslatorObjectDoctrine.prototype = {
	_initialize : function(){
        this.changeApp();
		this.changePages();
		this.changeLenguages();
    },

    save: function(form){
        error = form +'_error';
        $(error).hide();
        
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'html',
            success: function(html){
                if(html == 'ok'){
                    place = form +'_result';
                    $(place).show();
                    $(place).fadeOut(3000);
                }else{
                    $(error).html(html);
                    $(error).show();
                }
            }
        });

        return false;

    },

    loadTexts: function(object){
        url = __MD_CONTROLLER_SYMFONY_PLUGIN_TRANSLATOR_OBJECT + '/mdObjectTranslator/getTranslationsFormsAjax';

        $.ajax({
            url: url,
            data: {'app': $('#selected_app').attr('value'), 'catalogue': $('#selected_catalogue').attr('value'), 'lang': $('#selected_lang').attr('value'), 'object': object, 'index': index, 'baselang': $('#base_lang').attr('value')},
            dataType: 'html',
            type: 'post',
            success: function(html){
                $('#datos').append(html);
            }
        });
    },

    createInput: function(text){
        var divPlace = $('#'+ $('#application').attr('value') + '_pages');
        //indexPages - variable global
        var value = "<label for='cb"+indexPages+"' style='padding-right:3px;display:block;'><input name='checkbox[]' value='"+text+"' type='checkbox' id='cb"+indexPages+"' onclick='mdPluginTranslatorObjectDoctrine.getInstance().bringTexts(this);'>"+text+"</label>";
        divPlace.append(value);
        indexPages++;

//        var divPlace = $($('selected_app').value+'_object');
//        var value = \"<label for='cb\"+indexPages+\"' style='padding-right:3px;display:block;'><input name='checkbox[]' value='\"+text+\"' type='checkbox' id='cb\"+indexPages+\"' onclick='bringTexts(this);'>\"+text+\"</label>\";
//        divPlace.insert(value);
//        indexPages++;
    },

    createAppPagesDiv: function(){

        $('#app_pages').html('');
        var divPlace = $('#' + $('#application').attr('value') + '_pages');
        if(divPlace.length > 0){
            return false;
        }

        var div = "<div id='"+ $('#application').attr('value') + "_pages' class='chkListIn'></div>";
        $('#app_pages').append(div);
        return true;
    },

    checkByParent: function(aId) {
        var collection = document.getElementById(aId).getElementsByTagName('INPUT');
        for (var x=0; x<collection.length; x++) {
            if (collection[x].type.toUpperCase()=='CHECKBOX'){
                this.bringTexts(collection[x]);
            }

        }
    },

    reloadTexts: function(){
        $('#datos').html('');
        this.checkByParent('app_pages');
    },

    bringTexts: function(obj){
        this.highlight_div(obj);
        if(obj.checked){
            this.loadTexts(obj.value );
        }else{
            if($(obj.value) != null){
                $('#' + obj.value).remove();
            }
        }
    },

    highlight_div: function(checkbox_node){
        label_node = checkbox_node.parentNode;

        if (checkbox_node.checked){
            label_node.style.backgroundColor='#0a246a';
            label_node.style.color='#fff';
        }
        else {
            label_node.style.backgroundColor='#fff';
            label_node.style.color='#000';
        }
    },

    changePages: function(){
        var self = this;
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY_PLUGIN_TRANSLATOR_OBJECT + '/mdObjectTranslator/getApplicationObjectsAjax',
            type: 'post',
            data: {'app': $('#selected_app').attr('value'), 'lang': $('#selected_lang').attr('value')},
            dataType: 'json',
            success: function(json){
                self.createAppPagesDiv();
                for(var i=0;i<json.length;i++){
                    self.createInput(json[i].object);
                }
            }
        });

    },

    changeLenguage: function(){
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY_PLUGIN_TRANSLATOR_OBJECT + '/mdObjectTranslator/getLangsAjax',
            data:{'app': $('#application').attr('value')},
            type: 'post',
            dataType: 'json',
            success: function(json){
                var list=$('#language');

                for(var count = list.options.length - 1; count >= 0; count--){
                    list.options[count] = null;
                }

                for(var i=0;i<json.length;i++){
                    var opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    list.options.add(opt);

                }

                var listBase=$('#base_language');
                for(var count = listBase.options.length - 1; count >= 0; count--){
                    listBase.options[count] = null;
                }

                var opt=document.createElement('option');
                opt.text='';
                opt.value='';
                listBase.options.add(opt);
                for(var i=0;i<json.length;i++){
                    var opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    listBase.options.add(opt);
                }
            }
        });

    },

    changeApp: function(){
        var self = this;
        $('#selected_app').change(function(){
            self.changeLenguage();
            self.changePages();
        });
    },

    changeLenguages: function(){
        var self = this;

        $('#base_lang').change(function(){
            self.reloadTexts();
        });

        $('#selected_lang').change(function(){
            self.reloadTexts();
        });
    },

    publish: function(){
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY_PLUGIN_TRANSLATOR_OBJECT + '/mdObjectTranslator/clearCache',
            type: 'post',
            dataType: 'json',
            success: function(json){
                $('#show_publish').hide();

            }
        });

        return false;
    }

}