<?php
//writes the HTML code for a bootstrap column

class COLUMN extends BE_COMPONENT
	{	//class, style
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<div class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style').">
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