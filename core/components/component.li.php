<?php
//writes the HTML code for a jquery UI multisortable list item

namespace CORE;
class LI extends COMPONENT
	{	
		static function PRECODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<li".(new self)->WRITE_ATTRIBUTES($attributes).">
			";
			return $CODE;
		}

		static function POSTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "</li>
			";
			return $CODE;
		}
    }
?>