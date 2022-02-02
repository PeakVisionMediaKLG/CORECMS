<?php
//displays a html/bootstrap select element

class COLOR_PICKER extends BE_COMPONENT
	{
	static function PRINTCODE ($params = NULL, $data=NULL)
		{	
			/* Params: class, label, id, name, value */
			$CODE="";
			if((isset($params['id']) and $params['id']!="") and (isset($params['label']) and $params['label']!="")) 
			{
				$CODE .= "<label for='".(new self)->WRITE_S($params,'id')."' class='form-label'>".(new self)->WRITE_S($params,'label')."</label>";
			}
			$CODE .= "
			<input type='color' class='form-control form-control-color ".(new self)->WRITE_S($params,'class')."' id='".(new self)->WRITE_S($params,'id')."' ".(new self)->WRITE_DATA($data)." ".(new self)->WRITE($params,'name')." value='".(new self)->WRITE_S($params,'value')."' title='".(new self)->WRITE_S($params,'label')."'>";

			return $CODE;
		}

	}
?>