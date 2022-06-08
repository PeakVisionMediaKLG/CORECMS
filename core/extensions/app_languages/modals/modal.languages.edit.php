<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$languageRow = $DB->RETRIEVE(
                            'app_languages',
                            array(),
                            array('id'=>$data['condition']),
                            " LIMIT 1"
                            )[0];
                                
$data['table'] = 'app_languages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_languages')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).                    
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'10',
                        ''=>'required',
                        'value'=>$languageRow['name'],
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
                        'value'=>$languageRow['code_2digit'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).                
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['5-digit code'],
                        'type'=>'text',
                        'name'=>'core_data__code_5digit',
                        'tabindex'=>'30',
                        ''=>'required',
                        'value'=>$languageRow['code_5digit'],
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
                        'value'=>$languageRow['short_caption'],
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
                        'value'=>$languageRow['long_caption'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active]',
                            'value'=>$languageRow['is_active'],
                            'tabindex'=>'60')).
                        COLUMN::POST_R().
                    ROW::POST_R();                      

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-language-".time(),
                        'title'=>$TXT['Edit language'],
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