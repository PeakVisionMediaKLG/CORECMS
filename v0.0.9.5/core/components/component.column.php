<?php
//writes the HTML code for a bootstrap column

class COLUMN extends CORE\COMPONENT
	{	//class, style
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<div class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style')." ".(new self)->WRITE($params,'id').">
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</div>
			";
			return $CODE;
		}
    }
?>