<?php
	use_helper('JavascriptBase');
	
include_partial('mdUserManagementFrontend/minimunUserRegisterForm', array('form' => $form));

echo javascript_tag('

        $(document).ready(function() {
			$("#register_form").submit(function() {
			  $.ajax({
			      type: "POST",
			      url: $(this).attr("action"),
			      data: $(this).serialize(),
			      dataType: "json",
			      // Mostramos un mensaje con la respuesta de PHP
			      success: function(data) {
			      	if(data.result == 1){
			      		
			      	}
			      }
		      })        
		        return false;
			  return false;
			});
		});



');