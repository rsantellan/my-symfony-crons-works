var index = 0;
var indexPages = 0;

var mdPluginTranslator = function(options){


}

mdPluginTranslator.instance = null;
mdPluginTranslator.getInstance = function (){
	if(mdPluginTranslator.instance == null)
		mdPluginTranslator.instance = new mdPluginTranslator();
	return mdPluginTranslator.instance;
}

mdPluginTranslator.prototype = {
	_initialize : function(){
        this.changeApp();
		this.changePages();
		this.changeLenguages();
    },

    save: function(source, translation,id, selected_catalogue){
        var url = __MD_CONTROLLER_SYMFONY + '/mdPluginTranslator/changeTextAjax';
        var plugin = $('select:[name=plugin]').val();
        var lenguage = $('select:[name=language]').val();

        $.ajax({
            url: url,
            data: { lang: lenguage, catalogue: selected_catalogue, plugin: plugin, source: source, translation: translation },
            dataType: 'html',
            type: 'post',
            success: function(html){
                place = '#result_'+id;
                $(place).show();
                $(place).fadeOut(3000);
                $('#show_publish').show();
            }
        });
        return false;
    },

    loadTexts: function(page){
        url = __MD_CONTROLLER_SYMFONY + '/mdPluginTranslator/getTranslationsFormsAjax';

        $.ajax({
            url: url,
            data: { 'app': $('#application').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value'), 'page': page, 'index': index, 'baselang': $('#base_language').attr('value') },
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
        var value = "<label for='cb"+indexPages+"' style='padding-right:3px;display:block;'><input name='checkbox[]' value='"+text+"' type='checkbox' id='cb"+indexPages+"' onclick='mdPluginTranslator.getInstance().bringTexts(this);'>"+text+"</label>";
        divPlace.append(value);
        indexPages++;
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
            url: __MD_CONTROLLER_SYMFONY + '/mdPluginTranslator/getApplicationPagesAjax',
            type: 'post',
            data: { 'plugin': $('#plugin').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value') },
            dataType: 'json',
            success: function(json){
                self.createAppPagesDiv();
                for(var i=0;i<json.length;i++){
                    self.createInput(json[i].page);
                }
            }
        });

    },

    changeLenguage: function(){
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdPluginTranslator/getLangsAjax',
            data:{ 'app': $('#application').attr('value') },
            type: 'post',
            dataType: 'json',
            success: function(json){
                var list=$('#language > option');
                var count, opt, i;
                for(count = list.length - 1; count >= 0; count--){
                    list[count] = null;
                }

                for(i=0;i<json.length;i++){
                    opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    list.options.add(opt);

                }

                var listBase=$('#base_language > option');
                for(count = listBase.length - 1; count >= 0; count--){
                    listBase[count] = null;
                }

                opt=document.createElement('option');
                opt.text='';
                opt.value='';
                listBase.options.add(opt);
                for(i=0;i<json.length;i++){
                    opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    listBase.options.add(opt);
                }
            }
        });

    },

    changeApp: function(){
        var self = this;

        $('#plugin').change(function(){
            self.changeLenguage();
            self.changePages();
        });
    },

    changeLenguages: function(){
        var self = this;

        $('#base_language').change(function(){
            self.reloadTexts();
        });

        $('#language').change(function(){
            self.reloadTexts();
        });
    },

    publish: function(){
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdPluginTranslator/clearCache',
            type: 'post',
            dataType: 'json',
            success: function(json){
                $('#show_publish').hide();

            }
        });

        return false;
    }

}