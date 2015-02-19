<div>
    <form action='' method='POST'>
        
        <?php echo $form ?>
        <!--
    <div class='seleccion_alumnos'>
        <h4>Seleccione que campos seleccionar del alumno</h4>
        <div class='form_container'>
            <label for='nombre'>Nombre</label>
            <input type='checkbox' name='nombre' value='nombre' />
        </div>
        <div class='form_container'>
            <label for='apellido'>Apellido</label>
            <input type='checkbox' name='apellido' value='apellido' />
        </div>
        <div class='form_container'>
            <label for='fecha_nacimiento'>Fecha Nacimiento</label>
            <input type='checkbox' name='fecha_nacimiento' value='fecha_nacimiento' />
        </div>
        <div class='form_container'>
            <label for='anio_ingreso'>Año de ingreso</label>
            <input type='checkbox' name='anio_ingreso' value='anio_ingreso' />
        </div>
        <div class='form_container'>
            <label for='sociedad'>Sociedad</label>
            <input type='checkbox' name='sociedad' value='sociedad' />
        </div>
        <div class='form_container'>
            <label for='referencia_bancaria'>Referencia</label>
            <input type='checkbox' name='referencia_bancaria' value='referencia_bancaria' />
        </div>
        <div class='form_container'>
            <label for='emergencia_medica'>Emergencia Medica</label>
            <input type='checkbox' name='emergencia_medica' value='emergencia_medica' />
        </div>
        <div class='form_container'>
            <label for='horario'>Horario</label>
            <input type='checkbox' name='horario' value='horario' />
        </div>
        <div class='form_container'>
            <label for='futuro_colegio'>Futuro Colegio</label>
            <input type='checkbox' name='futuro_colegio' value='futuro_colegio' />
        </div>
        <div class='form_container'>
            <label for='clase'>Clase</label>
            <input type='checkbox' name='clase' value='clase' />
        </div>
    </div>

    <div class='seleccion_padres'>
        <h4>Seleccione que campos seleccionar de los padres</h4>
        <div class='form_container'>
            <label for='pnombre'>Nombre</label>
            <input type='checkbox' name='pnombre' value='nombre' />
        </div>
        <div class='form_container'>
            <label for='pdireccion'>Dirección</label>
            <input type='checkbox' name='pdireccion' value='pdireccion' />
        </div>
        <div class='form_container'>
            <label for='ptelefono'>Teléfono</label>
            <input type='checkbox' name='ptelefono' value='ptelefono' />
        </div>
        <div class='form_container'>
            <label for='pcelular'>Celular</label>
            <input type='checkbox' name='pcelular' value='pcelular' />
        </div>
        <div class='form_container'>
            <label for='pmail'>Correo Electronico</label>
            <input type='checkbox' name='pmail' value='pmail' />
        </div>
    </div>
    
    <div>
        <h2>Seleccione el grupo</h2>
        <select name='group'>
            <option value=''>Todos</option>
            <option value='verde'>verde</option>
            <option value='amarillo'>amarillo</option>
            <option value='rojo'>rojo</option>
        </select>
        
        <h2>Seleccione el horario</h2>
        <select name='hours'>
            <option value=''>Todos</option>
            <option value='matutino'>matutino</option>
            <option value='vespertino'>vespertino</option>
            <option value='doble_horario'>doble horario</option>
        </select>
        <div class='form_container'>
            <label for='export'>Exportar a csv</label>
            <input type='checkbox' name='export' value='export' />
        </div>
    </div>
    -->
    <input type='submit' value='Generar' />
    </form>
</div>
<?php
if(count($headers) > 0):
?>
<div>
    <table>
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

<?php 
endif;
?>
