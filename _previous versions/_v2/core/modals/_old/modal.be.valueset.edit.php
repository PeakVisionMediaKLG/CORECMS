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
                                    'be_valuesets',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "ORDER BY name ASC");

while ($valuesetRow=$getValue->fetch_array())
{

$modalContent = 		
			TEXTBOX::PRINT_R(array(
				'inline'=>1,
				'class'=>'mt-2 mb-4 has-validation',		
				'label'=>TXT['Name'],
				'type'=>'text',
				'name'=>'valueset_name',
				//'id'=>'',
				//'tabindex'=>'60',
				'required'=>'required',
				'value'=>$valuesetRow['name'],
				//'autocomplete'=>'off',
				'liveValidation'=>array('alphaNum','Unique'),
			),array('data-inum'=>0)
			).
            PILLBOX::PRINT_R(array(
                'options'=>$BE->LOADVALUESET(),
                'selectedOptions'=>json_decode($valuesetRow['containedValues']),
                'inline'=>1,
                'class'=>'w-100',		
                'label'=>TXT['set values'],
                'type'=>'text',
                'name'=>'valueset_values',
                'id'=>'set_values',
                //'tabindex'=>'90',
                'required'=>'required',
                ),array()
            ).
            CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox',
                                        'divclass'=>'mt-3',
										'caption'=>TXT['Essential'],
										'name'=>'valueset_essential',
										//'id'=>'isadmin',
                                        //'tabindex'=>'200'
                                        'value'=>$valuesetRow['essential'],
										'disabled'=>$disabled,
                                    ),array('data-inum'=>0)).
            HR::PRINT_R().
            TEXTBOX::PRINT_R(array(
                'inline'=>1,
                'class'=>'mt-2 has-validation',		
                'label'=>TXT['Caption'],
                'type'=>'text',
                'name'=>'valueset_caption',
                //'id'=>'',
                //'tabindex'=>'60',
                'required'=>'required',
                'value'=>$valuesetRow['caption'],
                //'autocomplete'=>'off',
                'liveValidation'=>array('alphaNum'),
                ),array('data-inum'=>0)
            ).
            HIDDEN::PRINT_R(array('name'=>'valueset_id','value'=>$valuesetRow['id'])).
            HIDDEN::PRINT_R(array('name'=>'valueset_originalcaption','value'=>$valuesetRow['caption']));                                    
		foreach($BE->BELANGUAGES as $key => $value)
		{
            $getCaption = $DB->EASY_QUERY( "SELECT", 
            'be_captions',
            array('name',$key),
            array(),
            array('name'),
            array($valuesetRow['caption']),
            );   
            
            $getCaption = $getCaption->fetch_array();
            $getCaption = $getCaption[$key];
            
            $modalContent .= 
				TEXTBOX::PRINT_R(array(
					'inline'=>1,
					'class'=>'mt-2 has-validation',		
					'label'=>TXT['Caption']." ".$key,
					'type'=>'text',
					'name'=>'lang_'.$value.'',
					//'id'=>'',
					//'tabindex'=>'60',
					'required'=>'required',
					'value'=>$getCaption,
					//'autocomplete'=>'off',
					'liveValidation'=>array('alphaNum'),
					),array('data-inum'=>0)
				);
		}	
//$modalContent .= '<script>$(".chosen-select").chosen();</script>';
    }
$modal= new MODAL(array(
                        'id'=>"core-edit-valueset-".time(),
                        'title'=>TXT['Edit value set'],
                        'content'=>$modalContent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/action.be.valueset.update.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>