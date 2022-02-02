<?php
//prints out a html/bootstrap table row

class THEAD extends BE_COMPONENT
	{
	static function PRECODE ($params=NULL,$data=NULL)
		{
			/* Params: id, class, label */
			$CODE = "<thead ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'class').">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</thead>";
			return $CODE;
		}
	}
?>