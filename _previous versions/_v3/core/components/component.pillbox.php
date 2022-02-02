<?php
//displays a custom pillbox select

class PILLBOX extends BE_COMPONENT
{

static function PRINTCODE($params=NULL, $data=NULL)
    {
        $CODE = "<select class='chosen-select ".(new self)->WRITE_S($params,'class')."' data-placeholder='".(new self)->WRITE_S($params,'label')."' multiple='multiple' ".(new self)->WRITE($params,'tabindex')." ".(new self)->WRITE($params,'id')." name='".(new self)->WRITE_S($params,'name')."[]' ".(new self)->WRITE_DATA($data).">";
    
            //print_r($params['options']); 
            
            foreach($params['options'] as $key => $value)
                //echo"XXX".$key."XXX".$value;
             {	if(in_array ($value,$params['selectedOptions'])) $selected="selected"; else $selected="";
                 $CODE .= "<option value='$value' $selected>$key</option>";
             }
    
        $CODE .= "</select>";			
        return $CODE;
    
    //label, tabindex, id, 	
    }

}
?>