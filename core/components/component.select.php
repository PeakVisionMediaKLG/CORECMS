<?php
namespace CORE;
class SELECT extends COMPONENT
	{
	static function PRINTCODE ($attributes = NULL)
		{	
			$options = $attributes['options'] ?? NULL;
			$selected_option = $attributes['selected-option'] ?? NULL;
			$empty_option = $attributes['empty-option'] ?? NULL;

			$attributes = (new self)::REMOVE($attributes, array('options','selected-option','empty-option'));

			$attributes = (new self)::FORCE($attributes, array('class'=>'form-select'));
			
			$CODE = "<select".(new self)->WRITE_ATTRIBUTES($attributes).">";
			
			if($empty_option) $CODE .= "<option value=''></option>";

			 foreach($options as $key => $value)
				 {	if($value==$selected_option) $selected="selected"; else $selected="";
				 	$CODE .= "<option value='$value' $selected>$key</option>";
				 }
			$CODE .= "</select>".PHP_EOL;
			return $CODE;
		}

	}
?>