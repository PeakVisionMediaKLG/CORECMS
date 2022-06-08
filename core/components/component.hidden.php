<?php
namespace CORE;
class HIDDEN extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
            $CODE = "<input type='hidden' ".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	}
?>