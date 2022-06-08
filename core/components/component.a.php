<?php
namespace CORE;
class A extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$caption = $attributes['caption'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('caption'));

			$CODE = "<a".(new self)->WRITE_ATTRIBUTES($attributes).">".$caption.PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</a>".PHP_EOL;
			return $CODE;
		}	
}
?>