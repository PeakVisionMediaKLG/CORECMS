<?php
//prints out a html unordered list

class UL extends BE_COMPONENT
	{
	static function PRECODE ($params=NULL, $data=NULL)
		{
			/* Params: id, class */
			$CODE = "<ul ".(new self)->WRITE($params,'class').(new self)->WRITE($params,'id').(new self)->WRITE($params,'style').(new self)->WRITE_DATA($data).">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</ul>";
			return $CODE;
		}
	}
?>