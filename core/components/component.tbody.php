<?php
namespace CORE;
class TBODY extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$CODE = "<tbody".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</tbody>".PHP_EOL;
			return $CODE;
		}
	}
?>