<?php
//writes the HTML code for a bootstrap textbox

class TEXTAREA extends CORE\COMPONENT
	{	//helptxt,class,label,type,name,autocomplete,id,tabindex,value,disabled,required,valid-feedback,invalid-feedback
	
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			//print_r($params);
			if(@$params['valid-feedback']!="") 
			{
				$feedback="<div class='valid-feedback'>".(new self)->WRITE_S($params,'valid-feedback')."</div>"; $inputclass.=" is-valid"; 
			}
			else {$feedback=""; $inputclass="";}
			
			if(@$params['invalid-feedback']!="") 
			{
				$feedback="<div class='invalid-feedback'>".(new self)->WRITE_S($params,'invalid-feedback')."</div>"; $inputclass.=" is-invalid"; 
			}
			else {$feedback="";$inputclass="";}
			
						$CODE = "
							<div class='".(new self)->WRITE_S($params,'class')."'>
								<label for='".(new self)->WRITE_S($params,'name')."' class='form-label'>".(new self)->WRITE_S($params,'label')."</label>
								<textarea class='form-control ".(new self)->WRITE_S($params,'inputclass')." $inputclass' ".(new self)->WRITE($params,'type')." ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'autocomplete')." ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'rows')." class='form-control' aria-describedby='Help_".(new self)->WRITE_S($params,'name')."' ".(new self)->WRITE_S($params,'required')." ".(new self)->WRITE_DATA($data).">".(new self)->WRITE_S($params,'value')."</textarea>
								$feedback
								<div id='Help_".(new self)->WRITE_S($params,'name')."' class='form-text'>".(new self)->WRITE_S($params,'helptxt')."</div>
							</div>
						";
			return $CODE;
		}
	}
?>