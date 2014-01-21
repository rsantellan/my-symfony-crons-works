var mdRelationContent = function(options){
    this._initialize();
}

mdRelationContent.instance = null;
mdRelationContent.getInstance = function (){
	if(mdRelationContent.instance == null)
		mdRelationContent.instance = new mdRelationContent();
	return mdRelationContent.instance;
}

mdRelationContent.prototype = {
    _initialize : function(){
        this.modal = null;
    },

    sortData: function()
    {
        $( "#flex1 tbody" ).sortable({
           stop: function(event, ui) {
                var ids = new Array();
                var classNames = new Array();
                var priorities = new Array();
                var _priorities, _ids, _classNames;
                var _page  = $('span.pcontrol > input').val();
                var _limit = $(".pGroup > select").val();
                $( "#flex1 tbody tr" ).each(function(index, item){
                    var divs  = $(item).find('td > div');
                    ids[index] = $(divs[0]).text();
                    classNames[index] = $(divs[1]).text();
                    priorities[index] = (index+1);
                    _ids        = ids.join('|');
                    _classNames = classNames.join('|');
                    _priorities = priorities.join('|');
                });
                
                $.ajax({
                    url: __MD_CONTROLLER_SYMFONY + "/mdSortable/sortable",
                    dataType: 'json',
                    type: 'POST',
                    data: [{name: "_MD_Limit", value: _limit}, {name: "_MD_Page", value: _page}, {name : '_MD_Object_Ids', value: _ids}, {name: '_MD_Object_Class_Names', value: _classNames}, {name: '_MD_Priorities', value: _priorities}],
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
        });

	$( "#flex1 tbody" ).disableSelection();

    },

    addFormData: function()
    {
        var dt = $('#mdRelationContentForm').serializeArray();
        $("#flex1").flexOptions({params: dt});
        return true;
    },

    deleteRow: function(com, grid)
    {
        if($('.trSelected', grid).length > 0){
            if(confirm('Delete ' + $('.trSelected', grid).length + ' items?')){
                var items = $('.trSelected', grid);
                var ids = '';
                var classes = '';
                var cId = $('#_MD_Content_Id').attr('value');
                for(i = 0; i < items.length; i++){
                    ids+= $($(items[i]).children()[0]).text();
                    classes+= $($(items[i]).children()[1]).text();
                    if(i < (items.length - 1)){
                        ids+="-"; classes+= "-";
                    }
                }
                itemList = [{name : '_MD_Object_Id', value: ids }, {name: '_MD_Object_Class_Name', value: classes}, {name: '_MD_Content_Id', value: cId}];
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: __MD_CONTROLLER_SYMFONY + "/mdRelationContent/removeContent",
                    data: itemList,
                    success: function(response){
                        $("#flex1").flexReload();
                    }
                });
            }
        } else {
            return false;
        }
    },

    addRow: function(com, grid)
    {
        var objectId = $('#_MD_Object_Id').attr('value');
        var className = $('#_MD_Object_Class_Name').attr('value');
        var src = __MD_CONTROLLER_SYMFONY + "/mdRelationContent/newRelationContent/_MD_Object_Id/" + objectId + "/_MD_Object_Class_Name/" + className;

        $('#iframe-relation-content').attr('src', src);

        $( "#dialog-modal" ).dialog({
            width: 'auto',
            height: 'auto',
            maxHeight: 500,
            maxWidth: 700,
            minHeight: 300,
            minWidth: 300,
            modal: true,
            title: 'Aqui usted podra asociar nuevos contenidos'
        });
    },

    editRow: function(com, grid)
    {
        var contentIdOwner = $('#_MD_Content_Id').attr('value');

        if($('.trSelected', grid).length > 0){

            var items = $('.trSelected', grid);
            var objectId = '';
            var className = '';
            for(i = 0; i < 1; i++){
                objectId = $($(items[i]).children()[0]).text();
                className= $($(items[i]).children()[1]).text();
            }

            var src = __MD_CONTROLLER_SYMFONY + "/mdRelationContent/editRelationContent/_MD_Object_Id/" + objectId + "/_MD_Object_Class_Name/" + className + "/_MD_Content_Id/" + contentIdOwner;

            $('#iframe-relation-content').attr('src', src);

            $( "#dialog-modal" ).dialog({
                width: 'auto',
                height: 'auto',
                maxHeight: 500,
                maxWidth: 700,
                minHeight: 300,
                minWidth: 300,
                modal: true,
                title: 'Aqui usted podra asociar nuevos contenidos'
            });

        }else{
            alert("Debes seleccionar un contenido antes de poder editarlo")
        }
    }
}
//mastodontePlugin.UI.BackendBasic.getInstance().afterOpen