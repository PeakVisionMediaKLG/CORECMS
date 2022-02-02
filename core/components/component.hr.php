<?php
//prints out a html horizontal rule

class HR extends CORE\COMPONENT
	{	//class, style
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<hr ".(new self)->WRITE($params,'class')." ".(new self)->WRITE($params,'style').">
			";
			return $CODE;
		}
	}
?>