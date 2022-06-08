<?php
namespace CORE;
class TD extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$CODE = "<td".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</td>".PHP_EOL;
			return $CODE;
		}
	}
?>