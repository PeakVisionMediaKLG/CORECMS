<?php
namespace CORE;
class SUBMIT extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{
			$attributes = (new self)::FORCE($attributes, array('type'=>'submit'));
			$attributes = (new self)::FORCE($attributes, array('class'=>'btn'));

			$CODE = "<input".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	}
?>