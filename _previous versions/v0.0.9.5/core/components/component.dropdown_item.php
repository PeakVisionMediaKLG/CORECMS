<?php
// prints out a bootstrap dropdown item, works in conjuction with the btn_dropdown element

class DROPDOWN_ITEM extends CORE\COMPONENT
{		//class, href
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<li><a class='dropdown-item ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'href')." ".(new self)->WRITE_DATA($data).">".(new self)->WRITE_S($params,'caption')."</a></li>
				";
			return $CODE;
		}
}

?>