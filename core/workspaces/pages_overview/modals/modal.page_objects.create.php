<?php
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();
                                
$data['table'] = 'app_page_objects';

CORE\PAGE::PREPARE_PAGE_OBJECTS("",$DB);
$pageData = CORE\PAGE::$SORTED_PAGE_OBJECTS;

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            $TXT['Object type'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation core-select',
                                'label'=>$TXT['Object type'],
                                'name'=>'core_data__object_type',
                                'id'=>'object_type',
                                'tabindex'=>'180',							
                                'options'=>$CORE->LOAD_VALUESET('page_objects'),
                                'selectedOption'=>''
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().                    
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            $TXT['Parent page'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation core-select',
                                'label'=>$TXT['Parent page'],
                                'name'=>'core_data__parent',
                                'id'=>'gender',
                                'tabindex'=>'180',							
                                'options'=>CORE\PAGE::SELECT_PARENT($pageData),
                                'selectedOption'=>''
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Internal name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'190',
                        'required'=>'required',
                        'value'=>'',
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).             
                    HIDDEN::PRINT_R(array('name'=>'created_by','value'=>$USER->USERNAME)). 
                    HIDDEN::PRINT_R(array('name'=>'created_date','value'=>time())).
                    HIDDEN::PRINT_R(array('name'=>'is_active','value'=>0));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-create-page_object-".time(),
                        'title'=>$TXT['Create page object'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>