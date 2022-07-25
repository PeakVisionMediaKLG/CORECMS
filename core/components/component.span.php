<?php
namespace CORE;
class SPAN extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$CODE = "<span".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</span>".PHP_EOL;
			return $CODE;
		}	
}
?>