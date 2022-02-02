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


$modalContent="<p>".TXT['Are you sure you want to delete this backup file?']."</p><br>";


$modalContent.="<div class='row w100'><div class='col-12 text-center'><b>".TXT['Backup'].": </b><br><br><table class='core-table-std mx-auto text-start'>";

    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Filename']."</b></td><td class='p-2'>".$data['dump']."</td></tr>";
    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Date']."</b></td><td class='p-2'>".date('d/M/Y H:i:s',explode("-",$data['dump'])[3])."</td></tr>";
    if(strpos($fileinfo->getFilename(),'user-')!==false) $createdBy= TXT['user created']; else $createdBy=  TXT['system created'];	
    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Created by']."</b></td><td class='p-2'>".$createdBy."</td></tr>";		
    $modalContent.=HIDDEN::PRINT_R(array('name'=>'file','value'=>$data['dump']));
    $modalContent.=HIDDEN::PRINT_R(array('name'=>'directory','value'=>ROOT."backups/"));    

$modalContent.="</table></div></div>";
/*$modalContent.=HIDDEN::PRINT_R(array('name'=>'table','value'=>$data['table'])).HIDDEN::PRINT_R(array('name'=>'condition','value'=>$data['condition'])).HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['conditionvalue']));*/

$modal= new MODAL(array(
    'id'=>"core-delete-dump-".time(),
    'title'=>TXT['Delete'],
    'content'=>$modalContent,
    'contentSize'=>'',//modal-xl
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Cancel'],
    'actionLabel'=>TXT['Delete'],
    'actionPath'=>"core/actions/action.be.file.delete.php",
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>