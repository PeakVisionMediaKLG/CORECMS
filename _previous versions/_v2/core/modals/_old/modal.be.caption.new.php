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
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'name',
				//'id'=>'',
				//'tabindex'=>'60',
				'required'=>'required',
				//'value'=>'',
				//'autocomplete'=>'off',
				'liveValidation'=>array('alphaNum','Unique'),
			),array('data-inum'=>0)
			).
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'essential',
										//'id'=>'isadmin',
										//'tabindex'=>'200'
										'disabled'=>$disabled,
                                    ),array('data-inum'=>0)).
            HR::PRINT_R();                                
                                    
		foreach($BE->BELANGUAGES as $key => $value)
		{
			$modalContent .= 
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Caption']." ".$key,
					'type'=>'text',
					'name'=>'lang_'.$value,
					//'id'=>'',
					//'tabindex'=>'60',
					'required'=>'required',
					//'value'=>'',
					//'autocomplete'=>'off',
					'liveValidation'=>array('alphaNum'),
					),array('data-inum'=>0)
				);
		}	
//$modalContent .= '<script>$(".chosen-select").chosen();</script>';

$modal= new MODAL(array(
                        'id'=>"core-new-valueset-".time(),
                        'title'=>TXT['New caption'],
                        'content'=>$modalContent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/action.be.caption.insert.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>