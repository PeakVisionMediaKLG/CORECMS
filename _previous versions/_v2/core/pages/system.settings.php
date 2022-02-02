<?php
if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{

    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-12 '));
        H::PRINT(array('heading'=>TXT['System settings'],'type'=>4,'class'=>'text-center'));
            ROW::PRE();
                COLUMN::PRE();
                if($this->USER->IS_ADMIN){
                    COLUMN::PRE(array('class'=>'col-12 text-center mt-4'));
                        BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New setting']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>'core/modals/modal.setting.new.php'));BTN::POST();
                    COLUMN::POST();
                }
                COLUMN::POST();                
            ROW::POST();

            CARD::PRE(array('class'=>"mt-4 core-text"));
                ROW::PRE(array('class'=>'ms-4'));
                    COLUMN::PRE(array('class'=>'col col-sm-2'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Name']));
                    COLUMN::POST();                               
                    COLUMN::PRE(array('class'=>'col col-sm-4'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Description']));
                    COLUMN::POST();
                    COLUMN::PRE(array('class'=>'col'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['State']));
                    COLUMN::POST();        
                    COLUMN::PRE(array('class'=>'col'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Essential']));
                    COLUMN::POST();
                    COLUMN::PRE(array('class'=>'col'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Edit']));
                    COLUMN::POST();   
                    COLUMN::PRE(array('class'=>'col'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Delete']));
                    COLUMN::POST();                                                                        
                ROW::POST();
                ROW::PRE();
                    COLUMN::PRE();
                        FORM::PRE();
                        if($this->USER->IS_SYSTEMADMIN) $ulClass=""/*"sortable core-sortable"*/; else $ulClass=""; 
                            UL::PRE(array('class'=>$ulClass,'style'=>'list-style:none;padding-left:0;'),array('data-path'=>'core/actions/core.drag&drop.php','data-table'=>'core_settings'));
                                    $settingsCounter=0;
                                    $getSettings = $this->DB->EASY_QUERY("SELECT", 
                                                                        'core_settings',
                                                                        array('*'),
                                                                        array(),
                                                                        array(),
                                                                        array(),
                                                                        "ORDER BY name ASC");
                                    while ($settingsRow=$getSettings->fetch_array())
                                    {
                                        LI_MS::PRE(array('class'=>'mt-2 py-1 px-1','style'=>'list-style-type: none;'));
                                            ROW::PRE();
                                                COLUMN::PRE(array('class'=>'col col-sm-2'));
                                                    echo $settingsRow['name'];
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col col-sm-4 core-text-secondary'));
                                                    /*HIDDEN::PRINT(array('name'=>$settingsCounter.'[id]','value'=>$settingsRow['id']));*/
                                                    HIDDEN::PRINT(array('name'=>$settingsCounter.'[name]','value'=>$settingsRow['name']));
                                                    foreach($this->BELANGUAGES as $key => $value)
                                                    {
                                                        HIDDEN::PRINT(array('name'=>$settingsCounter.'[caption_'.$key.']','value'=>$settingsRow['caption_'.$value]));
                                                    }
                                                    echo $settingsRow['caption_'.$this->USER->PREFERRED_LANGUAGE];
                                                COLUMN::POST();
                                                if(!$this->USER->IS_ADMIN or $settingsRow['essential']) $editValueDisabled="disabled"; else $editValueDisabled="";
                                                if(!$this->USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
                                                COLUMN::PRE(array('class'=>'col'));
                                                    HIDDEN::PRINT(array('name'=>$settingsCounter.'[type]','value'=>$settingsRow['type']));
                                                    switch($settingsRow['type'])
                                                    {
                                                        default:
                                                        case "input_type_boolean":
                                                            CHECKBOX::PRINT(array(	'divclass'=>'form-switch',
                                                                                    'class'=>'core-checkbox mt-2 core-in-place-edit',
                                                                                    'name'=>$settingsCounter.'[value]',
                                                                                    'value'=>$settingsRow['value'],
                                                                                    'disabled'=>$nonAuthorizedDisabled,
                                                                                ),
                                                                            array(  'data-coredata_table'=>'core_settings',
                                                                                    'data-coredata_condition'=>'id',
                                                                                    'data-coredata_conditionvalue'=>$settingsRow['id'],
                                                                                    'data-coredata_column'=>'value',
                                                                                    'data-coredata_type'=>'bool'
                                                                                )     
                                                                                    );
                                                        break;    

                                                        case "input_type_text":
                                                            TEXTBOX::PRINT(array(   'inputclass'=>'form-control-sm',
                                                                                    'inline'=>1,
                                                                                    'name'=>$settingsCounter.'[value]',
                                                                                    'value'=>$settingsRow['value'],
                                                                                    'disabled'=>'disabled',
                                                                                ),
                                                                            array(  'data-coredata_table'=>'core_settings',
                                                                                    'data-coredata_condition'=>'id',
                                                                                    'data-coredata_conditionvalue'=>$settingsRow['id'],
                                                                                    'data-coredata_column'=>'value',
                                                                                    'data-coredata_type'=>'text'
                                                                                )     
                                                                        );                                                            
                                                        break;
                                                        
                                                        case "input_type_colorpicker":
                                                            COLOR_PICKER::PRINT(array('class'=>'core-in-place-edit',
                                                                                    'label'=>'',
                                                                                    'id'=>'colorpicker'.time(),
                                                                                    'name'=>$settingsCounter.'[value]',
                                                                                    'value'=>$settingsRow['value']
                                                                                ),
                                                                            array(  'data-coredata_table'=>'core_settings',
                                                                                    'data-coredata_condition'=>'id',
                                                                                    'data-coredata_conditionvalue'=>$settingsRow['id'],
                                                                                    'data-coredata_column'=>'value',
                                                                                    'data-coredata_type'=>'text'
                                                                                )     
                                                                        ); 
                                                        break; 
                                                        
                                                        case "input_type_select":
                                                            
                                                            if($settingsRow['valueset'] != ""){
                                                                SELECT::PRINT(array(
                                                                    'class'=>'has-validation core-in-place-edit',
                                                                    'style'=>'z-index:10;position:relative;',                                                                    
                                                                    'name'=>'coredata_value',
                                                                    'id'=>'value',
                                                                    'emptyOption'=>1,
                                                                    'options'=>$this->LOADVALUESET($settingsRow['valueset'],1),
                                                                    'selectedOption'=>$settingsRow['value'],
                                                                    //'disabled'=>'disabled'
                                                                    ),
                                                                    array(  'data-coredata_table'=>'core_settings',
                                                                            'data-coredata_condition'=>'id',
                                                                            'data-coredata_conditionvalue'=>$settingsRow['id'],
                                                                            'data-coredata_column'=>'value',
                                                                            'data-coredata_type'=>'text'
                                                                        )     
                                                                ); 
                                                            } 
                                                            else echo TXT['Please provide valueset'];
                                                        break;                                                            
                                                    }                                                
                                                COLUMN::POST();                                            
                                                COLUMN::PRE(array('class'=>'col'));
                                                    CHECKBOX::PRINT(array(	'divclass'=>'form-switch',
                                                                            'class'=>'core-checkbox mt-2 core-in-place-edit',
                                                                            'name'=>$settingsCounter.'[essential]',
                                                                            'value'=>$settingsRow['essential'],
                                                                            'disabled'=>$nonAuthorizedDisabled,
                                                                        ),
                                                                    array(  'data-coredata_table'=>'core_settings',
                                                                            'data-coredata_condition'=>'id',
                                                                            'data-coredata_conditionvalue'=>$settingsRow['id'],
                                                                            'data-coredata_column'=>'essential',
                                                                            'data-coredata_type'=>'bool'
                                                                    )
                                                                );
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col'));
                                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$nonAuthorizedDisabled,'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.setting.edit.php','data-table'=>'core_settings','data-condition'=>$settingsRow['id']));
                                                    BTN::POST();   
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col'));
                                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.dataset.delete.php','data-table'=>'core_settings','data-condition'=>'id','data-conditionvalue'=>$settingsRow['id']));
                                                    BTN::POST();
                                                COLUMN::POST();   
                                            ROW::POST();
                                        LI_MS::POST();   
                                        $settingsCounter++;                     
                                    }
                            UL::POST();
                        FORM::POST();
                    COLUMN::POST();
                ROW::POST();
            CARD::POST();
        COLUMN::POST();
    ROW::POST();
}
?>