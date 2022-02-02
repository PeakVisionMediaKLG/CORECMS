<?php
//prints out a html/bootstrap table row

class TBODY extends CORE\COMPONENT
	{
	static function PRECODE ($params=NULL,$data=NULL)
		{
			/* Params: id, class, label */
			$CODE = "<tbody ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'class')." ".(new self)->WRITE_DATA($data).">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</tbody>";
			return $CODE;
		}
	}
?>