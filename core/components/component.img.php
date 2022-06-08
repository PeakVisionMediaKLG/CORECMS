<?php
namespace CORE;
class IMG extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
			$CODE = "<img".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
    }

?>