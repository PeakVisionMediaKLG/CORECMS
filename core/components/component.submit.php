<?php
//writes the HTML code for a bootstrap submit button

class SUBMIT extends CORE\COMPONENT
	{	//class,name,id,action,method,tabindex
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			$CODE = "<input type='submit' ".(new self)->WRITE($params,'name')." class='btn ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'value').">
			";
			return $CODE;
		}
	}
?>