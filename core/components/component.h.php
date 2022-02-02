<?php
//displays a html heading

class H extends CORE\COMPONENT
	{	//class,type,heading

		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<h".(new self)->WRITE_S($params,'type')." class='".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'id')."  ".(new self)->WRITE($params,'value')." ".(new self)->WRITE($params,'style').">".(new self)->WRITE_S($params,'heading')."</h".(new self)->WRITE_S($params,'type').">
			";
			return $CODE;
		}
	}

?>