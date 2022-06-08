<?php
//writes the HTML code for a bootstrap icon font

class BI extends CORE\COMPONENT
{
	static function GET($params=NULL,$data=NULL)
	{	//icon,size,color,style
		return '<i class="bi-'.(new self)->WRITE_S($params,'icon').'" style="'.(new self)->WRITE_S($params,'style').';"></i>';
	}
}
?>
