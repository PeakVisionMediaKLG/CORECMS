<?php
//prints out a bootstrap button with dropdown funcionality

class BTN_DROPDOWN extends CORE\COMPONENT
{		//class, id, style, caption
		static function PRECODE($params=NULL,$data=NULL)
		{
			if(@$params['id']=="") $params['id']= time();
			
			$CODE = "<div class='dropdown'>
			  <button class='btn ".(new self)->WRITE_S($params,'class')." dropdown-toggle' type='button' id='".(new self)->WRITE_S($params,'id')."' data-bs-toggle='dropdown' aria-expanded='false' ".(new self)->WRITE($params,'style').">
				".(new self)->WRITE_S($params,'caption')."
			  </button>
			  <ul class='dropdown-menu' aria-labelledby='".(new self)->WRITE_S($params,'id')."'>
				";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</ul>
			</div>";
			return $CODE;
		}	
}
?>