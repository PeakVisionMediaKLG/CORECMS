<?php
namespace CORE;
class IFRAME extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
			$CODE = "<iframe".(new self)->WRITE_ATTRIBUTES($attributes)."></iframe>".PHP_EOL;
			return $CODE;
		}
	}
?>