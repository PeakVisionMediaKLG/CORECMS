<?php
//writes the HTML code for a jquery UI multisortable list item

class LI_MS extends CORE\COMPONENT
	{	//class, style
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<li class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style').">
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</li>
			";
			return $CODE;
		}
    }
?>