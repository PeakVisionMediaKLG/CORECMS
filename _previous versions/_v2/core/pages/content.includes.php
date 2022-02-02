<?php
if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{

    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-12 '));
        H::PRINT(array('heading'=>TXT['Includes: Javascript, CSS & more'],'type'=>4,'class'=>'text-center'));
            ROW::PRE();
                COLUMN::PRE();
                if($this->USER->IS_ADMIN){
                    COLUMN::PRE(array('class'=>'col-12 text-center mt-4'));
                        BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New include']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>'core/modals/modal.include.new.php'));BTN::POST();
                    COLUMN::POST();
                }
                COLUMN::POST();                
            ROW::POST();

            CARD::PRE(array('class'=>"mt-4 core-text"));
                ROW::PRE(array('class'=>'ms-4'));
                    COLUMN::PRE(array('class'=>'col col-sm-2'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Name']));
                    COLUMN::POST();                               
                    COLUMN::PRE(array('class'=>'col col-sm-2'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Caption']." ".strtoupper($this->USER->PREFERRED_LANGUAGE)));
                    COLUMN::POST();
                    COLUMN::PRE(array('class'=>'col col-sm-2'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Position']));
                    COLUMN::POST();                    
                    COLUMN::PRE(array('class'=>'col'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Use CDN']));
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
                        if($this->USER->IS_SYSTEMADMIN) $ulClass="sortable core-sortable"; else $ulClass=""; 
                            UL::PRE(array('class'=>$ulClass,'style'=>'list-style:none;padding-left:0;'),array('data-path'=>'core/actions/core.drag&drop.php','data-table'=>'core_includes'));
                                    $includesCounter=0;
                                    $getIncludes = $this->DB->EASY_QUERY("SELECT", 
                                                                        'core_includes',
                                                                        array('*'),
                                                                        array(),
                                                                        array(),
                                                                        array(),
                                                                        "ORDER BY id ASC");
                                    while ($includesRow=$getIncludes->fetch_array())
                                    {
                                        LI_MS::PRE(array('class'=>'mt-2 py-1 px-1','style'=>'list-style-type: none;'));
                                            ROW::PRE();
                                                COLUMN::PRE(array('class'=>'col col-sm-2'));
                                                    echo $includesRow['name'];
                                                    HIDDEN::PRINT(array('name'=>$includesCounter.'[name]','value'=>$includesRow['name']));
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col col-sm-2 core-text-secondary'));
                                                    foreach($this->BELANGUAGES as $key => $value)
                                                    {
                                                        HIDDEN::PRINT(array('name'=>$includesCounter.'[caption_'.$key.']','value'=>$includesRow['caption_'.$value]));
                                                    }
                                                    echo $includesRow['caption_'.$this->USER->PREFERRED_LANGUAGE];

                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col col-sm-2'));
                                                    echo $this->GET_CAPTION($includesRow['position'],'core_values');
                                                    HIDDEN::PRINT(array('name'=>$includesCounter.'[position]','value'=>$includesRow['position']));
                                                COLUMN::POST();                                                                                               
                                                HIDDEN::PRINT(array('name'=>$includesCounter.'[code_local]','value'=>$includesRow['code_local']));
                                                HIDDEN::PRINT(array('name'=>$includesCounter.'[code_cdn]','value'=>$includesRow['code_cdn']));

                                                if(!$this->USER->IS_SYSTEMADMIN or $includesRow['essential']) $editValueDisabled="disabled"; else $editValueDisabled="";
                                                if(!$this->USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
                                                COLUMN::PRE(array('class'=>'col'));
                                                    CHECKBOX::PRINT(array(	'divclass'=>'form-switch',
                                                                            'class'=>'core-checkbox mt-2 core-in-place-edit',
                                                                            'name'=>$includesCounter.'[use_cdn]',
                                                                            'value'=>$includesRow['use_cdn'],
                                                                        ),
                                                                    array(  'data-coredata_table'=>'core_includes',
                                                                            'data-coredata_condition'=>'id',
                                                                            'data-coredata_conditionvalue'=>$includesRow['id'],
                                                                            'data-coredata_column'=>'use_cdn',
                                                                            'data-coredata_type'=>'bool'
                                                                        )                                                                    
                                                                    );                                           
                                                COLUMN::POST();                                            
                                                COLUMN::PRE(array('class'=>'col'));
                                                    CHECKBOX::PRINT(array(	'class'=>'core-checkbox mt-2 core-in-place-edit',
                                                                            'name'=>$includesCounter.'[essential]',
                                                                            'value'=>$includesRow['essential'],
                                                                            'disabled'=>'disabled',
                                                                        ));
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col'));
                                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.include.edit.php','data-table'=>'core_includes','data-condition'=>$includesRow['id']));
                                                    BTN::POST();   
                                                COLUMN::POST();
                                                COLUMN::PRE(array('class'=>'col'));
                                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.dataset.delete.php','data-table'=>'core_includes','data-condition'=>'id','data-conditionvalue'=>$includesRow['id']));
                                                    BTN::POST();
                                                COLUMN::POST();   
                                            ROW::POST();
                                        LI_MS::POST();   
                                        $includesCounter++;                     
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