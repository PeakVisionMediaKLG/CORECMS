<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');

include_once(ROOT."/core/classes/class.autoform.php");
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

define('TXT', json_decode(file_get_contents(ROOT."/core/modals/modal.db.dataset.insert/".$USER->PREFERRED_LANGUAGE.".json"), true));

$modalcontent="<p>".TXT['Insert dataset'].":</p><br>";

$modalcontent .= AUTOFORM::GET_FORM($data['table'],$USER->PREFERRED_LANGUAGE);
//echo $modalcontent;

$modal = new CORE\MODAL(array(
    "id"=>"core-edit-dataset.".time(), //modal id
    "title"=>TXT['Insert dataset'], //modal title
    "content"=>$modalcontent, //modal content"cancelLabel"=>TXT['Cancel'], //cancel caption
    "actionLabel"=>TXT['Save'], //action caption
    "actionPath"=>"core/actions/db.dataset.insert.php",//action path
    "dataAttributes"=>array('data-table'=>$data['table']),//data-attribute
));

echo $modal->GET_MODAL();  

?>