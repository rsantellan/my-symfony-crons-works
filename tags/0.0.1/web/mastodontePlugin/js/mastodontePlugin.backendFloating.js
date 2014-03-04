jType.registerNamespace('mastodontePlugin.UI');

mastodontePlugin.UI.BackendFloating = function(options){
	this._initialize();
    
}

mastodontePlugin.UI.BackendFloating.instance = null;

mastodontePlugin.UI.BackendFloating.getInstance = function (){
	if(mastodontePlugin.UI.BackendFloating.instance == null)
		mastodontePlugin.UI.BackendFloating.instance = new mastodontePlugin.UI.BackendFloating();
	return mastodontePlugin.UI.BackendFloating.instance;
}

mastodontePlugin.UI.BackendFloating.prototype = {
	_initialize : function(){
      this.container = "backend_right_floating";
      this.container_id = "#backend_right_floating";
      this.top_margin = $('#backend_right_filter').offset().top + $('#backend_right_filter').height() + 1;
      this.left_margin = $('#backend_right_filter').offset().left;
      this.accordions_height = $(".md_content_center").offset().top + $(".md_content_center").height() + 1;
  },
  
  init: function(){
    
  },
  
  move: function(position){
    var container_heigth = $(this.container_id).offset().top + $(this.container_id).height() + 1;
    if(container_heigth > this.accordions_height)
    {
      return false;
    }
    if (position >= this.top_margin) {
      // if so, ad the fixed class
      $(this.container_id).addClass('fixed');
      $(this.container_id).css("left",this.left_margin);
    } else {
      // otherwise remove it
      $(this.container_id).removeClass('fixed');
    }
  },
  
  add: function(html){
    $(this.container_id).html("");
    $(this.container_id).append(html);
  },
  
  remove: function(id){
    if($(id).length > 0)
    {
      $(id).remove("slow");
    }
    else
    {
      $(this.container_id).html("");
    }
  }
  
  
}
