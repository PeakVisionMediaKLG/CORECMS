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
                                    'core_valuesets',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "LIMIT 1");

while ($valuesetRow=$getValue->fetch_array())
{

$modalContent = 		
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'coredata_name',
				'required'=>'required',
				'value'=>$valuesetRow['name'],
				'liveValidation'=>array('alphaNum','Unique'),
			),array()
			).
            PILLBOX::PRINT_R(array(
                'options'=>$BE->LOADVALUESET(),
                'selectedOptions'=>json_decode($valuesetRow['contained_values']),
                'inline'=>1,
                'class'=>'w-100',		
                'label'=>TXT['set values'],
                'type'=>'text',
                'name'=>'coredata_contained_values',
                'id'=>'set_values',
                'required'=>'required',
                ),array()
            ).
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'coredata_essential',
                                        'value'=>$valuesetRow['essential'],
										'disabled'=>$disabled,
                                    ),array()
            ).
            HR::PRINT_R().
            HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_valuesets')).
            HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')).
            HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$valuesetRow['id']));                                    
        
        foreach($BE->BELANGUAGES as $key => $value)
		{
            $modalContent .= 
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Caption']." ".strtoupper($key),
					'type'=>'text',
					'name'=>'coredata_caption_'.$value.'',
					'required'=>'required',
					'value'=>$valuesetRow['caption_'.$value],
					'liveValidation'=>array('alphaNum'),
                    ),array()
            );
		}	
    }
$modal= new MODAL(array(
                        'id'=>"core-edit-valueset-".time(),
                        'title'=>TXT['Edit value set'],
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