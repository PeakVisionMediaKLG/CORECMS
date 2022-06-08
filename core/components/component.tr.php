<?php
namespace CORE;
class TR extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$CODE = "<tr".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</tr>".PHP_EOL;
			return $CODE;
		}
	}
?>