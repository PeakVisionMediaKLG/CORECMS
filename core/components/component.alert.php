<?php
//writes the HTML code for a bootstrap a (link)

class ALERT extends CORE\COMPONENT
{		//class,href,style, role
		static function PRECODE($params=NULL,$data=NULL)
		{
			if(isset($params['dismissable'])) $dismissable="alert-dismissible"; else $dismissable="";
			$CODE = "<div class='alert $dismissable fade show ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style')." ".(new self)->WRITE_DATA($data)." role='alert'>
			".(new self)->WRITE_S($params,'caption')."
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE="";
			if(isset($params['dismissable'])) $CODE = "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
			$CODE .= "</div>
			";
			return $CODE;
		}	
}
?>
