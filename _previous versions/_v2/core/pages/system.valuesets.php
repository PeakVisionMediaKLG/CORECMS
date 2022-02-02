<?php
if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{

    ROW::PRE(array('class'=>'ms-auto me-auto w90'));
        COLUMN::PRE(array('class'=>'col'));
            H::PRINT(array('class'=>'text-center','heading'=>TXT['Values & value sets'],'type'=>4));
        COLUMN::POST();
    ROW::POST();
    
    ROW::PRE(array('class'=>'mt-4 ms-auto me-auto w90'));
        COLUMN::PRE(array('class'=>'col-6 text-end mb-4'));
            BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New value']." ".BI::GET(array('icon'=>'input-cursor','size'=>'16'))),array('data-path'=>'core/modals/modal.value.new.php'));BTN::POST();
        COLUMN::POST();

        COLUMN::PRE(array('class'=>'col-6 text-start mb-4'));
            BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New value set']." ".BI::GET(array('icon'=>'list-stars','size'=>'16'))),array('data-path'=>'core/modals/modal.valueset.new.php'));BTN::POST();
        COLUMN::POST();
    ROW::POST();
    
//-----------------------------------------------------------------------------list all values------------------------------------------------------------------
    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-6 '));
        H::PRINT(array('heading'=>TXT['Values'],'type'=>4,'class'=>'text-center'));
            CARD::PRE(array('class'=>"mt-4"));
                TABLE::PRE(array('class'=>'table-striped','headers'=>array('name'=>TXT['Name'],'caption'=>TXT['Caption EN'],'value'=>TXT['Value'],'edit'=>TXT['Edit'],'delete'=>TXT['Delete'])));
    
                    $get_values = $this->DB->EASY_QUERY( "SELECT", 
                                                            'core_values',
                                                            array('*'),
                                                            array(),
                                                            array(),
                                                            array(),
                                                            "ORDER BY name ASC");
                    while ($value_row=$get_values->fetch_array())
                    {
                        TR::PRE(array());
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['name']),array('data-table'=>'core_values','data-object'=>'name','data-condition'=>$value_row['id']));
                            TD::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['caption_en']),array('data-table'=>'core_values','data-object'=>'caption','data-condition'=>$value_row['id']));
                            TD::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['value']),array('data-table'=>'core_values','data-object'=>'value','data-condition'=>$value_row['id']));
                            TD::POST();	
                            TD::PRE(array());
                                if(!$this->USER->IS_SYSTEMADMIN && $value_row['essential']) $editValueDisabled="disabled"; else $editValueDisabled="";
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.value.edit.php','data-table'=>'core_values','data-condition'=>$value_row['id']));
                                BTN::POST();                                
                            TD::POST();
                            TD::PRE(array());
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.dataset.delete.php','data-table'=>'core_values','data-condition'=>'id','data-conditionvalue'=>$value_row['id']));
                                BTN::POST();
                            TD::POST();	                            					
                        TR::POST();
                    }
                TABLE::POST();
            CARD::POST();
    
        COLUMN::POST();

//-----------------------------------------------------------------------------list all value sets------------------------------------------------------------------
        
        COLUMN::PRE(array('class'=>'col-6'));
            H::PRINT(array('heading'=>TXT['Value sets'],'type'=>4, 'class'=>'text-center'));
            
            CARD::PRE(array('class'=>"mt-4"));
                TABLE::PRE(array('class'=>'table-striped','headers'=>array('name'=>TXT['Name'],'caption'=>TXT['Caption EN'],'value'=>TXT['Values'],'edit'=>TXT['Edit'],'delete'=>TXT['Delete'])));
    
                    $get_values = $this->DB->EASY_QUERY( "SELECT", 
                                                            'core_valuesets',
                                                            array('*'),
                                                            array(),
                                                            array(),
                                                            array(),
                                                            "ORDER BY name ASC");
                    while ($value_row=$get_values->fetch_array())
                    {
                        TR::PRE(array());
                            TH::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['name']),array('data-table'=>'core_valuesets','data-object'=>'name','data-condition'=>$value_row['id']));
                            TH::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['caption_en']),array('data-table'=>'core_valuesets','data-object'=>'caption','data-condition'=>$value_row['id']));
                            TD::POST();
                            TD::PRE(array());
                                $value_row['contained_values'] = @implode(',',@json_decode($value_row['contained_values']));
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['contained_values']),array());
                            TD::POST();	
                            TD::PRE(array());
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.valueset.edit.php','data-table'=>'core_valuesets','data-condition'=>$value_row['id']));
                                BTN::POST();
                            TD::POST();	                            
                            TD::PRE(array());
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.dataset.delete.php','data-table'=>'core_valuesets','data-condition'=>'id','data-conditionvalue'=>$value_row['id']));
                                BTN::POST();
                            TD::POST();
                        TR::POST();
                    }
                TABLE::POST();
            CARD::POST();
        COLUMN::POST();
         
    ROW::POST();

} else die('Unauthorized Access');
?>   