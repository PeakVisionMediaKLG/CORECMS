<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();
                                
$data['table'] = 'app_page_objects';

$CORE->BUILD_EXTENSIONS(1);

PAGE::PREPARE_PAGE_OBJECTS("",$DB);
$pageData = PAGE::$SORTED_PAGE_OBJECTS;

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
                    HIDDEN::PRINT_R(array('name'=>'core_data__unique_id','value'=>CORE::UNIQUE("page_object"))).
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
                                'selected-option'=>''
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
                                'options'=>PAGE::SELECT_PARENT($pageData),
                                'selected-option'=>''
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Name'],
                        'type'=>'text',
                        'name'=>'core_data__name',
                        'tabindex'=>'190',
                        'required'=>'required',
                        'value'=>'',
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_by','value'=>$USER->USERNAME)). 
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_date','value'=>time())).
                    HIDDEN::PRINT_R(array('name'=>'core_data__is_active','value'=>0));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-create-page_object-".time(),
                        'title'=>$TXT['Create page object'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>