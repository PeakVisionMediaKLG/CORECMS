<?php
namespace CORE;
class HR extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
			$CODE = "<hr".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	}
?>