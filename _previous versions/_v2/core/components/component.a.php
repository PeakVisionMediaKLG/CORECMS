<?php
//writes the HTML code for a bootstrap a (link)

class A extends BE_COMPONENT
{		//class,href,style, role
		static function PRECODE($params=NULL,$data=NULL)
		{
			
			$CODE = "<a class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'href')." ".(new self)->WRITE($params,'style')." ".(new self)->WRITE_DATA($data)." ".(new self)->WRITE($params,'role').">
			".(new self)->WRITE_S($params,'caption')."
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</a>
			";
			return $CODE;
		}	
}
?>