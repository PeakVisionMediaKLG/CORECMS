<?php
include_once("../includes/user.auth.php");
    
$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

include_once(ROOT."core/classes/class.be.php");
$BE = new BE();
$BE->DB = $DB;
$BE->GETBELANGUAGES();
$BE->USER = $USER;
include_once(ROOT."core/classes/class.component.php");

if(!$USER->IS_SYSTEMADMIN) $disabled="disabled"; else $disabled="";

//print_r($BE->BELANGUAGES);

$modalContent = 		
			HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_valuesets')).
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'core_data__name',
				'required'=>'required',
				'liveValidation'=>array('alphaNum','Unique'),
			),array()
			).
            PILLBOX::PRINT_R(array(
                'options'=>$BE->LOADVALUESET(),
                'selectedOptions'=>array(),
                'inline'=>1,
                'class'=>'w-100',		
                'label'=>TXT['set values'],
                'type'=>'text',
                'name'=>'core_data__contained_values',
                'id'=>'set_values',
                'required'=>'required',
                ),array()
            ).
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'core_data__essential',
										'disabled'=>$disabled,
                                    ),array()
									).
            HR::PRINT_R();                                

		foreach($BE->BELANGUAGES as $key => $value)
		{
			$modalContent .= 
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Caption']." ".$key,
					'type'=>'text',
					'name'=>'core_data__caption_'.$value.'',
					'required'=>'required',
					'liveValidation'=>array('alphaNum'),
					),array()
				);
		}	

$modal= new CORE\MODAL(array(
                        'id'=>"core-new-valueset-".time(),
                        'title'=>TXT['New value set'],
                        'content'=>$modalContent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/dataset.insert.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>