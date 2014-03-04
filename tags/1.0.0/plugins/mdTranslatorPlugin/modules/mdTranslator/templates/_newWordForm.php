<form method="POST" action="<?php echo url_for('mdTranslator/addNewWord')?>" id="new_word_form">
<?php
echo $form->renderHiddenFields();
?>

<?php echo $form['application']->renderRow()?>
<br/>

<?php echo $form['page']->renderRow()?>
<br/>

<?php echo $form['tag']->renderRow()?>
<br/>
<input type="button" onclick="return mdTranslator.getInstance().sendNewWord()" value="enviar"/>
<br/>
<?php if(isset($exception)): ?>
    <?php echo $exception; ?>
<?php endif;?>
</form>