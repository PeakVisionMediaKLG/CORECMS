<?php
//writes the HTML code for a bootstrap icon font

namespace CORE;
class BI extends COMPONENT
{
	static function GET($attributes=NULL,$parameters=NULL)
	{	
		return '<i class="bi-'.(new self)->WRITE_S($parameters,'icon').'" '.(new self)->WRITE_ATTRIBUTES($attributes)."></i>";
	}
}
?>
