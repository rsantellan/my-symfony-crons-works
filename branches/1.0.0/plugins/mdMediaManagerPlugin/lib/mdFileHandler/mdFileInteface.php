<?php
/**
 * Interface for all files to manage by the file gallery
 *
 * @author Rodrigo Santellan
 * @access public
 *
 */
interface mdFileInteface
{
  public function isValid();
  
  public function getPath();
  
  public function getFilename();
  
  public function getFilenameWithPath();
  
  public function getImage();
  
  public function getLastModification();
  
}
