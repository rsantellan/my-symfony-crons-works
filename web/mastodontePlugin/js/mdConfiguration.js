mdConfiguration = function(options){
	this._initialize();

}

mdConfiguration.instance = null;
mdConfiguration.getInstance = function (){
	if(mdConfiguration.instance == null)
		mdConfiguration.instance = new mdConfiguration();
	return mdConfiguration.instance;
}

mdConfiguration.prototype = {
    _initialize: function(){
        
    },

    saveMdXMLMail: function()
    {
      var form = '#xmlMailConfiguration';

      $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          type: 'post',
          dataType: 'json',
          success: function(json){
              if(json.result == "OK")
              {
                $('#md_mail_configuration_form_div').html(json.options.body);
                $('#md_mail_configuration_form_div').parent().effect("highlight", {}, 3000);
              }
              else
              {
                $('#md_mail_configuration_form_div').html(json.options.body);
              }
          }
      });

      return false;      

    },
    
    saveMdXMLAuth: function (name)
    {
      var form = '#xmlFormConfiguration_' + name;

      $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          type: 'post',
          dataType: 'json',
          success: function(json){
              var divId = "#md_auth_configuration_form_div_" + name;
              if(json.result == "OK")
              {
                $(divId).html(json.options.body);
              }
              else
              {
                $(divId).html(json.options.body);
              }
          }
      });

      return false;            
    },

    checkUsedCheckBoxesOfMdSales: function(reply_on, inform_buyer)
    {
        if(reply_on == '1')
        {
            $('#sale_manager_information_reply_on').attr("checked", "checked");
        }
        if(inform_buyer == '1')
        {
            $('#sale_manager_information_inform_buyer').attr("checked", "checked");
        }
    },

    saveMdXMLSales: function()
    {
        var form = '#xmlSaleConfiguration';

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK")
                {
                    $('#md_sale_configuration_form_div').html(json.options.body);
                    mdConfiguration.getInstance().checkUsedCheckBoxesOfMdSales(json.options.reply_to, json.options.inform_buyer);
                    $('#xmlSaleConfiguration').parent().effect("highlight", {}, 3000);
                }
                else
                {
                    $('#md_sale_configuration_form_div').html(json.options.body);
                }
            }
        });

      return false;
    }
};
