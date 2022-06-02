<?php
//prints out a bootstrap button element

namespace CORE;
class BTN extends COMPONENT
{		
		static function PRECODE($attributes=NULL,$parameters=NULL)
		{
			
			$CODE = "<button".(new self)->WRITE_ATTRIBUTES($attributes).">
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</button>
			";
			return $CODE;
		}	
}

?>