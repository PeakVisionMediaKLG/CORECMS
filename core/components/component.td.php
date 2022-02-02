<?php
//prints out a html/bootstrap table column

class TD extends CORE\COMPONENT
	{
	static function PRECODE ($params=NULL,$data=NULL)
		{
			/* Params: class, label */
			$CODE = "<td ".(new self)->WRITE($params,'class')." ".(new self)->WRITE($params,'colspan').">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</td>";
			return $CODE;
		}
	}
?>