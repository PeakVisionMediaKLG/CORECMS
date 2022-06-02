<?php
//writes the HTML code for a bootstrap column

namespace CORE;
class COLUMN extends COMPONENT
	{	
		static function PRECODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<div".(new self)->WRITE_ATTRIBUTES($attributes).">
			";
			return $CODE;
		}

		static function POSTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "</div>
			";
			return $CODE;
		}
    }
?>