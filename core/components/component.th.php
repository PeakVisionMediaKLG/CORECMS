<?php
namespace CORE;
class TH extends COMPONENT
	{
	static function PRECODE ($attributes=NULL)
		{
			$scope = $attributes['scope'] ?? 'col' ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('scope'));

			$CODE = "<th scope='$scope' ".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
			return $CODE;
		}
	
	static function POSTCODE($attributes=NULL)
		{
			$CODE = "</th>".PHP_EOL;
			return $CODE;
		}
	}
?>