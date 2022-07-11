<?php //delete dataset
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');

    include_once(ROOT."core/classes/class.modal.php");

    define('TXT', json_decode(file_get_contents(ROOT."/core/modals/modal.db.dataset.delete/".$USER->PREFERRED_LANGUAGE.".json"), true));

$modalcontent="<p>".TXT['Are you sure you want to delete this dataset?']."</p><br>";
$modalcontent.="<p>".$data['table']."</p>";
$get_values = $DB->RETRIEVE( 
    $data['table'],
	array(),
	array('id'=>$data['id'])
);
$get_values = $get_values[0];  


	foreach($get_values as $key => $value)
	{
		/*if(!is_numeric($key))  */
        $modalcontent.="<div class='row'>";
        $modalcontent.="<div class='col pr-2'>$key:</div><div class='col'> $value</div>";	
        $modalcontent.="</div>";
	}


$modal = new CORE\MODAL(array(
    "id"=>"core-delete-dataset.".time(), //modal id
    "title"=>TXT['Delete dataset'], //modal title
    "content"=>$modalcontent, //modal content"cancelLabel"=>TXT['Cancel'], //cancel caption
    "actionLabel"=>TXT['Delete'], //action caption
    "actionPath"=>"core/actions/db.dataset.delete.backup.php",//action path
    "dataAttributes"=>array('data-table'=>$data['table'],'data-id'=>$data['id']),//data-attribute
));

echo $modal->GET_MODAL(); 

?>