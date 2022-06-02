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

//print_r($data);

$getInclude = $DB->EASY_QUERY( "SELECT", 
                                    'core_includes',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "LIMIT 1");

while ($includeRow=$getInclude->fetch_array())
{


$modalContent = 		
            HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_includes')).
            HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')).
            HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$includeRow['id'])). 
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
                'value'=>$includeRow['name'],
				'type'=>'text',
				'name'=>'core_data__name',
				'required'=>'required',
				'liveValidation'=>array('alphaNum','Unique'),
			),array()
            ).	            
			TEXTAREA::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Code (local)'],
                'value'=>$includeRow['code_local'],
                'rows'=>3,
				'name'=>'core_data__code_local',
			),array()
			). 
			TEXTAREA::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Code (CDN)'],
                'value'=>$includeRow['code_cdn'],                
                'rows'=>3,                
				'name'=>'core_data__code_cdn',
			),array()
			).
            ROW::PRE_R(array('class'=>'my-2')).
                COLUMN::PRE_R(array('class'=>'col')).
                    TXT['Position in document'].
                COLUMN::POST_R().
                COLUMN::PRE_R(array('class'=>'col')).
                    SELECT::PRINT_R(array(
                        'class'=>'has-validation',
                        'label'=>TXT['Position in document'],
                        'name'=>'core_data__position',
                        'options'=>$BE->LOADVALUESET('include_positions',1),
                        'selectedoption'=>$includeRow['position'],
                    )).
                COLUMN::POST_R().
            ROW::POST_R().
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Use CDN'],
										'name'=>'core_data__use_cdn',
                                        'value'=>$includeRow['use_cdn'],
                                    ),array()).                         
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'core_data__essential',
										'disabled'=>$disabled,
                                    ),array()).
            HR::PRINT_R();
            foreach($BE->BELANGUAGES as $key => $value)
            {
                $modalContent .= 
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['Caption']." ".strtoupper($key),
                        'type'=>'text',
                        'name'=>'core_data__caption_'.$value.'',
                        'value'=>$includeRow['caption_'.$value],
                        'required'=>'required',
                        'liveValidation'=>array('alphaNum'),
                        ),array()
                    );
            }                                            
        }
$modal= new CORE\MODAL(array(
                        'id'=>"core-update-include-".time(),
                        'title'=>TXT['Edit include'],
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