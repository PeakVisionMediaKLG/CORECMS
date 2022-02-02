<?php

class AUTOFORM
{
	static function GET_FORM($dbTable,$userLanguage,$dbData=null)
	{
        if(file_exists(ROOT."/core/tables/".$dbTable."/form.json")) 
        {
            $tableJson = file_get_contents(ROOT."/core/tables/".$dbTable."/form.json");
            $tableJson = json_decode($tableJson, true);
            $tableJson = $tableJson['form'];
            //var_dump($config_array);
        }
        else die('Table config Json file not found. - '.ROOT."/core/tables/".$dbTable."/form.json");

        $userLanguage=strtoupper($userLanguage);
        if(file_exists(ROOT."core/tables/".$dbTable."/$userLanguage.json")) 
        {
            $TXT = json_decode(file_get_contents(ROOT."core/tables/".$dbTable."/$userLanguage.json"),true);
        }
        else die('Table labels translation Json file not found. - '.ROOT."core/tables/".$dbTable."/$userLanguage.json");

        $formString="";

        foreach($tableJson as $input => $inputSettings)
        {
            //print_r($inputSettings);
            switch ($inputSettings['input_type'])
            {
                case "TEXTBOX":
                    $dbData[$input] = $dbData[$input] ?? "";
                    if(!$inputSettings['hidden']){
                        if($inputSettings['show_in_form'])
                            {                            
                                $formString .= "<div class='row mt-1'><div class='col'>";
                                $formString .= "    <label for='$input' class='form-label'>".$TXT[$inputSettings['input_label']]."</label></div>";
                                $formString .= "    <div class='col'><input type='text' class='form-control' id='$input' name='core_form__$input' value='".$dbData[$input]."'>";
                                $formString .= "</div></div>";
                            }
                    else $formString .= "<input type='hidden' name='core_form__$input' value='".$dbData[$input]."'>";
                    }
                break;
                
                case "CHECKBOX":
                    $checked="";
                    if(isset($dbData[$input]))
                    {
                        if($dbData[$input]) $checked="checked";
                    }
                    else $dbData[$input] = "";
                    //echo $dbData[$input];
                    $formString .= "<div class='row mt-2'><div class='col'>
                                        <label for='$input' class='form-label'>".$TXT[$inputSettings['input_label']]."</label>
                                    </div>
                                    <div class='col'>
                                        <input class='form-check-input core-checkbox' type='checkbox' name='core_form__$input' value=".$dbData[$input]." id='$input' $checked>
                                    </div>  
                                    </div>";
                break;

                case "SELECT":
                    $dbData[$input] = $dbData[$input] ?? "";

                        $formString .= "
                                    <div class='row mt-2'><div class='col'>
                                        <label for='$input' class='form-label'>".$TXT[$inputSettings['input_label']]."</label>
                                    </div>
                                    <div class='col'>
                                        <select class='form-select mb-1' name='core_form__$input'
                            aria-label='".$TXT[$inputSettings['input_label']]."'>";
                            if(is_array($inputSettings['source']))
                            {
                                foreach($inputSettings['source'] as $label => $value)
                                {   
                                    if($dbData[$input]==$value) $selected = " selected"; else $selected = "";
                                    $formString .= "<option value='$value'$selected>".$TXT[$label]."</option>";  
                                }
                            }
                            else 
                            {
                                if(file_exists(ROOT."/core/tables/".$dbTable."/".$inputSettings['source'])) 
                                {
                                    include_once(ROOT."/core/tables/".$dbTable."/".$inputSettings['source']);
                                }
                                else die("File not found: ".ROOT."/core/tables/".$dbTable."/".$inputSettings['source']);
                            }
                        $formString .=    
                        "</select></div></div>";



                break;    
            }
        }
        //echo $formString;
        return $formString;
	} 
}
?>