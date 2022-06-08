<?php
namespace CORE;
class BTN extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$caption = $attributes['caption'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('caption'));

			$CODE = "<button".(new self)->WRITE_ATTRIBUTES($attributes).">".$caption.PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</button>".PHP_EOL;
			return $CODE;
		}	
}
?>