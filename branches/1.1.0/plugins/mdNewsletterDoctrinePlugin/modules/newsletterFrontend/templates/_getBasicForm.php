<?php if(!isset($position)) $position= null;?>
<?php if(!isset($number)) $number = 0;?>
<?php use_helper('mdAsset') ?>
<?php use_plugin_javascript('mdNewsletterPlugin', 'jquery.infieldlabel.min.js');?>
<div class="news newsletter_component_container">
    <?php include_partial('newsletterFrontend/form', array('form'=>$form, 'position'=>$position, 'number' =>$number));?>
</div>

<script type="text/javascript">
        $(document).ready(function() {
            $("#mailNewsLetterLB_<?php echo $number;?>").inFieldLabels();
            if(typeof newsLetterStartCallback == 'function') {
                newsLetterStartCallback();
            }
        });

        function sendMdNewsLetter(number)
        {
            if(typeof sendNewsLetterBeforeCallback == 'function') {
                sendNewsLetterBeforeCallback();
            }
            $("#Submit_newsletter_"+number).hide();
            $("#loader_info_news_letter_"+number).show();
            var form = "#newsletter_form_"+number;
            $.ajax({
                url: $(form).attr('action'),
                data: $(form).serialize(),
                type: 'POST',
                dataType: 'json',
                success: function(json) {
                    if(json.response == 'OK'){
                        $("#newsletter_form_"+number).replaceWith(json.options.body);
                        $("#newsLetter_mail_"+number).val("");
                        $("#mailNewsLetterLB_"+number).inFieldLabels();
                        if(typeof sendNewsLetterOkCallback == 'function') {
                            sendNewsLetterOkCallback();
                        }
                    }else{
                        $("#newsletter_form_"+number).replaceWith(json.options.body);
                        $("#mailNewsLetterLB_"+number).inFieldLabels();
                        if(typeof sendNewsLetterErrorCallback == 'function') {
                            sendNewsLetterErrorCallback();
                        }
                    }
                },
                complete: function(){
                    $("#Submit_newsletter_"+number).show();
                    $("#loader_info_news_letter_"+number).hide();
                    if(typeof sendNewsLetterCompleteCallback == 'function') {
                        sendNewsLetterCompleteCallback();
                    }
                }
            });
            return false;
        }
</script>
