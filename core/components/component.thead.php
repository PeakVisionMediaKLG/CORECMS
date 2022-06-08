<?php
namespace CORE;
class THEAD extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$CODE = "<thead".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</thead>".PHP_EOL;
			return $CODE;
		}
	}
?>