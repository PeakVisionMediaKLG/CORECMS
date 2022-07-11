<?php
namespace CORE;
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');

    include_once(ROOT."core/classes/class.modal.php");

    define('TXT', json_decode(file_get_contents(ROOT."/core/modals/modal.db.dataset.delete.backup/".$USER->PREFERRED_LANGUAGE.".json"), true));

$modalcontent="<p>".TXT['Are you sure you want to delete this dataset from']." <b>".$data['table']."</b>?</p>";

$get_values = $DB->RETRIEVE( 
    $data['table'],
	array(),
	array('unique_id'=>$data['unique_id'])
);
$get_values = $get_values[0];  


	foreach($get_values as $key => $value)
	{
        if($key=="created_date") $value = date("F j, Y, g:i a",$value);
        $modalcontent.= TEXTBOX::PRINT_R(array(
            'class'=>'mt-2 has-validation',		
            'label'=>$key,
            'type'=>'text',
            'name'=>$key,
            ''=>'disabled',
            'value'=>htmlentities($value),
        ));
	}


$modal = new MODAL(array(
    "id"=>"core-delete-backup-dataset.".time(),
    "title"=>TXT['Delete dataset'],
    "content"=>$modalcontent,
    "cancelLabel"=>TXT['Cancel'],
    "actionLabel"=>TXT['Delete'],
    "actionPath"=>"core/actions/db.dataset.delete.backup.php",
    "dataAttributes"=>array('data-table'=>$data['table'],'data-unique_id'=>$data['unique_id']),
));

echo $modal->GET_MODAL(); 

?>