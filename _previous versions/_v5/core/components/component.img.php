<?php
//prints out a html image

class IMG extends BE_COMPONENT
	{	//src, class, style
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<img ".(new self)->WRITE($params,'src').(new self)->WRITE($params,'class').(new self)->WRITE($params,'style').(new self)->WRITE($params,'alt').">
			";
			return $CODE;
		}
    }

?>