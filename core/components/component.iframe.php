<?php
//prints out an iframe html element

namespace CORE;
class IFRAME extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<iframe".(new self)->WRITE_ATTRIBUTES($attributes)."></iframe>";
			return $CODE;
		}
	}
?>