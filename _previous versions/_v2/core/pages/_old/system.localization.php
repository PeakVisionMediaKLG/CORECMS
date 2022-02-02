<?php
if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{


    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-12 '));
        H::PRINT(array('heading'=>TXT['System captions and labels'],'type'=>4,'class'=>'text-center'));
            ROW::PRE();
                COLUMN::PRE();
                if($this->USER->IS_ADMIN){
                    COLUMN::PRE(array('class'=>'col-12 text-center mt-4'));
                        BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New caption']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>'core/modals/modal.be.caption.new.php'));BTN::POST();
                    COLUMN::POST();
                }
                COLUMN::POST();                
            ROW::POST();

            CARD::PRE(array('class'=>"mt-4"));
                ROW::PRE();
                    COLUMN::PRE(array('class'=>'col ms-4'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Name']));
                    COLUMN::POST();
                    foreach($this->BELANGUAGES as $key => $value)
                    {
                        COLUMN::PRE(array('class'=>'col'));
                            H::PRINT(array('type'=>6,'heading'=>$key));
                        COLUMN::POST();                        
                    }
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
                FORM::PRE(); 
                    $captionCounter=0;
                    $getCaptions = $this->DB->EASY_QUERY("SELECT", 
                                                        'be_captions',
                                                        array('*'),
                                                        array(),
                                                        array(),
                                                        array(),
                                                        "ORDER BY name ASC");
                    while ($captionRow=$getCaptions->fetch_array())
                    {
                        ROW::PRE(array('class'=>'mt-1'));
                            COLUMN::PRE(array('class'=>'col'));
                                // HIDDEN::PRINT(array('name'=>$captionCounter.'[id]','value'=>$captionRow['id']));
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'name'=>$captionCounter.'[name]','value'=>$captionRow['name']),array('data-table'=>'be_values','data-object'=>'name','data-condition'=>$captionRow['id']));
                            COLUMN::POST();
                            foreach($this->BELANGUAGES as $key => $value)
                            {
                                COLUMN::PRE(array('class'=>'col'));
                                    TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'name'=>$captionCounter.'['.$key.']','value'=>$captionRow[$value]),array('data-table'=>'be_values','data-object'=>'caption','data-condition'=>$captionRow['id']));
                                COLUMN::POST();                        
                            }
                            if(!$this->USER->IS_SYSTEMADMIN && $captionRow['systemadmin_only']) $editValueDisabled="disabled"; else $editValueDisabled="";
                            COLUMN::PRE(array('class'=>'col'));
                                CHECKBOX::PRINT(array(	'class'=>'core-checkbox mt-2',
                                                        'name'=>$captionCounter.'[systemadmin_only]',
                                                        'value'=>$captionRow['systemadmin_only'],
                                                        'disabled'=>$editValueDisabled,
                                                    ));
                            COLUMN::POST();
                            COLUMN::PRE(array('class'=>'col'));
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.be.caption.edit.php','data-table'=>'be_values','data-condition'=>$captionRow['id']));
                                BTN::POST();   
                            COLUMN::POST();
                            COLUMN::PRE(array('class'=>'col'));
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.be.general.delete.php','data-table'=>'be_captions','data-condition'=>'id','data-conditionvalue'=>$captionRow['id']));
                                BTN::POST();
                            COLUMN::POST();   
                        ROW::POST();
                        $captionCounter++;                     
                    }
                FORM::POST();
            CARD::POST();

        COLUMN::POST();
    ROW::POST();




/*

                TABLE::PRE(array('class'=>'table-striped','headers'=>array('name'=>TXT['Name'],...$this->BELANGUAGES,'value'=>TXT['Essential'],'edit'=>TXT['Edit'],'delete'=>TXT['Delete'])));
    
                    $getCaptions = $this->DB->EASY_QUERY("SELECT", 
                                    'be_captions',
                                    array('*'),
                                    array(),
                                    array(),
                                    array(),
                                    "ORDER BY id ASC");
                    while ($captionRow=$getCaptions->fetch_array())
                    {
                        TR::PRE(array());
                            TD::PRE(array());
                                HIDDEN::PRINT(array('name'=>'id','value'=>$captionRow['id']));
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$captionRow['name']),array('data-table'=>'be_values','data-object'=>'name','data-condition'=>$captionRow['id']));
                            TD::POST();
                            foreach($this->BELANGUAGES as $key => $value)
                            {
                                TD::PRE(array());
                                    TEXTBOX::PRINT(array('label'=>$key,'inputclass'=>'form-control-sm','inline'=>1,'value'=>$value),array('data-table'=>'be_values','data-object'=>'caption','data-condition'=>$captionRow['id']));
                                TD::POST();
                            }
                            if(!$this->USER->IS_SYSTEMADMIN && $value_row['essential']) $editValueDisabled="disabled"; else $editValueDisabled="";
                            TD::PRE(array());
                                CHECKBOX::PRINT(array(	'class'=>'core-checkbox mt-3',
                                                        'name'=>'allvalues[0][essential]',
                                                        'disabled'=>$editValueDisabled,
                                                    ),array('data-inum'=>0));
                            TD::POST();	
                            TD::PRE(array());
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16'))), array('data-path'=>'core/modals/modal.be.value.edit.php','data-table'=>'be_values','data-condition'=>$captionRow['id']));
                                BTN::POST();                                
                            TD::POST();
                            TD::PRE(array());
                                BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$editValueDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.be.value.delete.php','data-table'=>'be_values','data-condition'=>$captionRow['id']));
                                BTN::POST();
                            TD::POST();	                            					
                        TR::POST();
                    }
                TABLE::POST();
            CARD::POST();
    
        COLUMN::POST();*/


}



?>