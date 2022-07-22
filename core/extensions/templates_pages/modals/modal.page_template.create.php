<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();
                                
$data['table'] = 'templates_pages';

$CORE->BUILD_EXTENSIONS(1);

/*PAGE::PREPARE_PAGE_OBJECTS("",$DB);
$pageData = PAGE::$SORTED_PAGE_OBJECTS;*/

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'templates_pages')).
                    HIDDEN::PRINT_R(array('name'=>'core_data__unique_id','value'=>CORE::UNIQUE("page_template"))).
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
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
                        COLUMN::POST_R().
                    ROW::POST_R().
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_by','value'=>$USER->USERNAME)). 
                    HIDDEN::PRINT_R(array('name'=>'core_data__created_date','value'=>time()));                     

                    
$modal= new MODAL(array(
                        'id'=>"core-create-page-template-".time(),
                        'title'=>$TXT['Create page template'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>