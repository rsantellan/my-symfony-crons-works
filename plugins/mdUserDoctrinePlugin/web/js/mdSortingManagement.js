mdSortingManagement = function(options){
	this._initialize();

}

mdSortingManagement.instance = null;
mdSortingManagement.getInstance = function (){
	if(mdSortingManagement.instance == null)
		mdSortingManagement.instance = new mdSortingManagement();
	return mdSortingManagement.instance;
}

mdSortingManagement.prototype = {
    _initialize: function(){
        
    },
    
    retriveChilds: function(element, url, className)
    {
      AjaxLoader.getInstance().show();
      $("#objects_container").fadeOut(300, function() { 
          $(this).empty(); 
          $(this).show();
      });
      $(element).parent().next(".category_child_container").remove();
      if($(element).val() == 0)
      {
        $(element).parent().remove();
        AjaxLoader.getInstance().hide();
        return false;
      }
      /*
      $("#md_category_sons").find('option').remove().end()
      .append('<option value="0">-</option>');
      */
      
      $.ajax({
          url: url,
          data: {'mdCategoryId': $(element).val(), 'className': className  },
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.response == "OK")
              {
                //console.log($(element));
                //console.log(json.options.body);
                $(element).parent().after(json.options.body);
              }
              /*if(json.length>0)
              {
                //le cargo las opciones recibidas
                for(var i=0;i<json.length;i++){
                    var opt=document.createElement('option');
                    opt.text=json[i]['name'];
                    opt.value=json[i]['id'];
                    $("#md_category_sons").append(opt);
                }
              }*/
          },
          complete: function()
          {
            AjaxLoader.getInstance().hide();
          }
      });
      return false;      
    },
    
    retriveObjects: function(inputButton, url, className)
    {
      var newValue = 0;
      $(".category_child_container").each(function(index, item){
        var auxVal = $(item).find("select").val();
        if(auxVal != 0)
        {
          newValue = auxVal;
        }
      });
      if(newValue == 0) return false;
      AjaxLoader.getInstance().show();
      $.ajax({
          url: url,
          data: {'mdCategoryId': newValue, 'className': className },
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.response == "OK")
              {
                
                $("#objects_container").html(json.options.body);
                mdSortingManagement.getInstance().startAccordion();
              }
          },
          complete: function()
          {
            AjaxLoader.getInstance().hide();
          }
      });      
    }, 
    
    startAccordion: function()
    {
      $("#objects_container").accordion('destroy');
      $("#objects_container").accordion({
         header: 'div > div.accordion-header',
         collapsible: true,
         active: false,
         icons: false,
         autoHeight: false
        }).
        sortable({
         axis: "y",
         handle: "div.accordion-header",
         stop: function(event, ui) 
         {
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
              var is_category_related = $("#is_category_related").val();
              var md_category_id = 0;
              $(".category_child_container").each(function(index, item){
                var auxVal = $(item).find("select").val();
                if(auxVal != 0)
                {
                  md_category_id = auxVal;
                }
              });              
              $.ajax({
                  url: __MD_CONTROLLER_SYMFONY + "/mdSortable/sortable",
                  dataType: 'json',
                  type: 'POST',
                  data: [{name:'mdCategoryId', value: md_category_id },{name: "is_category_related", value : is_category_related},{name : '_MD_Object_Ids', value: _ids}, {name: '_MD_Object_Class_Names', value: _classNames}, {name: '_MD_Priorities', value: _priorities}],
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
    }    
}
