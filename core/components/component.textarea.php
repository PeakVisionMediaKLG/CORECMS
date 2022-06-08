<?php
namespace CORE;
class TEXTAREA extends COMPONENT
	{		
		static function PRINTCODE($attributes=NULL)
		{
			$id = $attributes['id'] ?? NULL;

			$label = $attributes['label'] ?? NULL;
			$outer_class = $attributes['outer-class'] ?? NULL;
			$validity = $attributes['validity'] ?? NULL;
			$feedback = $attributes['feedback'] ?? NULL;
			$value = $attributes['value'] ?? NULL;

			$attributes = (new self)::REMOVE($attributes, array('outer-class','validity','feedback','label','value'));

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
			
						$CODE = '<div class="form-floating '.$outer_class.'">
									<textarea '.(new self)->WRITE_ATTRIBUTES($attributes).'>'.$value.'</textarea>
									<label for='.$id.'>'.$label.$feedback.'</label>
								</div>'.PHP_EOL;

						/*$CODE = "
							<div class='".(new self)->WRITE_S($params,'class')."'>
								<label for='".(new self)->WRITE_S($params,'name')."' class='form-label'>".(new self)->WRITE_S($params,'label')."</label>
								<textarea class='form-control ".(new self)->WRITE_S($params,'inputclass')." $inputclass' ".(new self)->WRITE($params,'type')." ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'autocomplete')." ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'rows')." class='form-control' aria-describedby='Help_".(new self)->WRITE_S($params,'name')."' ".(new self)->WRITE_S($params,'required')." ".(new self)->WRITE_DATA($data).">".(new self)->WRITE_S($params,'value')."</textarea>
								$feedback
								<div id='Help_".(new self)->WRITE_S($params,'name')."' class='form-text'>".(new self)->WRITE_S($params,'helptxt')."</div>
							</div>
						";*/
			return $CODE;
		}
	}
?>