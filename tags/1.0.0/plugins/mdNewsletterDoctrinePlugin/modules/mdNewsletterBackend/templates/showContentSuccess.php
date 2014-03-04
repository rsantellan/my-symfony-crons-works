<?php

include_partial('mdNewsletterBackend/mailing', array('body' => $mdNewsletterContent->getBody(), 'subject' => $mdNewsletterContent->getSubject()));
//get_partial("mdNewsletterBackend/mailing", array('body' => $data['body'], 'subject' => $data['subject']));
//echo html_entity_decode( $mdNewsletterContent->getBody());
?>
