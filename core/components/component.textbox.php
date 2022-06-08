<?php
namespace CORE;
class TEXTBOX extends COMPONENT
	{		
		static function PRINTCODE($attributes=NULL)
		{
			$id = $attributes['id'] ?? NULL;

			$label = $attributes['label'] ?? NULL;
			$outer_class = $attributes['outer-class'] ?? NULL;
			$validity = $attributes['validity'] ?? NULL;
			$feedback = $attributes['feedback'] ?? NULL;
			
			$attributes = (new self)::REMOVE($attributes, array('outer-class','validity','feedback','label'));			
			
			$attributes = (new self)::FORCE($attributes, array('class'=>'form-control'));

			if($validity)
			{
				if($validity=="is-valid")
				{
					$attributes = (new self)::FORCE($attributes, array('class'=>'is-valid'));
				}
				elseif($validity=="is-invalid")
				{
					$attributes = (new self)::FORCE($attributes, array('class'=>'is-invalid'));
				}
				$feedback=": ".$feedback;
			}
			else $feedback=NULL;

			$CODE= '<div class="form-floating '.$outer_class.'">
				<input'.(new self)->WRITE_ATTRIBUTES($attributes).'>
				<label for="'.$id.'">'.$label.$feedback.'</label>
			</div>'.PHP_EOL;
					
			return $CODE;
		}
	}
?>