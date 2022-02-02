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

if(!$USER->IS_SYSTEMADMIN) $disabled="disabled"; else $disabled="";

$modalContent = 
TABLE::PRE_R().
	TR::PRE_R().
		TH::PRE_R(array('class'=>'')).
			TXT['Name'].
		TH::POST_R().
		TH::PRE_R(array('class'=>'')).
			TXT['Type'].
		TH::POST_R().
		TH::PRE_R(array('class'=>'')).
			TXT['Essential'].
		TH::POST_R();
	foreach($BE->BELANGUAGES as $key => $value)
	{
		$modalContent .= 
		TH::PRE_R(array('class'=>'')).
			$value.
		TH::POST_R();
	}		
$modalContent .= 		
	TR::POST_R().
	TR::PRE_R().
		TD::PRE_R(array('class'=>'')).
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 has-validation',		
				'type'=>'text',
				'name'=>'dataset[name]',
				'required'=>'required',
				'liveValidation'=>array('alphaNum','Unique'),
			)
			).
		TD::POST_R().	
		TD::PRE_R(array('class'=>'')).
            SELECT::PRINT_R(array(
                'class'=>'has-validation mt-2',
				'inline'=>1,                
                //'label'=>TXT['Type'],
                'name'=>'dataset[type]',
                'tabindex'=>'160',
                'options'=>$BE->BELANGUAGES,
            )).
		TD::POST_R().
		TD::PRE_R(array('class'=>'')).
			CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox mt-3',
										'name'=>'dataset[essential]',
										'disabled'=>$disabled,
									)).
		TD::POST_R();
		foreach($BE->BELANGUAGES as $key => $value)
		{
			$modalContent .= 
			TD::PRE_R(array('class'=>'')).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'type'=>'text',
					'name'=>'dataset[lang_'.$value.']',
					'required'=>'required',
					'liveValidation'=>array('alphaNum'),
					)
				).
			TD::POST_R();
		}	
$modalContent .=		
	TR::POST_R().
TABLE::POST_R();


//$modalContent.='<script>$(".chosen-select").chosen();</script>';*/

$modal= new MODAL(array(
                        'id'=>"core-new-value-".time(),
                        'title'=>TXT['New setting'],
                        'content'=>$modalContent,
						'contentSize'=>'modal-xl',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/action.be.setting.insert.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>