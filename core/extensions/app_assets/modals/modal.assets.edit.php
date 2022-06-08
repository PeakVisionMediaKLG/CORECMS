<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$assetRow = $DB->RETRIEVE(
                            'app_assets',
                            array(),
                            array('id'=>$data['condition']),
                            " LIMIT 1"
                        )[0];
                                
$data['table'] = 'app_languages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_assets')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).                    
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'10',
                        ''=>'required',
                        'value'=>$assetRow['name'],
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
                        'value'=>$assetRow['src_file'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).                
                    TEXTAREA::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Source from database'],
                        'type'=>'text',
                        'name'=>'core_data__src_db',
                        'style'=>'height:100px;',
                        'tabindex'=>'30',
                        'value'=>htmlentities($assetRow['src_db']),
                        'liveValidation'=>array('alphaNum')
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                    COLUMN::PRE_R(array('class'=>'col')).
                        CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                        'caption'=>$TXT['PHP Eval'],
                        'name'=>'core_data__eval',
                        'value'=>$assetRow['eval'],
                        'tabindex'=>'40'),
                        array()).
                    COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active',
                            'value'=>$assetRow['is_active'],
                            'tabindex'=>'50'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R();                        

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-asset-".time(),
                        'title'=>$TXT['Edit asset'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.backup.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>