<?php

/**
 * Stores all the required/useful information of a given file in an array
 * and provides accessor methods to that data.
 *
 * @author Rodrigo Santellan
 * @access public
 *
 */
class mdConcreteFile implements mdFileInteface
{
  /**
   * Used to store and retrieve all the file info.
   *
   * @var array stores all the image info
   * @access private
   */
  private $fileInfo      = array();
  
  /**
   * Constructor.  Uses getimagesize() output as initial data.
   *
   * @param string $image full path of an image
   * @return void
   * @access public
   */
  public function  __construct($path, $filename) {
      //$size                             = getimagesize($image);
      $stat                             = stat($path.$filename);
      $this->fileInfo['last_modification'] = $stat['mtime'];
      $this->fileInfo['route']         = $path;
      $this->fileInfo['original_name'] = $filename;
      $this->fileInfo['type'] = mdBasicFunction::get_file_extension($filename);
  }  

  /**
   * Returns the last modification of file
   * @return <Unix timestamp>
   */
  public function getLastModification(){
      return $this->fileInfo['last_modification'];
  }
        
  public function getFiletype()
  {
    return $this->fileInfo['type'];
  }
  public function isValid()
  {
    
  }
  
  public function getPath()
  {
  
  }
  
  public function getFilename()
  {
  
  }
  
  public function getFilenameWithPath()
  {
    return $this->fileInfo['route'].$this->fileInfo['original_name'];
  }
  
  public function getImage()
  {
    if($this->getFiletype() == 'pdf'){
        return '/../mdMediaManagerPlugin/images/adobe_acrobat_pdf_icon.jpg';
    }
    if($this->getFiletype() == 'doc' || $this->getFiletype() == 'docx'){
        return '/../mdMediaManagerPlugin/images/office_word_icon.png';
    }
    if($this->getFiletype() == 'xls' || $this->getFiletype() == 'xlsx'){
        return '/../mdMediaManagerPlugin/images/office_excel_icon.png';
    }
    if($this->getFiletype() == 'ppt' || $this->getFiletype() == 'pptx'){
        return '/../mdMediaManagerPlugin/images/office_powerpoint_icon.png';
    }  
  }
      
}
