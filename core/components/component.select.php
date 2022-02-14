<?php
//displays a html/bootstrap select element

class SELECT extends CORE\COMPONENT
	{
	static function PRINTCODE ($params = NULL, $data=NULL)
		{	
			//print_r($params['selectedOption']);
			/* Params: class, label */
			$CODE = "<select class='form-select ".(new self)->WRITE_S($params,'class')."' aria-label='".(new self)->WRITE_S($params,'label')."' ".(new self)->WRITE_DATA($data)." name='".(new self)->WRITE_S($params,'name')."' ".(new self)->WRITE($params,'id')." ".(new self)->WRITE($params,'disabled')." ".(new self)->WRITE($params,'style').">";
			
			$options=$params['options'];
			$selectedOption=$params['selectedOption'] ?? "";
			if(isset($params['emptyOption'])) $CODE .= "<option value=''></option>";
			//print_r($options);
			 foreach($options as $key => $value)
				 {	if($value==$selectedOption) $selected="selected"; else $selected="";
				 	$CODE .= "<option value='$value' $selected>$key</option>";
				 }
			$CODE .= "</select>";
			return $CODE;
		}

	}
?>