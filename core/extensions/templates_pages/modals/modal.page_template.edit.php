<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");

if(!$USER->IS_ADMIN) die ('Unauthorized access.');

require_once(ROOT."core/classes/class.page.php");

$data = $_POST['data'] ?? die('no data sent');

$pageRow = $DB->RETRIEVE(
                            'templates_pages',
                            array(),
                            array('unique_id'=>$data['condition']),
                            " LIMIT 1"
                        )[0];

$data['table'] = 'app_page_objects';

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
            'value'=>$pageRow['name'],
            'autocomplete'=>'off',
            'liveValidation'=>array('alphaNum','Unique'),
            )
        ).
    COLUMN::POST_R().
ROW::POST_R();                   

                    
$modal= new MODAL(array(
                        'id'=>"core-edit-page_template-".time(),
                        'title'=>$TXT['Edit page template'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.backup.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']),
                        'actionDisabled'=>'disabled', 
                        ));

echo $modal->GET_MODAL();  
?>