<?php
//writes the HTML code for a hidden input

class HIDDEN extends CORE\COMPONENT
	{	//type, id, name, value
	
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			//print_r($params);
            $CODE = "	    <input type='hidden' ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'value').">";

			return $CODE;
		}
	}
?>