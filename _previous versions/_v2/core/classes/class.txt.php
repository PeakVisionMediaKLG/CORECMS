<?php
class TXT
{
	
public $CAPTIONS;
public $STATIC_CAPTIONS;
public $DYNAMIC_CAPTIONS;

public $DB;	
	
	function __construct($DB,$userLanguage="en")	
	{
			require_once(ROOT."core/txt/".$userLanguage.".php");
			$this->STATIC_CAPTIONS = $this->CAPTIONS;
			$this->DB=$DB;
			$this->get_captions = $this->DB->EASY_QUERY("SELECT",
                                                    'core_captions',
                                                    array('name','caption_'.$userLanguage),
                                                    array(),
                                                    array(),
                                                    array(),
                                                    'ORDER BY name ASC'); 
			//print_r($this->get_captions);
			$this->DYNAMIC_CAPTIONS = $this->DB->REMAP_UNIDIM_ARRAY($this->get_captions, "name",'caption_'.$userLanguage);
			array_merge($this->CAPTIONS, $this->DYNAMIC_CAPTIONS);

			//$this->SORT();
	}
	
	function DEBUG()
	{
		print_r($this->CAPTIONS);
		foreach($this->CAPTIONS as $key => $value){
			echo "'".$key."'	=>	'".$value."',"."\r\n"."<BR>";
		}
	}
	
	function SORT()
	{
		asort($this->STATIC_CAPTIONS);
		foreach($this->STATIC_CAPTIONS as $key => $value){
			echo "'".$key."'	=>	'".$value."',"."\r\n"."<BR>";
		}
	}
	
	function GET_VALUES()
	{
		return $this->CAPTIONS;
	}
	
}


?>