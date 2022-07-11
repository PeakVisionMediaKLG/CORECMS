<?php
namespace CORE;
class BTN_DROPDOWN extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$attributes = (new self)::FORCE($attributes, array('class'=>'btn'));
			$attributes = (new self)::FORCE($attributes, array('class'=>'dropdown-toggle'));
			$attributes = (new self)::FORCE($attributes, array('data-bs-toggle'=>'dropdown'));
			$attributes = (new self)::FORCE($attributes, array('aria-expanded'=>'false'));
			$attributes = (new self)::FORCE($attributes, array('type'=>'button'));

			$caption = $attributes['caption'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('caption'));

			$outer_class = $attributes['outer_class'] ?? "dropdown";

			$id = $attributes['id'] ?? 'dd_'.time();
			//$attributes = (new self)::REMOVE($attributes, array('id'));
			
			$CODE = "<div class='$outer_class'>
			  <button ".(new self)->WRITE_ATTRIBUTES($attributes).">".$caption.PHP_EOL.
			  "</button>
			  <ul class='dropdown-menu' aria-labelledby='".$id."'>";
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</ul>
			</div>".PHP_EOL;
			return $CODE;
		}	
}
?>