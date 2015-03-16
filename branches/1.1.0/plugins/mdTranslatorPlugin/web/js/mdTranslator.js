var index = 0;
var indexPages = 0;

var mdTranslator = function(options){
	

}

mdTranslator.instance = null;
mdTranslator.getInstance = function (){
	if(mdTranslator.instance == null)
		mdTranslator.instance = new mdTranslator();
	return mdTranslator.instance;
}

mdTranslator.prototype = {
    _initialize : function(){
      $('#search').live('keypress', 
                        function(e){
                          if(e.which == 13){
                            e.preventDefault();
                            mdTranslator.getInstance().changePages();
                          }
                        }
                      );  
      this.changeApp();
      this.changePages();
      this.changeLenguages();
    },

    updateTextArea: function(){
        try {
            if (tinyMCE.activeEditor != null) {
              tinyMCE.execCommand("mceRemoveControl", true, 'translation_new_1');
              tinyMCE.execCommand("mceAddControl", true, 'translation_new_1');

              tinyMCE.triggerSave();

              tinyMCE.execCommand("mceRemoveControl", true, 'translation_new_1');
            }
        } catch (e) {
           //alert(e);
        }
    },

    removeTinyTextArea: function(){
        try {
            if (tinyMCE.activeEditor != null) {
              tinyMCE.execCommand("mceRemoveControl", true, 'translation_new_1');
            }
            
        } catch (e) {
           //alert(e);
        }
    },

    save: function(source, translation,id, selected_catalogue){
        var url = __MD_CONTROLLER_SYMFONY + '/mdTranslator/changeTextAjax';
        var application = $('select:[name=application]').val();
        var lenguage = $('#language').val();
        mdShowLoading();        
        $.ajax({
            url: url,
            data: {lang: lenguage, catalogue: selected_catalogue, app: application, source: source, translation: translation},
            dataType: 'json',
            type: 'post',
            success: function(html){
                mdHideLoading();                
                if(html.response == "OK"){
                    place = '#result_'+id;
                    //$(place).show();
                    translator.updateHeader(html.options.message);
                    translator.close();
                    //$(place).fadeOut(3000);
                    $('#message_text').show();
                }
            }
        });
        return false;
    },

    loadTexts: function(page){
        url = __MD_CONTROLLER_SYMFONY + '/mdTranslator/getTranslationsFormsAjax';
        mdShowLoading();
        $.ajax({
            url: url,
            data: {'app': $('#application').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value'), 'page': page, 'index': index, 'baselang': $('#base_language').attr('value'), 'search': $('#search').val(), 'search_target': $('#search_target').is(':checked')},
            dataType: 'html',
            type: 'post',
            success: function(html){
                mdHideLoading();
                $('#datos').append(html);
            }
        });
    },

    createInput: function(text){
        var divPlace = $('#'+ $('#application').attr('value') + '_pages');
        //indexPages - variable global
        var value = "<label for='cb"+indexPages+"' style='padding-right:3px;display:block;'><input name='checkbox[]' value='"+text+"' type='checkbox' id='cb"+indexPages+"' onclick='translator.getTexts(this);'>"+text+"</label>";
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
                translator.getTexts(collection[x]);
                //this.bringTexts(collection[x]);
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
        mdShowLoading();
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdTranslator/getApplicationPagesAjax',
            type: 'post',
            data: {'app': $('#application').attr('value'), 'catalogue': $('#catalogue').attr('value'), 'lang': $('#language').attr('value'), 'search': $('#search').val(), 'search_target': $('#search_target').is(':checked')},
            dataType: 'json',
            success: function(json){
                mdHideLoading();                
                self.createAppPagesDiv();
                for(var i=0;i<json.length;i++){
                    self.createInput(json[i].page);
                }
            }
        });
        
    },

    changeLenguage: function(){
        mdShowLoading();
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdTranslator/getLangsAjax',
            data:{'app': $('#application').attr('value')},
            type: 'post',
            dataType: 'json',
            success: function(json){
                mdHideLoading();
                var list = $('#language > option')
                var count, opt, i;
                for(count = list.length - 1; count >= 0; count--){
                    list[count] = null;
                }

                for(i=0;i<json.length;i++){
                    opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    list.add(opt);
                }

                var listBase=$('#base_language > option');
                for(count = listBase.length - 1; count >= 0; count--){
                    listBase[count] = null;
                }

                opt=document.createElement('option');
                opt.text='';
                opt.value='';
                listBase.add(opt);
                for(i=0;i<json.length;i++){
                    opt=document.createElement('option');
                    opt.text=json[i].id;
                    opt.value=json[i].id;
                    listBase.add(opt);
                }
            }
        });

    },

    changeApp: function(){
        var self = this;

        $('#application').change(function(){
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
            //self.reloadTexts();
        });
    },

    publish: function(){
        mdTranslatorPublish.getInstance().publishing();
        
        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdTranslator/clearCache',
            type: 'post',
            dataType: 'json',
            success: function(json){
                mdTranslatorPublish.getInstance().publishComplete();
            }
        });

        return false;
    },

    sendNewWord: function()
    {
        var form = '#new_word_form';
        mdShowLoading();
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                mdHideLoading();
                if(json.response == "OK"){
                    $("#new_word_form_holder").html(json.options.body);

                }else {
                    $("#new_word_form_holder").html(json.options.body);
                }
            }
        });

        return false;

    },

		showReference: function(objLink)
		{
			objDiv = objLink.next();
			objLink.hide();
			objDiv.show();

			return false;
		}

}
