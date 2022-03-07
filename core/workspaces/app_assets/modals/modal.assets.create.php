<?php
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

//$languages = $CORE->GET_LANGUAGES();
                                
$data['table'] = 'app_assets';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_assets')).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
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
                        'label'=>$TXT['Source from file'],
                        'type'=>'text',
                        'name'=>'core_data__src_file',
                        'tabindex'=>'100',
                        'value'=>'',
                        )
                    ).                
                    TEXTAREA::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Source from database'],
                        'type'=>'text',
                        'name'=>'core_data__src_db',
                        'tabindex'=>'110',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                    COLUMN::PRE_R(array('class'=>'col')).
                        CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                        'caption'=>$TXT['PHP Eval'],
                        'name'=>'core_data__eval',
                        'value'=>0,
                        'tabindex'=>'220'),
                        array()).
                    COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active',
                            'value'=>0,
                            'tabindex'=>'230'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R();                     

                    
$modal= new MODAL(array(
                        'id'=>"core-create-asset-".time(),
                        'title'=>$TXT['Add asset'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']), //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>