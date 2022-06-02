<?php 
namespace CORE;

class COMPONENT
{
	static function PRE($attributes=NULL,$parameters=NULL)
	{
		echo STATIC::PRECODE($attributes,$parameters);
	}

	static function POST($attributes=NULL,$parameters=NULL)
	{
		echo STATIC::POSTCODE($attributes,$parameters);
	}	

	static function PRINT($attributes=NULL,$parameters=NULL)
	{
		echo STATIC::PRINTCODE($attributes,$parameters);
	}	

	static function PRE_R($attributes=NULL,$parameters=NULL)
	{
		return STATIC::PRECODE($attributes,$parameters);
	}

	static function POST_R($attributes=NULL,$parameters=NULL)
	{
		return STATIC::POSTCODE($attributes,$parameters);
	}	

	static function PRINT_R($attributes=NULL,$parameters=NULL)
	{
		return STATIC::PRINTCODE($attributes,$parameters);
	}		

	function WRITE_ATTRIBUTES($attributes)
	{
		//print_r($attributes);
		
		if($attributes and count($attributes)>0){
			$attribute_string="";
			foreach($attributes as $key => $value)
				{
					if(is_array($value))
					{
						foreach($value as $subkey => $subvalue)
						{
							$attribute_string.=" ".$subkey.'="'.trim($subvalue).'" ';
						}
					}
					else
					{
						$attribute_string.=" ".$key.'="'.trim($value).'" ';
					}
				}
			return $attribute_string;
			}	
	}

	function WRITE($parameters,$selection)
	{	
		if(isset($parameters) and count($parameters)>0){
			foreach($parameters as $key => $value)
				{
					if($key == $selection)
					{
						return " ".$key.'="'.trim($value).'"';
					}
				}
			}
	}

	
	function WRITE_S($parameters,$selection)
	{	
		if(isset($parameters) and count($parameters)>0){
			foreach($parameters as $key => $value)
				{
					if($key == $selection)
					{
						return trim($value);
					}
				}
			}
	}
}

?>