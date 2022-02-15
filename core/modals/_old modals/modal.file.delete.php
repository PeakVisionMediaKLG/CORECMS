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


$modalContent="<p class='row w90 mx-auto'>".TXT['Are you sure you want to delete the following file(s)?']."</p><br>";

//print_r($data);

$modalContent.="<div class='row w90 mx-auto'><table class='core-table-std'>";

    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Directory']."</b></td><td class='p-2'>".$data['directory']."</td></tr>";    
    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['File']."</b></td><td class='p-2'>".$data['file']."</td></tr>";

    $modalContent.=HIDDEN::PRINT_R(array('name'=>'file','value'=>$data['file']));
    $modalContent.=HIDDEN::PRINT_R(array('name'=>'directory','value'=>$data['directory']));    

$modalContent.="</table></div>";

$modal= new MODAL(array(
    'id'=>"core-delete-file-".time(),
    'title'=>TXT['Delete file(s)'],
    'content'=>$modalContent,
    'contentSize'=>'',//modal-xl
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Cancel'],
    'actionLabel'=>TXT['Delete'],
    'actionPath'=>"core/actions/file.delete.php",
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>