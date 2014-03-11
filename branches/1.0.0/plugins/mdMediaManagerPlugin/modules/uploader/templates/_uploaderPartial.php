<?php
die('no lo tendria que usar nadie...');
include_component('uploader', 'uploader', array(
                      'upload_url'        => url_for('uploader/uploadContent?'. ini_get('session.name') . '=' . session_id() . '&upload=mastodonte'),      //ruta al action que procesa la imagen y la sube
                      'file_types'        => '*.jpg;*.jpeg;*.gif;*.png',  //formatos soportados
                      'max_filesize'      => 'upload_max_filesize',       //peso en bites mÃ¡ximo para cada imagen
                      'file_upload_limit' => 0,                           //cantidad de archivos mÃ¡ximo que podemos subir
                      'file_queue_limit'  => 0,                           //
                      'progress_style'    => 'swfupload-progressFile',    //javascript que dibuja el contenedor de imagenes subidas y thumbnails
                      'post_params'       => '"h": 70,"w":70, "objId":'.$sf_user->getProfile()->getId().',"objClass":"'.$sf_user->getProfile()->getObjectClass().'"',            //altura y ancho que queremos mostrar el thumb de cada imagen
                      'upload_browse'     => '<div id="image-browse">Subir Imagenes</div>'  //diseÃ±o que mostramos el boton de subir, debe mantenerse el id default
                    ));
