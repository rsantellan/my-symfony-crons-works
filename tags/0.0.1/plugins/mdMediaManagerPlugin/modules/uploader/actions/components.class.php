<?php
class uploaderComponents extends sfComponents
{
    public function executeUploader(){

        $options['widget'] = array(
            'upload_url'            => $this->upload_url,
            'file_types'            => $this->file_types,
            'max_filesize'          => $this->upload_max_filesize,
            'post_params'           => $this->post_params,
            'progress_style'        => $this->progress_style,
            'file_upload_limit'     => $this->file_upload_limit,
            'file_queue_limit'      => $this->file_queue_limit,
            'upload_browse'         => $this->upload_browse,
            'debug'		    => false
        );
        $this->form     = new SWFUploadForm(array(),array(), $options);

    }
    
}
