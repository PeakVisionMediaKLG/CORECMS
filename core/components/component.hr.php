<?php
//prints out a html horizontal rule

namespace CORE;
class HR extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<hr".(new self)->WRITE_ATTRIBUTES($attributes).">
			";
			return $CODE;
		}
	}
?>