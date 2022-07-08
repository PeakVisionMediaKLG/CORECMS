<?php
namespace CORE;
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

define('TXT', json_decode(file_get_contents(ROOT."/core/modals/modal.db.dataset.undelete/".$USER->PREFERRED_LANGUAGE.".json"), true));

$modalcontent="<p>".TXT['Deleted datasets'].":</p><br>";

//print_r($data);

$get_values = $DB->RETRIEVE(
    $data['table']."_archive",
    array(),
array('edited_action'=>'delete'),
    "ORDER BY edited_date DESC");                                       

//$get_values = $get_values[0];
//print_r($get_values);

$modalcontent.=
    HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id'));

foreach($get_values as $key => $value)
{
    $check_if_exists = $DB->RETRIEVE(
                        $data['table'],
                        array(),
                        array('unique_id'=>$value['unique_id']),
                        "LIMIT 1"); 

    if(@$check_if_exists[0]['unique_id']==$value['unique_id']) $radio_disabled="disabled"; else $radio_disabled="";

    $modalcontent.=
    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$value['unique_id'])).  
    HIDDEN::PRINT_R(array('name'=>'table','value'=>$data['table'])).
    RADIO::PRINT_R(array('class'=>'core-radio mt-2 mb-2 has-validation core-extend core-disable',
    'caption'=>
        ROW::PRE_R(array('style'=>'position:relative;top:-1em;')).
            COLUMN::PRE_R(array('class'=>'col-3')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Author'],
                    'type'=>'text',
                    'name'=>'core_data__author',
                    'value'=>$value['edited_by'],
                    'disabled'=>'disabled'
                )).  
            COLUMN::POST_R().
            COLUMN::PRE_R(array('class'=>'col-6')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Date'],
                    'type'=>'text',
                    'name'=>'core_data__date',
                    'value'=>date("F j, Y, g:i a",(int)$value['edited_date']),
                    'disabled'=>'disabled'
                )).
            COLUMN::POST_R().
            COLUMN::PRE_R(array('class'=>'col-3')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Action'],
                    'type'=>'text',
                    'name'=>'core_data__action',
                    'value'=>$value['edited_action'],
                    'disabled'=>'disabled'
                )).
            COLUMN::POST_R().
        ROW::POST_R(),
    'name'=>'dataset_to_restore',
    'value'=>$value['archive_id'],
    ''=>'required',
    ''=>$radio_disabled,
    "data-path"=>$CORE->GET_DOM_PATH()."core/modals/modal.db.dataset.undelete.extend/modal.php",
    )
    );
}

$modal = new MODAL(array(
    "id"=>"core-undelete-dataset.".time(), //modal id
    "title"=>TXT['Restore dataset'], //modal title
    "content"=>$modalcontent, //modal content
    'staticModal'=>'data-bs-backdrop="static"',
    "cancelLabel"=>TXT['Cancel'], //cancel caption
    "actionLabel"=>TXT['Restore'], //action caption
    "actionPath"=>"core/actions/db.dataset.insert.from.archive.php",//action path
    "dataAttributes"=>array('data-table'=>$data['table']),//data-attribute,
    "actionDisabled"=>"disabled"
));

echo $modal->GET_MODAL(); 




/*
$get_values = $DB->RETRIEVE(
    $data['table']."_archive",
    array(),
array('unique_id'=>$data['unique_id'],'edited_action'=>'delete'),
    "ORDER BY edited_date DESC");                                       
//$get_values = $get_values[0];

//print_r($get_values);

foreach($get_values as $key => $value)
{
    $modalcontent.=
    HIDDEN::PRINT_R(array('name'=>'table','value'=>'app_page_objects')).
    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$value['unique_id'])).  
    HIDDEN::PRINT_R(array('name'=>'table','value'=>$data['table'])).
    RADIO::PRINT_R(array('class'=>'core-radio mt-2 mb-2 has-validation core-extend core-disable',
    'caption'=>
        ROW::PRE_R(array('style'=>'position:relative;top:-1em;')).
            COLUMN::PRE_R(array('class'=>'col-3')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Author'],
                    'type'=>'text',
                    'name'=>'core_data__author',
                    'value'=>$value['edited_by'],
                    'disabled'=>'disabled'
                )).  
            COLUMN::POST_R().
            COLUMN::PRE_R(array('class'=>'col-6')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Date'],
                    'type'=>'text',
                    'name'=>'core_data__date',
                    'value'=>date("F j, Y, g:i a",(int)$value['edited_date']),
                    'disabled'=>'disabled'
                )).
            COLUMN::POST_R().
            COLUMN::PRE_R(array('class'=>'col-3')).
                TEXTBOX::PRINT_R(array(
                    'class'=>'mt-2',		
                    'label'=>TXT['Action'],
                    'type'=>'text',
                    'name'=>'core_data__action',
                    'value'=>$value['edited_action'],
                    'disabled'=>'disabled'
                )).
            COLUMN::POST_R().
        ROW::POST_R(),
    'name'=>'dataset_to_restore',
    'value'=>$value['archive_id'],
    ''=>'required',
    "data-path"=>$CORE->GET_DOM_PATH()."core/modals/modal.db.dataset.restore.extend/modal.php",
    )
    );
}

$modal = new MODAL(array(
    "id"=>"core-restore-dataset.".time(), //modal id
    "title"=>TXT['Restore dataset'], //modal title
    "content"=>$modalcontent, //modal content
    'staticModal'=>'data-bs-backdrop="static"',
    "cancelLabel"=>TXT['Cancel'], //cancel caption
    "actionLabel"=>TXT['Restore'], //action caption
    "actionPath"=>"core/actions/db.dataset.update.backup.php",//action path
    "dataAttributes"=>array('data-table'=>$data['table'],'data-id'=>$data['unique_id']),//data-attribute,
    "actionDisabled"=>"disabled"
));

echo $modal->GET_MODAL();  
*/
?>