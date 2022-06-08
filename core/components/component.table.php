<?php
namespace CORE;
class TABLE extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$attributes = (new self)::FORCE($attributes, array('class'=>'table'));

			$CODE = "<div class='table-responsive'><table".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</table></div>".PHP_EOL;
			return $CODE;
		}
	}
?>