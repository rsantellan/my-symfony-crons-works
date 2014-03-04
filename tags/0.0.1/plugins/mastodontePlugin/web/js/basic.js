function IsNumeric(sText)

{
    var ValidChars = "0123456789.,";
    var IsNumber=true;
    var Char;


    for (i = 0; i < sText.length && IsNumber == true; i++)
    {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char) == -1)
        {
            IsNumber = false;
        }
    }
    return IsNumber;

}

function IsNumericRound(sText)

{
    var ValidChars = "0123456789";
    var IsNumber=true;
    var Char;


    for (i = 0; i < sText.length && IsNumber == true; i++)
    {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char) == -1)
        {
            IsNumber = false;
        }
    }
    return IsNumber;

}

function highlight_div(checkbox_node)
{
    label_node = checkbox_node.parentNode;

    if (checkbox_node.checked)
    {
        label_node.style.backgroundColor='#0a246a';
        label_node.style.color='#fff';
    }
    else
    {
        label_node.style.backgroundColor='#fff';
        label_node.style.color='#000';
    }
}

function getSelectedRadio(formName,radioName){

    var radioGrp = document['forms'][formName][radioName];
    var radioValue = null;
    if(!radioGrp.length){
        return radioGrp.value;
    }
    for(i=0; i < radioGrp.length; i++){
        if (radioGrp[i].checked == true) {
            var radioValue = radioGrp[i].value;
        }
    }
    return radioValue;
}

function preloadImages(imagenes){
    var i;
    var lista_imagenes = new Array();
    for(i = 0; i<imagenes.length;i++){
        lista_imagenes[i] = new Image();
        lista_imagenes[i].src = imagenes[i];
    }
}

function validateEmail(email){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   //var address = document.forms[form_id].elements[email].value;
   if(reg.test(email) == false) {
      return false;
   }
   return true;
}
