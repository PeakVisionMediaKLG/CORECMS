<?php
//writes the HTML code for a bootstrap icon

class BI extends BE_COMPONENT
{
	static function GET($params=NULL,$data=NULL)
	{	//icon,size,color,style
		if(!isset($params['color'])) $params['color']="currentColor";
		return "<svg class='bi' width='".(new self)->WRITE_S($params,'size')."' height='".(new self)->WRITE_S($params,'size')."' fill='".(new self)->WRITE_S($params,'color')."' ".(new self)->WRITE($params,'style')."><use xlink:href='"."http://".$_SERVER['SERVER_NAME']."/core/assets/bootstrap-icons-1.5.0/bootstrap-icons.svg#".(new self)->WRITE_S($params,'icon')."'/></svg>";
	}
}
?>