<?php
//writes the HTML code for a form

class FORM extends BE_COMPONENT
	{	//class,name,id,action,method
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<form ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'class')." ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'action')." ".(new self)->WRITE($params,'method').">
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</form>
			";
			return $CODE;
		}
    }
?>