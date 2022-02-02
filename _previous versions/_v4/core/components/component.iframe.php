<?php
//prints out an iframe html element

class IFRAME extends BE_COMPONENT
	{	//class, style, src
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<iframe ".(new self)->WRITE($params,'name')." class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style')." ".(new self)->WRITE($params,'src')."></iframe>";
			return $CODE;
		}
	}
?>