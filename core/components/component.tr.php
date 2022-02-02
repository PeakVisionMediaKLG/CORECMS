<?php
//prints out a html/bootstrap table row

class TR extends CORE\COMPONENT
	{
	static function PRECODE ($params=NULL,$data=NULL)
		{
			/* Params: id, class, label */
			$CODE = "<tr ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'class').">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</tr>";
			return $CODE;
		}
	}
?>