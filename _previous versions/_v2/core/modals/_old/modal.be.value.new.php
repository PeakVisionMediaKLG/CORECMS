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

//print_r($BE->BELANGUAGES);

$modalContent = 
TABLE::PRE_R(array('class'=>'valuetable')).
	TR::PRE_R().
		TH::PRE_R(array('class'=>'')).
			TXT['Name'].
		TH::POST_R().
		TH::PRE_R(array('class'=>'')).
			TXT['Value'].
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
	TR::PRE_R(array('id'=>'valuerow')).
		TD::PRE_R(array('class'=>'')).
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 has-validation',		
				//'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'allvalues[0][name]',
				//'id'=>'',
				//'tabindex'=>'60',
				'required'=>'required',
				//'value'=>'',
				//'autocomplete'=>'off',
				'liveValidation'=>array('alphaNum','Unique'),
			),array('data-inum'=>0)
			).
		TD::POST_R().	
		TD::PRE_R(array('class'=>'')).
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 has-validation',		
				//'label'=>TXT['Value'],
				'type'=>'text',
				'name'=>'allvalues[0][value]',
				//'id'=>'',
				//'tabindex'=>'60',
				'required'=>'required',
				//'value'=>'',
				//'autocomplete'=>'off',
				'liveValidation'=>array('alphaNum'),
				),array('data-inum'=>0)
			).
		TD::POST_R().
		TD::PRE_R(array('class'=>'')).
			CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox mt-3',
										//'caption'=>TXT['Admin'],
										'name'=>'allvalues[0][essential]',
										//'id'=>'isadmin',
										//'tabindex'=>'200'
										'disabled'=>$disabled,
									),array('data-inum'=>0)).
		TD::POST_R();
		foreach($BE->BELANGUAGES as $key => $value)
		{
			$modalContent .= 
			TD::PRE_R(array('class'=>'')).
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					//'label'=>TXT['Value'],
					'type'=>'text',
					'name'=>'allvalues[0][lang_'.$value.']',
					//'id'=>'',
					//'tabindex'=>'60',
					'required'=>'required',
					//'value'=>'',
					//'autocomplete'=>'off',
					'liveValidation'=>array('alphaNum'),
					),array('data-inum'=>0)
				).
			TD::POST_R();
		}	
$modalContent .=		
	TR::POST_R().
TABLE::POST_R().
TABLE::PRE_R();

$modalContent .= 
	TR::PRE_R().
		TD::PRE_R(array('colspan'=>3+count($BE->BELANGUAGES))).
			BTN::PRE_R(array('class'=>'btn btn-outline-secondary core-clone-btn','caption'=>BI::GET(array('icon'=>'plus','size'=>'20'))),array('data-elementtoclone'=>'valuerow','data-appendtoelement'=>'valuetable')).
			BTN::POST_R().			
		TD::POST_R().
	TR::POST_R();

$modalContent .=	
TABLE::POST_R();

//$modalContent.='<script>$(".chosen-select").chosen();</script>';*/

$modal= new MODAL(array(
                        'id'=>"core-new-value-".time(),
                        'title'=>TXT['New value'],
                        'content'=>$modalContent,
						'contentSize'=>'modal-xl',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/action.be.value.insert.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>