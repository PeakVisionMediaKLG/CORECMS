<?php
//writes the HTML code for a jquery UI multisortable list item

class LI extends BE_COMPONENT
	{	//class, style
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<li class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style')."  ".(new self)->WRITE_DATA($data).">
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