<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$pageRow = $DB->RETRIEVE(
                            'app_page_objects',
                            array(),
                            array('unique_id'=>$data['condition']),
                            " LIMIT 1"
                        )[0];

$data['table'] = 'app_page_objects';

$CORE->BUILD_EXTENSIONS(1);

PAGE::PREPARE_PAGE_OBJECTS("",$DB);
$pageData = PAGE::$SORTED_PAGE_OBJECTS;

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).        
                    //HIDDEN::PRINT_R(array('name'=>'id','value'=>$pageRow['id'])).
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
                                'options'=>$CORE->GET_VALUESET('pages_overview','page_objects'),
                                'selected-option'=>$pageRow['object_type']
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
                                'options'=>PAGE::SELECT_PARENT($pageData,$pageRow['unique_id']),
                                'selected-option'=>$pageRow['parent']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'190',
                        'required'=>'required',
                        'value'=>$pageRow['name'],
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
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
                        'id'=>"core-edit-page_object-".time(),
                        'title'=>$TXT['Edit page object'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.backup.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']),
                        'actionDisabled'=>'disabled', 
                        ));

echo $modal->GET_MODAL();  
?>