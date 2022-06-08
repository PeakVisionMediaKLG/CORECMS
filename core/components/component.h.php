<?php
namespace CORE;
class H extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
			$heading = $attributes['heading'] ?? NULL;
			$size = $attributes['size'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('heading','size'));

			$CODE = "<h".$size." ".(new self)->WRITE_ATTRIBUTES($attributes).">".$heading."</h".$size.">".PHP_EOL;
			return $CODE;
		}

		static function PRECODE($attributes=NULL)
		{
			$heading = $attributes['heading'] ?? NULL;
			$size = $attributes['size'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('heading','size'));

			$CODE = "<h".$size." ".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
		static function POSTCODE($attributes=NULL)
		{
			$heading = $attributes['heading'] ?? NULL;
			$size = $attributes['size'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('heading','size'));

			$CODE = "</h".$size.">".PHP_EOL;
			return $CODE;
		}
	}

?>