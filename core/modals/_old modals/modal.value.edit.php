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

$getValue = $DB->EASY_QUERY( "SELECT", 
                                    'core_values',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "LIMIT 1");

while ($valueRow=$getValue->fetch_array())
{

$modalContent = 		
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'core_data__name',
				'required'=>'required',
				'value'=>$valueRow['name'],
				'liveValidation'=>array('alphaNum','Unique'),
			),array()
			).
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Value'],
				'type'=>'text',
				'name'=>'core_data__value',
				'required'=>'required',
				'value'=>$valueRow['value'],
				'liveValidation'=>array('alphaNum','Unique'),
			),array()
			).
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'core_data__essential',
                                        'value'=>$valueRow['essential'],
										'disabled'=>$disabled,
                                    ),array()
            ).
            HR::PRINT_R().
            HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_values')).
            HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')).
            HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$valueRow['id']));                                    
        
        foreach($BE->BELANGUAGES as $key => $value)
		{
            $modalContent .= 
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Caption']." ".strtoupper($key),
					'type'=>'text',
					'name'=>'core_data__caption_'.$value.'',
					'required'=>'required',
					'value'=>$valueRow['caption_'.$value],
					'liveValidation'=>array('alphaNum'),
                    ),array()
            );
		}	
    }
$modal= new CORE\MODAL(array(
                        'id'=>"core-edit-value-".time(),
                        'title'=>TXT['Edit value'],
                        'content'=>$modalContent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/dataset.update.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>