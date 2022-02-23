<?php
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$pageRow = $DB->RETRIEVE(
                            'app_page_objects',
                            array(),
                            array('id'=>$data['condition']),
                            " LIMIT 1"
                        )[0];
                                
$data['table'] = 'app_page_objects';

CORE\PAGE::PREPARE_PAGE_OBJECTS("",$DB);
$pageData = CORE\PAGE::$SORTED_PAGE_OBJECTS;

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).        
                    HIDDEN::PRINT_R(array('name'=>'id','value'=>$pageRow['id'])).
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
                                'selectedOption'=>$pageRow['object_type']
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
                                'options'=>CORE\PAGE::SELECT_PARENT($pageData,$pageRow['id']),
                                'selectedOption'=>$pageRow['parent']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R().             
                    HIDDEN::PRINT_R(array('name'=>'edited_by','value'=>$USER->USERNAME)). 
                    HIDDEN::PRINT_R(array('name'=>'edited_date','value'=>time()));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-page_object-".time(),
                        'title'=>$TXT['Edit page object'],
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