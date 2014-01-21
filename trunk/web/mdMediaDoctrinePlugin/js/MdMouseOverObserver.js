var MdMouseOverObserver = function(arrayObjectsToObserve, hideElementSelector){

	this._initialize(arrayObjectsToObserve, hideElementSelector);
};

MdMouseOverObserver.prototype = {
	_initialize : function (arrayObjectsToObserve, hideElementSelector){
        
		arrayObjectsToObserve.each(function(index, item){
            elRemove = $(item).parent().children(hideElementSelector);
             
            $(item).hover(function(eventObject){
                $(eventObject.currentTarget).parent().children(hideElementSelector).show();
            }, function(eventObject){
                $(eventObject.currentTarget).parent().children(hideElementSelector).hide();
            });

            elRemove.hover(function(eventObject){
               $(eventObject.currentTarget).show();
                document.body.style.cursor = 'pointer';
            }, function(eventObject){
                $(eventObject.currentTarget).hide();
                document.body.style.cursor = 'auto';
            });
        });
	}
}