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

$getSetting = $DB->EASY_QUERY( "SELECT", 
								'core_settings',
								array('*'),
								array(),
								array('id'),
								array($data['condition']),
								"LIMIT 1");

while ($settingsRow=$getSetting->fetch_array())
{
	if(!$USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
	$modalContent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_settings')).
					HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')).
					HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$settingsRow['id'])). 
					TEXTBOX::PRINT_R(array(
						'inline'=>1,
						'class'=>'mt-2 has-validation',		
						'label'=>TXT['Name'],
						'type'=>'text',
						'name'=>'core_data__name',
						'required'=>'required',
						'liveValidation'=>array('alphaNum','Unique'),
						'value'=>$settingsRow['name']
						)
					).
					SELECT::PRINT_R(array(
						'class'=>'has-validation mt-2',
						'label'=>TXT['Type'],
						'name'=>'core_data__type',
						'options'=>$BE->LOADVALUESET('input_types',1),
						'selectedOption'=>$settingsRow['type'],
						'disabled'=>'disabled'
						
					)).
					CHECKBOX::PRINT_R(array('class'=>'core-checkbox',
											'divclass'=>'mt-3',
											'caption'=>TXT['Essential'],
											'name'=>'core_data__essential',
											'value'=>$settingsRow['essential'],
											'disabled'=>$nonAuthorizedDisabled
											),
											array()).
					HR::PRINT_R();

					switch($settingsRow['type'])
					{
						default:
						case "input_type_boolean":
							$modalContent .= 
							CHECKBOX::PRINT_R(array(	'divclass'=>'form-switch',
													'class'=>'core-checkbox mt-2',
													'name'=>'core_data__value',
													'value'=>$settingsRow['value'],
													'disabled'=>$nonAuthorizedDisabled,
												),
											array(  'data-core_data__table'=>'core_settings',
													'data-core_data__condition'=>'id',
													'data-core_data__conditionvalue'=>$settingsRow['value'],
													'data-core_data__column'=>'value',
													'data-core_data__type'=>'bool'
												)     
													);
						break;    

						case "input_type_text":
							$modalContent .=
							TEXTBOX::PRINT_R(array( 'inputclass'=>'form-control-sm',
													'inline'=>1,
													'name'=>'core_data__value',
													'value'=>$settingsRow['value']
												),
											array(  'data-core_data__table'=>'core_settings',
													'data-core_data__condition'=>'id',
													'data-core_data__conditionvalue'=>$settingsRow['id'],
													'data-core_data__column'=>'value',
													'data-core_data__type'=>'text'
												)     
										);                                                            
						break;
						
						case "input_type_colorpicker":
							$modalContent .=
							COLOR_PICKER::PRINT_R(array(   'class'=>'',
													'label'=>'',
													'id'=>'colorpicker'.time(),
													'name'=>'core_data__value',
													'value'=>$settingsRow['value']
												),
											array(  'data-core_data__table'=>'core_settings',
													'data-core_data__condition'=>'id',
													'data-core_data__conditionvalue'=>$settingsRow['value'],
													'data-core_data__column'=>'value',
													'data-core_data__type'=>'text'
												)     
										); 
						break; 
						
						case "input_type_select":
							//print_r($BE->GET_VALUESETS());
							$modalContent .=
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation',
                                'label'=>'caption_'.$USER->PREFERRED_LANGUAGE,
                                'name'=>'core_data__valueset',
                                'id'=>$settingsRow['valueset'],
                                'tabindex'=>'180',							
                                'options'=>$BE->GET_VALUESETS(),
                                'selectedOption'=>$settingsRow['valueset']
							));
						break;                                                            
					} 
					$modalContent .= HR::PRINT_R();
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
								'value'=>$settingsRow['caption_'.$value],
								'required'=>'required',
								'liveValidation'=>array('alphaNum'),
								),array('data-inum'=>0)
							).
						TD::POST_R();
					}	
			}
$modal= new MODAL(array(
                        'id'=>"core-edit-setting-".time(),
                        'title'=>TXT['Edit setting'],
                        'content'=>$modalContent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/dataset.update.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>