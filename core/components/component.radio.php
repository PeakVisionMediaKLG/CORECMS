<?php
namespace CORE;
class RADIO extends COMPONENT
	{	
		static function PRINTCODE($attributes=NULL)
		{	
			$divclass = $attributes['divclass'] ?? NULL;
			$attributes['id'] = $attributes['id'] ?? "id_".str_replace(" ","",microtime());

			$caption = $attributes['caption'] ?? NULL;

			$attributes = (new self)::REMOVE($attributes, array('caption','divclass','title','title-class'));
			$attributes = (new self)::FORCE($attributes, array('class'=>'form-check-input'));
			
			if(@$attributes['value']==1) $checked=" checked"; else $checked="";

			$CODE = "<div class='form-check ".$divclass."'> 
						<input type='radio'".(new self)->WRITE_ATTRIBUTES($attributes)."$checked>";

						if($caption)
						{
							$CODE .= "<label class='form-check-label' for='".$attributes['id']."'>".$caption."</label>";
						}
			$CODE .= "</div>".PHP_EOL;

			return $CODE;
		}
	}
?>