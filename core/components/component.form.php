<?php
namespace CORE;
class FORM extends COMPONENT
	{	
		static function PRECODE($attributes=NULL)
		{
			$CODE = "<form".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</form>".PHP_EOL;
			return $CODE;
		}
    }
?>