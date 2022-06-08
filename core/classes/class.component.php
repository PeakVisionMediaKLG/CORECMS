<?php 
namespace CORE;

class COMPONENT
{
	static function PRE($attributes=NULL)
	{
		$attributes = (new self)::REMOVE($attributes, array('liveValidation'));
		echo STATIC::PRECODE($attributes);
	}

	static function POST($attributes=NULL)
	{
		echo STATIC::POSTCODE($attributes);
	}	

	static function PRINT($attributes=NULL)
	{
		$attributes = (new self)::REMOVE($attributes, array('liveValidation'));
		echo STATIC::PRINTCODE($attributes);
	}	

	static function PRE_R($attributes=NULL)
	{
		$attributes = (new self)::REMOVE($attributes, array('liveValidation'));
		return STATIC::PRECODE($attributes);
	}

	static function POST_R($attributes=NULL)
	{
		return STATIC::POSTCODE($attributes);
	}	

	static function PRINT_R($attributes=NULL)
	{
		$attributes = (new self)::REMOVE($attributes, array('liveValidation'));
		return STATIC::PRINTCODE($attributes);
	}		


	static function FORCE($attributes,$forced_attribute)
	{
		foreach($forced_attribute as $key => $value)
		{
			if(isset($attributes[$key]))
			{
				$pos = strpos($attributes[$key], $value);

				if ($pos === false) 
				{
					$attributes[$key].= " ".$value;
				} 
				else 
				{
					$pos2 = strpos($attributes[$key], $value." ");
					if ($pos2 !== false) 
					{
						if($pos2!=0 and substr($attributes[$key],$pos-1,1)!=" ") $attributes[$key].= " ".$value;
					} 
				}
			}
			else $attributes[$key]=$value;
		}
		return $attributes;
	}

	static function REMOVE($attributes,$extracted_attribute)
	{
		if(is_array($extracted_attribute))
		{
			foreach($extracted_attribute as $value)
			{
				if(is_array($attributes))
				{
					if(array_key_exists($value, $attributes)) unset($attributes[$value]);
				}
			}
		}
		else
		{
			if(isset($attributes[$extracted_attribute])) unset($attributes[$extracted_attribute]);
		}

		//print_r($attributes);
		return $attributes;
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
							if($subkey !="")
							$attribute_string.=" ".$subkey.'="'.trim($subvalue).'"';
							else $attribute_string.=" ".trim($subvalue);
						}
					}
					else
					{
						if($key !="")
						$attribute_string.=" ".$key.'="'.trim($value).'"';
						else $attribute_string.=" ".trim($value);
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