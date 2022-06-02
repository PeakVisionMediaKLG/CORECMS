<?php
//displays a html heading

namespace CORE;
class H extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<h".(new self)->WRITE_S($parameters,'type').(new self)->WRITE_ATTRIBUTES($attributes).">".(new self)->WRITE_S($parameters,'heading')."</h".(new self)->WRITE_S($parameters,'type').">
			";
			return $CODE;
		}

		static function PRECODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "<h".(new self)->WRITE_S($parameters,'type').(new self)->WRITE_ATTRIBUTES($attributes).">";
			return $CODE;
		}
	
		static function POSTCODE($attributes=NULL,$parameters=NULL)
		{
			$CODE = "</h".(new self)->WRITE_S($parameters,'type').">
			";
			return $CODE;
		}
	}

?>