<div class="content">
    <div class="pure-g">
        <div class="l-box-lrg pure-u-1 pure-u-md-1-3"></div>
        <div class="l-box-lrg pure-u-1 pure-u-md-1-3">
            <form action='<?php echo url_for('@exportarDatosAlumnos');?>' method='POST' class='pure-form pure-form-inline'>
                <?php echo $form->renderHiddenFields();?>
                <?php echo $form->renderGlobalErrors() ?>
                <fieldset>
                    <legend>Exportacion de datos de alumnos</legend>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <?php echo $form['clase']->renderLabel() ?>
                            <?php echo $form['clase']->renderError() ?>
                            <?php echo $form['clase'] ?>
                        </div>
                        <div class="pure-u-1 pure-u-md-1-2">
                            <?php echo $form['horario']->renderLabel() ?>
                            <?php echo $form['horario']->renderError() ?>
                            <?php echo $form['horario'] ?>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            Elija los campos de los alumnos a mostrar:
                            <?php echo $form['alumnos']->renderError() ?>
                            <?php echo $form['alumnos'] ?>
                        </div>
                        <div class="pure-u-1 pure-u-md-1-2">
                            Elija los campos de los padres a mostrar:
                            <?php echo $form['padres']->renderError() ?>
                            <?php echo $form['padres'] ?>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            Descargar archivo csv
                            <?php echo $form['exportar']->renderError() ?>
                            <?php echo $form['exportar'] ?>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <input type='submit' value='Generar' class="pure-button"/>
                        </div>
                    </div>
                    <?php //echo $form ?>
                    
                </fieldset>
            </form>
        </div>
        <div class="l-box-lrg pure-u-1 pure-u-md-1-3"></div>
    </div>
</div>
<?php
if(count($headers) > 0):
?>
<div class="content">
    <div class="pure-g">
        <div class="l-box-lrg pure-u-1 pure-u-md-1">
            <table class='pure-table pure-table-bordered pure-table-striped'>
                <thead>
                    <tr>
                        <?php foreach($headers as $header): ?>
                        <th><?php echo $header;?></th>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $row): ?>
                        <tr>
                            <?php foreach($row as $value): ?>
                            <td><?php echo $value; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
endif;
?>
