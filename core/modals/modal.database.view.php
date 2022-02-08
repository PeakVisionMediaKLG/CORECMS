<?php
include_once("../includes/user.auth.php");
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

include_once(ROOT."core/classes/class.be.php");
$BE = new BE();
$BE->DB = $DB;
$BE->GETBELANGUAGES();
$BE->USER = $USER;
include_once(ROOT."core/classes/class.component.php");


$modalContent="<p class='row w90 mx-auto'>".TXT['Contents of:']." ".$data['file']."</p><br>";

$modalContent.="<div class='row w90 mx-auto'>
                    <div class='col-12 text-wrap'>";

    $modalContent.="<pre>";
    $modalContent.= $DB->DUMP_DECRYPT($data['directory'].$data['file']);    
    $modalContent.="</pre>";

$modalContent.="</div></div>";

$modal= new MODAL(array(
    'id'=>"core-database-view-".time(),
    'title'=>TXT['Restore database'],
    'content'=>$modalContent,
    'contentSize'=>'modal-xl',
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Close'],
    'actionLabel'=>'',
    'actionPath'=>'',
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    'noCleanup'=>1,
    ));

echo $modal->GET_MODAL();  

?>