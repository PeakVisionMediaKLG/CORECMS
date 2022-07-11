<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');
                                
$data['table'] = 'app_languages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_languages')).
                    HIDDEN::PRINT_R(array('name'=>'core_data__unique_id','value'=>CORE::UNIQUE("language"))).
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
                        'label'=>$TXT['2-digit code'],
                        'type'=>'text',
                        'name'=>'core_data__code_2digit',
                        'tabindex'=>'20',
                        ''=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum','Unique')
                        )
                    ).                
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['5-digit code'],
                        'type'=>'text',
                        'name'=>'core_data__code_5digit',
                        'tabindex'=>'30',
                        ''=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Short caption'],
                        'type'=>'text',
                        'name'=>'core_data__short_caption',
                        'tabindex'=>'40',
                        ''=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Long caption'],
                        'type'=>'text',
                        'name'=>'core_data__long_caption',
                        'tabindex'=>'50',
                        ''=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active]',
                            'value'=>0,
                            'tabindex'=>'60')).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_by','value'=>$USER->USERNAME)).
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_date','value'=>time()));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-create-language-".time(),
                        'title'=>$TXT['Create language'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>