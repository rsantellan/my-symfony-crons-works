<?php

/* Usage
 Grab some XML data, either from a file, URL, etc. however you want. Assume storage in $strYourXML;

 $objXML = new xml2Array();
 $arrOutput = $objXML->parse($strYourXML);
 print_r($arrOutput); //print it out, or do whatever!

*/
class mdXmlParser {

    public $arrOutput = array();

    public $resParser;
    
    public $strXmlData;

    public function  __construct() {

    }
    
    public function parse($strInputXML)
    {
        $this->resParser = xml_parser_create ();
        xml_set_object($this->resParser, $this);
        xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");

        xml_set_character_data_handler($this->resParser, "tagData");

        $this->strXmlData = xml_parse($this->resParser, $strInputXML );
        if(!$this->strXmlData)
        {
            throw new Exception(sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code($this->resParser)), xml_get_current_line_number($this->resParser)), 997);
        }

        xml_parser_free($this->resParser);

        return $this->arrOutput;
    }

    public function tagOpen($parser, $name, $attrs)
    {
       $tag = array("name" => $name, "attrs" => $attrs);
       array_push($this->arrOutput, $tag);
    }

    public function tagData($parser, $tagData)
    {
       if(trim($tagData)) {
            if(isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
                $this->arrOutput[count($this->arrOutput)-1]['tagData'] .= $tagData;
            }
            else {
                $this->arrOutput[count($this->arrOutput)-1]['tagData'] = $tagData;
            }
       }
    }

    public function tagClosed($parser, $name)
    {
       $this->arrOutput[count($this->arrOutput)-2]['children'][] = $this->arrOutput[count($this->arrOutput)-1];
       array_pop($this->arrOutput);
    }
}

/*
NOTE:
xml_parse() crashes when xml file contains chars \x00 - \x1f, so be careful! I solve this problem simple:
$bad_chr = array("\x00" => "chr(0)", "\x01" => "chr(1)", "\x02" => "chr(2)", "\x03" => "chr(3)", "\x04" => "chr(4)", "\x05" => "chr(5)", "\x06" => "chr(6)", "\x07" => "chr(7)", "\x08" => "chr(8)", "\x09" => "chr(9)", "\x0a" => "chr(10)", "\x0b" => "chr(11)", "\x0c" => "chr(12)", "\x0d" => "chr(13)", "\x0e" => "chr(14)", "\x0f" => "chr(15)", "\x10" => "chr(16)", "\x11" => "chr(17)", "\x12" => "chr(18)", "\x13" => "chr(19)", "\x14" => "chr(20)", "\x15" => "chr(21)", "\x16" => "chr(22)", "\x17" => "chr(23)", "\x18" => "chr(24)", "\x19" => "chr(25)", "\x1a" => "chr(26)", "\x1b" => "chr(27)", "\x1c" => "chr(28)", "\x1d" => "chr(29)", "\x1e" => "chr(30)", "\x1f" => "chr(31)");
xml_parse($xml_parser, strtr($data, $bad_chr), feof($fp));
//....
$parsed_data = strtr($parsed_data, array_flip($bad_chr));
*/