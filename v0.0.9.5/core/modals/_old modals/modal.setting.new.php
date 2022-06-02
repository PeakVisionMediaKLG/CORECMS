<?php
include_once("../includes/user.auth.php");
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

include_once(ROOT."core/classes/class.be.php");
$BE = new BE();
$BE->DB = $DB;
$BE->GETBELANGUAGES();
$BE->USER = $USER;
include_once(ROOT."core/classes/class.component.php");

$modalContent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_settings')).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Name'],
					'type'=>'text',
					'name'=>'core_data__name',
					'required'=>'required',
					'liveValidation'=>array('alphaNum','Unique'),
					)
				).
				SELECT::PRINT_R(array(
					'class'=>'has-validation mt-2',
					'label'=>TXT['Type'],
					'name'=>'core_data__type',
					'options'=>$BE->LOADVALUESET('input_types',1),
					'selectedOption'=>''
				)).
				CHECKBOX::PRINT_R(array('class'=>'core-checkbox',
										'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'core_data__essential]',),
										array()).
				HR::PRINT_R();
				foreach($BE->BELANGUAGES as $key => $value)
				{
					$modalContent .= 
					TD::PRE_R(array('class'=>'')).
						TEXTBOX::PRINT_R(array(
							'inline'=>1,
							'class'=>'mt-2 has-validation',		
							'label'=>TXT['Caption'." ".strtoupper($value)],
							'type'=>'text',
							'name'=>'core_data__caption_'.$value,
							'required'=>'required',
							'liveValidation'=>array('alphaNum'),
							),array('data-inum'=>0)
						).
					TD::POST_R();
				}	

$modal= new CORE\MODAL(array(
                        'id'=>"core-new-setting-".time(),
                        'title'=>TXT['New setting'],
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