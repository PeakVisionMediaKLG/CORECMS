<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');
                                
$data['table'] = 'app_assets';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_assets')).
                    HIDDEN::PRINT_R(array('name'=>'core_data__unique_id','value'=>"asset_".md5(microtime(true)))).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'10',
                        ''=>'required',
                        'value'=>'',
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Source from file'],
                        'type'=>'text',
                        'name'=>'core_data__src_file',
                        'tabindex'=>'20',
                        'value'=>'',
                        )
                    ).                
                    TEXTAREA::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Source from database'],
                        'name'=>'core_data__src_db',
                        'tabindex'=>'30',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum'),
                        'style'=>'height:100px;'
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Eval'],
                            'name'=>'core_data__eval',
                            'value'=>0,
                            'tabindex'=>'40'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active',
                            'value'=>0,
                            'tabindex'=>'50'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_by','value'=>$USER->USERNAME)).
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_date','value'=>time()));                      

                    
$modal= new MODAL(array(
                        'id'=>"core-create-asset-".time(),
                        'title'=>$TXT['Add asset'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>