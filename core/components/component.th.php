<?php
//prints out a html/bootstrap table header column

class TH extends CORE\COMPONENT
	{
	static function PRECODE ($params=NULL,$data=NULL)
		{
			/* Params: class, label */
			$scope = $params['scope'] ?? 'col';

			$CODE = "<th scope='$scope' ".(new self)->WRITE($params,'class').">";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</th>";
			return $CODE;
		}
	}
?>