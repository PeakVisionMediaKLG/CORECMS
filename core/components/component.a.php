<?php
//writes the HTML code for a bootstrap <a> (link)

namespace CORE;
class A extends COMPONENT
{		
		static function PRECODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<a".(new self)->WRITE_ATTRIBUTES($attributes).">
			".(new self)->WRITE_S($parameters,'caption')."
			";
			return $CODE;
		}

		static function POSTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "</a>
			";
			return $CODE;
		}	
}
?>