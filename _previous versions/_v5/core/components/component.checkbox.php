<?php
//prints out a html/bootstrap form checkbox

class CHECKBOX extends BE_COMPONENT
	{	//id,divclass,class,type,caption

		static function PRINTCODE($params=NULL,$data=NULL)
		{	
			$params['id'] = $params['id'] ?? "id_".str_replace(" ","",microtime());
			$params['caption'] = $params['caption'] ?? "";
			
			if(@$params['value']==1) $checked=" checked"; else $checked="";

			$CODE = "<div class='form-check ".(new self)->WRITE_S($params,'divclass')."'> 
						<input class='form-check-input ".(new self)->WRITE_S($params,'class')."' type='checkbox' "." name='".(new self)->WRITE_S($params,'name')."' ".(new self)->WRITE($params,'id')."  ".(new self)->WRITE($params,'value')." ".(new self)->WRITE_S($params,'disabled')." ".(new self)->WRITE_DATA($data)."$checked>";

						if($params['caption']!="")
						{
							$CODE .= "<label class='form-check-label' for='".(new self)->WRITE_S($params,'id')."'>".(new self)->WRITE_S($params,'caption')."</label>";
						}
			$CODE .= "</div>";

			return $CODE;
		}
	}
?>