function changeCountry()
{
    var city = (arguments[0] != undefined) ? arguments[0] : "";
    var code = $("#md_user_profile_country_code").val();
    $("#local_loading").show();
    $.ajax({
        url: __MD_CONTROLLER_FRONTEND_SYMFONY + '/default/cities',
        data: {'CountryCode': code },
        type: 'post',
        dataType: 'json',
        success: function(json){
            $("#md_user_profile_city").replaceWith($.trim(json.options.content));
            if(city !== "")
            {
                $("#md_user_profile_city option[value='"+city+"']").attr('selected', 'selected');
            }
        },
        complete: function(){
            $("#local_loading").hide();
        }
    });
}
