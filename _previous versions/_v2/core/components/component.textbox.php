<?php
//writes the HTML code for a bootstrap textbox

class TEXTBOX extends BE_COMPONENT
	{	//inline,helptxt,class,label,type,name,autocomplete,id,tabindex,value,disabled,required,valid-feedback,invalid-feedback
	
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
			
			if(@$params['inline']==1)
					{
						$CODE = "	
							<div class='row ".(new self)->WRITE_S($params,'class')."'>";
						if((new self)->WRITE_S($params,'label')!=""){
							  $CODE .= "<div class='col-4'>
								<label for='".(new self)->WRITE_S($params,'name')."' class='col-form-label'>".(new self)->WRITE_S($params,'label')."</label>
							  </div>";
								  }
							  $CODE .="
							  	<div class='col'>
								<input class='form-control ".(new self)->WRITE_S($params,'inputclass')."$inputclass' ".(new self)->WRITE($params,'type')." ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'autocomplete')." ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'value');
								if((new self)->WRITE_S($params,'label')!=""){
									$CODE .=" aria-describedby='HelpInline_".(new self)->WRITE_S($params,'name')."'";
								}
								$CODE .= " ".(new self)->WRITE_S($params,'disabled')." ".(new self)->WRITE_S($params,'required')." ".(new self)->WRITE($params,'autocomplete')." ".(new self)->WRITE_DATA($data).">
								$feedback
							  </div>";
							  if((new self)->WRITE_S($params,'label')!=""){
								$CODE .=	
							  "<div class='col-12'>
								<span id='HelpInline_".(new self)->WRITE_S($params,'name')."' class='form-text'>
									".(new self)->WRITE_S($params,'helptxt')."
								</span>
							  </div>
							  ";
							  }
							  $CODE .="
							</div>
						";
					}
					else
					{	
						$CODE = "
							<div class='".(new self)->WRITE_S($params,'class')."'>
								<label for='".(new self)->WRITE_S($params,'name')."' class='form-label'>".(new self)->WRITE_S($params,'label')."</label>
								<input class='form-control ".(new self)->WRITE_S($params,'inputclass')." $inputclass' ".(new self)->WRITE($params,'type')." ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'name')." ".(new self)->WRITE($params,'autocomplete')." ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'value')." class='form-control' aria-describedby='Help_".(new self)->WRITE_S($params,'name')."' ".(new self)->WRITE_S($params,'required')." ".(new self)->WRITE_DATA($data).">
								$feedback
								<div id='Help_".(new self)->WRITE_S($params,'name')."' class='form-text'>".(new self)->WRITE_S($params,'helptxt')."</div>
							</div>
						";
					}
			return $CODE;
		}
	}
?>