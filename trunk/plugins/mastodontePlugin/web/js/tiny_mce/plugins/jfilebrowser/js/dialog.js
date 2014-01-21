tinyMCEPopup.requireLangPack();

var jFileBrowserDialog = {
	init : function() {
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		//f.somearg.value = tinyMCEPopup.getWindowArg('some_custom_arg');
	},

	insert : function() {
		// Insert the contents from the input into the document
		var html,style,path,alt,title,ancho,alto,align,type,form,dir;
        form = document.forms['jfileImageForm'];
        type = form.type.value;
        dir = form.directorio.value;
        path = form.path.value;
		if(type == 1){
            title = form.title.value;
            alt = form.alt.value;
            ancho = form.ancho.value;
            alto = form.alto.value;
            for(i=0; i <form.align.length; i++){
                if(form.align[i].checked){
                  align = form.align[i].value;
                }
            }
            if(align == 'left'){
                style = 'style="float: left;"';
            }else if(align == 'center'){
                style = 'style="display: block; margin-left: auto; margin-right: auto;"';
            }else if(align == 'right'){
                style = 'style="float: right;"';
            }

            if(ancho != '' || alto != ''){
                if(isNaN(parseInt(alto)) || isNaN(parseInt(ancho))){
                    alert('Los valores para el alto y el ancho deben ser enteros');
                    return;
                }

                new Ajax.Request('/backend.php/jfilebrowser/getUrl', {
                    method: 'post',
                    parameters: 'width=' + ancho + '&height=' + alto + '&directory=' + dir + '&name=' + title,
                    onSuccess: function (response){
                        path = response.responseText;
                        html = '<img src="' + path +'" title="' + title +'" alt="' + alt +'" ' + style + ' height="' + alto +'" width="' + ancho +'" />';
                        tinyMCEPopup.editor.execCommand('mceInsertContent', false, html);
                        tinyMCEPopup.close();
                    }
                });

            }else{
                path = path.replace("/backend.php", "").replace("/backend_dev.php", "");
                //html = '<span class="mceIcon mce_spellchecker"></span>';
                html = '<img src="' + path +'" title="' + title +'" alt="' + alt +'" ' + style + ' />';
                tinyMCEPopup.editor.execCommand('mceInsertContent', false, html);
                tinyMCEPopup.close();
            }

		}
		else {
			html = '<a href="' + path +'" title="' + title +'" >' + alt +'</a>';
            tinyMCEPopup.editor.execCommand('mceInsertContent', false, html);
            tinyMCEPopup.close();
		}
	},
	
	confirmar : function(m, d) {
		tinyMCEPopup.confirm(m, function(s) {
			if(s){
                borrar(document.forms['form_' + d]);
			}else {
				return false;
			}
		});
	}
};

tinyMCEPopup.onInit.add(jFileBrowserDialog.init, jFileBrowserDialog);
