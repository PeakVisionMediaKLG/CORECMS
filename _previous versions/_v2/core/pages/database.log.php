<?php

if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{
    ROW::PRE(array('class'=>''));
        COLUMN::PRE(array('class'=>'mb-4 text-center'));
            H::PRINT(array('heading'=>TXT['Database action log'],'type'=>4,'class'=>'text-center mb-4'));
            BTN::PRE(array('class'=>'btn btn-outline-primary core-action-btn','caption'=>TXT['Empty log']." ".BI::GET(array('icon'=>'trash','size'=>'16'))),array('data-path'=>'core/actions/dataset.truncate.php','data-coredata_table'=>'core_dblog'));BTN::POST();
        COLUMN::POST();
    ROW::POST();

    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-12 '));
            CARD::PRE(array('class'=>"mt-4"));
                TABLE::PRE(array('class'=>'table-striped','headers'=>array( 'query_type'=>TXT['Type'],
                                                                            'id'=>TXT['ID'],
                                                                            'affected_table'=>TXT['Table'],
                                                                            'column_keys'=>TXT['Columns'],
                                                                            'column_values'=>TXT['Values'],
                                                                            'condition_keys'=>TXT['Conditions'],
                                                                            'condition_values'=>TXT['Values'],
                                                                            'extended'=>TXT['Extended'],
                                                                            'attempt_date'=>'Date',
                                                                            'error_message'=>'Message',
                                                                            'query_success'=>'Success',
                                                                            'view details'=>'Details'
                                                                        )
                            ));
                
                $get_values = $this->DB->EASY_QUERY( "SELECT", 
                                                        'core_dblog',
                                                        array('*'),
                                                        array(),
                                                        array(),
                                                        array(),
                                                        "ORDER BY id DESC LIMIT 100",0);

                $unwanted=array('[',']','"');                                        
                while ($value_row=$get_values->fetch_array())
                {
                    //print_r($value_row);
                    foreach($value_row as $key => $value)
                    {
                        $value_row[$key] = str_replace($unwanted,'',$value);
                    }
                    FORM::PRE();
                        TR::PRE(array());
                            TD::PRE(array());
                                //print_r($value_row);
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['query_type']));
                            TD::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['id']));
                            TD::POST();      
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['affected_table']));
                            TD::POST();                                          
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['column_keys']));
                            TD::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['column_values']));
                            TD::POST();	
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['condition_keys']));
                            TD::POST();	
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['condition_values']));
                            TD::POST();
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['extended']));
                            TD::POST();	     
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>date('d/M/Y H:i:s',$value_row['attempt_date'])));
                            TD::POST();	                        
                            TD::PRE(array());
                                TEXTBOX::PRINT(array('inputclass'=>'form-control-sm','inline'=>1,'value'=>$value_row['error_message']));
                            TD::POST();
                            TD::PRE();
                                CHECKBOX::PRINT(array('caption'=>' ','inline'=>1,'value'=>$value_row['query_success'],'disabled'=>'disabled')); 
                            TD::POST();	 
                            TD::PRE(array());
                            BTN::PRE(   array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','caption'=>BI::GET(array('icon'=>'search','size'=>'16'))), 
                                        array(  'data-path'=>'core/modals/modal.dataset.view.php',
                                                'data-coredata_table'=>'core_dblog',
                                                'data-coredata_condition'=>'id',
                                                'data-coredata_conditionvalue'=>$value_row['id'])
                                            );
                            BTN::POST();
                        TD::POST();	                                                
                        TR::POST();
                    FORM::POST();
                    }
                TABLE::POST();
            CARD::POST();
        COLUMN::POST();
    ROW::POST();
}    


?>