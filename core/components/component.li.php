<?php
namespace CORE;
class LI extends COMPONENT
	{	
		static function PRECODE($attributes=NULL)
		{
			$CODE = "<li".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</li>".PHP_EOL;
			return $CODE;
		}
    }
?>