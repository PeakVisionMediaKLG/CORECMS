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


$modalContent="<p class='row w90 mx-auto'>".TXT['Are you sure you want to restore the database from the following file? Warning: All changes after its creation will be lost.']."</p><br>";

$modalContent.="<div class='row w90 mx-auto'><table class='core-table-std'>";

$fileinfo = basename($data['directory'].$data['file']);
if(strpos($data['file'],'user-')!==false) $createdBy = TXT['user created']; elseif(strpos($data['file'],'core-')!==false) $createdBy = TXT['system created'];

    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['File']."</b></td><td class='p-2'>".$data['file']."</td></tr>";
    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Created by']."</b></td><td class='p-2'>".$createdBy."</td></tr>";    
    $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".TXT['Date']."</b></td><td class='p-2'>".$DB->DUMP_TIMESTAMP($data['file'])."</td></tr>";
    $modalContent.=HIDDEN::PRINT_R(array('name'=>'core_data__file','value'=>$data['file']));
    $modalContent.=HIDDEN::PRINT_R(array('name'=>'core_data__directory','value'=>$data['directory']));    

$modalContent.="</table></div>";

$modal= new MODAL(array(
    'id'=>"core-database-restore-".time(),
    'title'=>TXT['Restore database'],
    'content'=>$modalContent,
    'contentSize'=>'',//modal-xl
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Cancel'],
    'actionLabel'=>TXT['Restore'],
    'actionPath'=>"core/actions/database.restore.php",
    'dataAttributes'=>array('data-timeout'=>'500'), //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>