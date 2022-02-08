<?php
include_once("../includes/user.auth.php");
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');
    //print_r($data);
    include_once(ROOT."core/classes/class.modal.php");

    include_once(ROOT."core/classes/class.be.php");
    $BE = new BE();
    $BE->DB = $DB;
    $BE->GETBELANGUAGES();
    $BE->USER = $USER;
    include_once(ROOT."core/classes/class.component.php");

$modalContent="<p>".TXT['Are you sure you want to delete this dataset?']."</p><br>";

$getValues = $DB->EASY_QUERY( "SELECT", 
										$data['table'],
										array('*'),
										array(),
										array($data['condition']),
										array($data['conditionvalue']));

$getValues = $getValues->fetch_array(); 

$modalContent.="<div class='row w100'><div class='col-12 text-center'><b>".TXT['Database table'].": ".$data['table']."</b><br><br><table class='core-table-std mx-auto text-start'><tr><th>".TXT['Keys']."</th><th>".TXT['Values']."</th></tr>";
	foreach($getValues as $key => $value)
	{
		if(!is_numeric($key))  $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>$key:</b></td><td class='p-2'>$value</td></tr>";	
	}
$modalContent.="</table></div></div>";
$modalContent.=HIDDEN::PRINT_R(array('name'=>'coredata_table','value'=>$data['table'])).HIDDEN::PRINT_R(array('name'=>'coredata_condition','value'=>$data['condition'])).HIDDEN::PRINT_R(array('name'=>'coredata_conditionvalue','value'=>$data['conditionvalue']));

$modal= new MODAL(array(
    'id'=>"core-delete-general-".time(),
    'title'=>TXT['Delete'],
    'content'=>$modalContent,
    'contentSize'=>'modal-lg',//
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Cancel'],
    'actionLabel'=>TXT['Delete'],
    'actionPath'=>"core/actions/dataset.delete.php",
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>