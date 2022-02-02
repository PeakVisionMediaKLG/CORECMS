<?php
//prints out a bootstrap button element

class BTN extends BE_COMPONENT
{		//class,href,style,disabled
		static function PRECODE($params=NULL,$data=NULL)
		{
			
			$CODE = "<button ".(new self)->WRITE_S($params,'type').(new self)->WRITE($params,'class').(new self)->WRITE($params,'href').(new self)->WRITE($params,'style').(new self)->WRITE_DATA($data)." ".(new self)->WRITE_S($params,'disabled').">
			".(new self)->WRITE_S($params,'caption')."
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