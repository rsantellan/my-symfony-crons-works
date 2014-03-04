var MdObjectKeys = {
    OPEN: "open",
    CLOSE: "close",
    OPENING: "opening",
    CLOSING: "closing"

}

var MdObjectList = Class.create({
    initialize: function(options) {
        this.selectedObj = null;

        this.options = Object.extend({
            objectsBox: new Array()
        }, options || {});
    },

    setObjectsBox: function(objectBox){
        this.options.objectsBox.push(objectBox);
    },

    openObject: function(id, elClicked, event){
        var extra_data = (arguments[3] !== undefined)? arguments[3] : null;
        Event.stop(event);
        var self = this;
        //recorro los objectsBox y el que tenia open lo cierro.
        this.options.objectsBox.each(function(objectBox, index){
            if(objectBox.getStatus() == MdObjectKeys.OPEN){
                objectBox.loadClosedContent($('md_closeobjectbox_'+objectBox.getId()), extra_data + objectBox.getId());
            }

            if(objectBox.getId() == id){
                self.selectedObj = objectBox;
            }
        });

        this.selectedObj.loadOpenContent(elClicked);

    },

    closeObject: function(id, elClicked, event){
        if(event !== null) Event.stop(event);

        this.options.objectsBox.each(function(objectBox, index){
            if(objectBox.getId() == id){
                objectBox.loadClosedContent(elClicked);

                return;
            }
        });
    },


    closeOpenObjects: function(){
        this.options.objectsBox.each(function(objectBox, index){
            if(objectBox.getStatus() == MdObjectKeys.OPEN){
                objectBox.loadClosedContent($('md_closeobjectbox_'+objectBox.getId()));
            }
        });
    },

    removeObjectBox: function(id) {
        var elClicked = (arguments[1] !== undefined)? arguments[1] : null;
        var self = this;
        this.options.objectsBox.each(function(objectBox, index){
            if(objectBox.getId() == id){
                self.options.objectsBox.splice(self.options.objectsBox.indexOf(objectBox), 1);
                if(elClicked !== null)
                {
                  objectBox.removeBox(elClicked);
                }
            }
        });
    },


    saveFormObject: function(id, elForm, event){
        try {
            elForm.getElements().each(function(item, index){
                if(item.id != '' && $(item.id).hasClassName('with-tiny')){
                    tinyMCE.execCommand("mceRemoveControl", true, item.id);
                    tinyMCE.execCommand("mceAddControl", true, item.id);
                }
            });

            tinyMCE.triggerSave();

            elForm.getElements().each(function(item, index){

                if(item.id != '' && $(item.id).hasClassName('with-tiny')){
                    tinyMCE.execCommand("mceRemoveControl", true, item.id);
                }
            });

            
        } catch (e) {
            //alert('error ' + e.name + ' ' + e.message);
        }

        

        Event.stop(event);

        this.options.objectsBox.each(function(objectBox, index){
            if(objectBox.getId() == id){
                objectBox.saveFormContent(elForm);

                return;
            }
        });
    }
});

var MdObjectBox = Class.create({
  initialize: function(options) {
      this.options = Object.extend({
        id                       : null,
        element                  : null,
        status                   : MdObjectKeys.CLOSE,
        elClass                  : null,
        open                     : null,
        loading                  : false,
        url                      : null
      }, options || {});

  },

  getId: function(){
      return this.options.id;
  },

  getStatus: function(){
      return this.options.status;
  },

  setStatus: function(status) {
    this.options.status = status;
  },

  setUrl: function(url){
    this.options.url = url;
  },

  loadClosedContent: function(elClicked){
    var extra = (arguments[1] !== null)? arguments[1] : null;

    try {
        if($(extra) != null || $(extra) !== undefined){
            //console.log($(extra));
            $(extra).getElements().each(function(item, index){

                if(item.id != ''){
                    tinyMCE.execCommand("mceRemoveControl", true, item.id);
                }
            });
        }
    } catch (exception) {
        //alert(exception);
    }
    
    var self = this;
    this.options.url = elClicked.href;

    var params = this.options.url.match(/\?.*([a-z]*)/)[0].replace(/\?/, '');

    var myAjax = new Ajax.Request(self.options.url, {
        method: 'post',
        parameters: params,
        onLoading: function(){
            if(self.onLoadingClosedContent !== null){
                self.onLoadingClosedContent();
            }


          self.options.status = MdObjectKeys.CLOSING;
        },

        onFailure: function(){
            self.options.status = MdObjectKeys.OPEN;
        },

        onSuccess: function (response){
            if(self.afterLoadOpenContent !== null){
                self.afterLoadClosedContent(response);
            }

            self.options.status = MdObjectKeys.CLOSE;
        }
    });
  },

  loadOpenContent: function(elClicked){
    var self = this;
    this.options.url = elClicked.href;
    var params = this.options.url.match(/\?.*([a-z]*)/)[0].replace(/\?/, '');

    var myAjax = new Ajax.Request(self.options.url, {
        method: 'post',
        parameters: params,
        onLoading: function(){
            $('loading_close_' + self.options.id).style.display = "block";
            self.options.status = MdObjectKeys.OPENING;
        },

        onFailure: function(){
            $('loading_close_' + self.options.id).style.display = "none";
            self.options.status = MdObjectKeys.CLOSE;
        },
        onSuccess: function (response){

            if(self.afterLoadOpenContent !== null){
                self.afterLoadOpenContent(response);
            }
            self.options.status = MdObjectKeys.OPEN;
            $('loading_close_' + self.options.id).style.display = "none";
            

        }
    });
  },

  afterLoadClosedContent: null,

  afterLoadOpenContent: null,

  onLoadingClosedContent: null,

  saveFormContent: function(elForm){
    var self = this;
    elForm.request({
        onSuccess: function(response) {
            if(self.afterFormSaveContent !== null){
                self.afterFormSaveContent(response);
            }
        }
    });
  },

  afterFormSaveContent: null,

  removeBox: function(elClicked){
        var self = this;
        
        var ajaxUrl = elClicked.href;
        var params = ajaxUrl.match(/\?.*([a-z]*)/)[0].replace(/\?/, '');

        var myAjax = new Ajax.Request(ajaxUrl, {
            method: 'post',
            parameters: params,
            onLoading: function(){
            },

            onFailure: function(){
                return false;
            },
            onSuccess: function (response){
                var json = response.responseText.evalJSON();
                if(json.response == "OK"){
                    $('md_object_'+self.options.id).remove();
                }

                if(self.afterRemoveObject != null){
                    self.afterRemoveObject(response);
                }

                return false;
            }
        });
        return false;
    },

    afterRemoveObject: null

});

mdObjectList = new MdObjectList();

