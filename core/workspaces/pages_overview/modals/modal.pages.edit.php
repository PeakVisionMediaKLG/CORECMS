<?php
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$pageRow = $DB->RETRIEVE(
                            'app_pages',
                            array(),
                            array('id'=>$data['condition']),
                            " LIMIT 1"
                        )[0];
                                
$data['table'] = 'app_pages';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_pages')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).        
                    HIDDEN::PRINT_R(array('name'=>'id','value'=>$pageRow['id'])).  
                    HIDDEN::PRINT_R(array('name'=>'shared_id','value'=>$pageRow['shared_id'])).  
                    HIDDEN::PRINT_R(array('name'=>'language','value'=>$pageRow['language'])).
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            $TXT['Parent page'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation core-select',
                                'label'=>$TXT['Gender'],
                                'name'=>'core_data__shared_parent',
                                'id'=>'gender',
                                'tabindex'=>'180',							
                                'options'=>$PAGE::SELECT_OPTIONS(),
                                'selectedOption'=>$pageRow['shared_parent']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().             
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['URL'],
                        'type'=>'text',
                        'name'=>'core_data__url',
                        'tabindex'=>'60',
                        'required'=>'required',
                        'value'=>$pageRow['name'],
                        'autocomplete'=>'off',
                        'liveValidation'=>array('url','Unique'),
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
                    TEXTAREA::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Title tag'],
                        'type'=>'text',
                        'name'=>'core_data__title',
                        'rows'=>10,
                        'tabindex'=>'110',
                        'value'=>$pageRow['title'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).HR::PRINT_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Show in navigation'],
                            'name'=>'core_data__show_in_navigation]',
                            'value'=>$pageRow['show_in_navigation'],
                            'tabindex'=>'220'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Authorized access only'],
                            'name'=>'core_data__auth_access_only]',
                            'value'=>$pageRow['auth_access_only'],
                            'tabindex'=>'220'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().                    
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                            'caption'=>$TXT['Active'],
                            'name'=>'core_data__is_active]',
                            'value'=>$pageRow['is_active'],
                            'tabindex'=>'220'),
                            array()).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    HIDDEN::PRINT_R(array('name'=>'created_by','value'=>$USER->USERNAME)). 
                    HIDDEN::PRINT_R(array('name'=>'created_date','value'=>time()));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-page-".time(),
                        'title'=>$TXT['Edit page'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']), //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>