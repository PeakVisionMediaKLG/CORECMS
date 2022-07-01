<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

//$languages = $CORE->GET_LANGUAGES();

$pageRow = $DB->RETRIEVE(
    'app_pages',
    array(),
    array('id'=>$data['condition']),
    " LIMIT 1"
)[0];
                                
$data['table'] = 'app_pages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_pages')).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['URL'],
                        'type'=>'text',
                        'name'=>'core_data__url',
                        'tabindex'=>'60',
                        'required'=>'required',
                        'value'=>$pageRow['url'],
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique','URL'),
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Link text'],
                        'type'=>'text',
                        'name'=>'core_data__link_text',
                        'tabindex'=>'100',
                        'value'=>$pageRow['link_text'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).                
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['&#60;title&#62;'],
                        'type'=>'text',
                        'name'=>'core_data__title',
                        'tabindex'=>'110',
                        'value'=>$pageRow['title'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Page access counter'],
                        'type'=>'text',
                        'name'=>'core_data__access_counter',
                        'tabindex'=>'110',
                        'value'=>$pageRow['access_counter'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Show in navigation'],
                            'name'=>'core_data__show_in_navigation',
                            'value'=>$pageRow['show_in_navigation'],
                            'tabindex'=>'140'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Authorized access only'],
                            'name'=>'core_data__auth_access_only',
                            'value'=>$pageRow['auth_access_only'],
                            'tabindex'=>'160'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active]',
                            'value'=>$pageRow['is_active'],
                            'tabindex'=>'180'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R();                     

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-page-".time(),
                        'title'=>$TXT['Edit page'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.backup.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']),
                         //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>