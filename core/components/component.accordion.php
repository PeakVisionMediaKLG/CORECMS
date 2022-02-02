<?php
//display a bootstrap accordion component

class ACCORDION extends CORE\COMPONENT
{		//class,id,style
		static function PRECODE($params=NULL,$data=NULL)
		{
			if(@$params['id']=="") $params['id']= time();
			
			$CODE = "<div class='accordion ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'style').">
				";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</div>
			";
			return $CODE;
		}		
}
?>