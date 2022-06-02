<?php
//prints out a html unordered list

namespace CORE;
class UL extends COMPONENT
	{
	static function PRECODE ($attributes=NULL,$parameters=NULL)
		{
			/* Params: id, class */
			$CODE = "<ul".(new self)->WRITE_ATTRIBUTES($attributes).">";
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "</ul>";
			return $CODE;
		}
	}
?>