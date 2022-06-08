<?php
namespace CORE;
class UL extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$CODE = "<ul".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</ul>".PHP_EOL;
			return $CODE;
		}
	}
?>