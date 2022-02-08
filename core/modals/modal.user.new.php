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

//print_r($BE->BELANGUAGES);

$modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_users')).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Username'],
					'type'=>'text',
					'name'=>'coredata_username',
					'tabindex'=>'60',
					'required'=>'required',
					'value'=>'',
					'autocomplete'=>'off',
					'liveValidation'=>array('alphaNum','Unique'),
					)
				).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Password'],
					'type'=>'password',
					'name'=>'coredata_ph_password',
					'tabindex'=>'80',
					'required'=>'required',
					'value'=>'',
					'autocomplete'=>'off',					
					'liveValidation'=>array('alphaNum'),
					)
			  	).  
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['First name'],
					'type'=>'text',
					'name'=>'coredata_first_name',
					'tabindex'=>'100',
					'required'=>'required',
					'value'=>'',
					'liveValidation'=>array('alphaNum')
					)
			  	).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Last name'],
					'type'=>'text',
					'name'=>'coredata_last_name',
					'tabindex'=>'120',
					'required'=>'required',
					'liveValidation'=>array('alphaNum')
					)
			  	).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['E-mail'],
					'type'=>'text',
					'name'=>'coredata_email',
					'tabindex'=>'140',
					'value'=>'',
					'liveValidation'=>array('eMail')
					)
				  ).
				ROW::PRE_R(array('class'=>'my-2')).
					COLUMN::PRE_R(array('class'=>'col')).
						TXT['Preferred language'].
					COLUMN::POST_R().
					COLUMN::PRE_R(array('class'=>'col')).
						SELECT::PRINT_R(array(
							'class'=>'has-validation',
							'label'=>TXT['Preferred language'],
							'name'=>'coredata_preferred_language',
							'tabindex'=>'160',
							'options'=>$BE->BELANGUAGES,
							'selectedOption'=>'en'
						)).
					COLUMN::POST_R().
				ROW::POST_R(). 
				ROW::PRE_R(array('class'=>'my-2')).
					COLUMN::PRE_R(array('class'=>'col')).
						TXT['Gender'].
					COLUMN::POST_R().
					COLUMN::PRE_R(array('class'=>'col')).
						SELECT::PRINT_R(array(
							'class'=>'has-validation',
							'label'=>TXT['Gender'],
							'name'=>'coredata_gender',
							'tabindex'=>'180',							
							'options'=>$BE->LOADVALUESET('genders',1),
							'selectedOption'=>''
						)).
					COLUMN::POST_R().
				ROW::POST_R(). 
				HR::PRINT_R().CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2','caption'=>TXT['Admin'],'name'=>'coredata_is_admin]','tabindex'=>'200'),array()).
				HIDDEN::PRINT_R(array('name'=>'coredata_date_created','value'=>time()));

				if($USER->IS_SYSTEMADMIN) $modalcontent .= HR::PRINT_R().CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2','caption'=>TXT['System admin'],'name'=>'coredata_is_systemadmin]','tabindex'=>'220'),array());

$modal= new MODAL(array(
                        'id'=>"core-new-user-".time(),
                        'title'=>TXT['New user'],
                        'content'=>$modalcontent,
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