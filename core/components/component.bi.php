<?php
//writes the HTML code for a bootstrap icon font

namespace CORE;
class BI extends COMPONENT
{
	static function GET($attributes=NULL)
	{	
		$icon = $attributes['icon'] ?? NULL;
		$attributes = (new self)::REMOVE($attributes, array('icon'));

		return '<i class="bi bi-'.$icon.'" '.(new self)->WRITE_ATTRIBUTES($attributes)."></i>".PHP_EOL;
	}
}
?>
