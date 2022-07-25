<?php
namespace CORE;
class P extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$CODE = "<p".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</p>".PHP_EOL;
			return $CODE;
		}	
}
?>