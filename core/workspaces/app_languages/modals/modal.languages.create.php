<?php
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

//$languages = $CORE->GET_LANGUAGES();
                                
$data['table'] = 'app_languages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_languages')).
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
                        'label'=>$TXT['2-digit code'],
                        'type'=>'text',
                        'name'=>'core_data__code_2digit',
                        'tabindex'=>'100',
                        'required'=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).                
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['5-digit code'],
                        'type'=>'text',
                        'name'=>'core_data__code_5digit',
                        'tabindex'=>'110',
                        'required'=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Short caption'],
                        'type'=>'text',
                        'name'=>'core_data__short_caption',
                        'tabindex'=>'120',
                        'required'=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Long caption'],
                        'type'=>'text',
                        'name'=>'core_data__long_caption',
                        'tabindex'=>'120',
                        'required'=>'required',
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
                            'tabindex'=>'220'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R();                     

                    
$modal= new CORE\MODAL(array(
                        'id'=>"core-create-language-".time(),
                        'title'=>$TXT['Create language'],
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