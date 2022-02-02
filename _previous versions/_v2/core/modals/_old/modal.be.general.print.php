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


$getValues = $DB->EASY_QUERY( "SELECT", 
										$data['table'],
										array('*'),
										array(),
										array($data['condition']),
										array($data['conditionvalue']),"",0);

$getValues = $getValues->fetch_array(); 

$modalContent="<div class='row w100'><div class='col-12 text-center'><b>".TXT['Database table'].": ".$data['table']."</b><br><br><table class='core-table-std mx-auto text-start'><tr><th>".TXT['Keys']."</th><th>".TXT['Values']."</th></tr>";
	foreach($getValues as $key => $value)
	{
		if(!is_numeric($key))  $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>$key:</b></td><td class='p-2'>$value</td></tr>";	
	}
$modalContent.="</table></div></div>";
$modalContent.=HIDDEN::PRINT_R(array('name'=>'table','value'=>$data['table'])).HIDDEN::PRINT_R(array('name'=>'condition','value'=>$data['condition'])).HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['conditionvalue']));

$modal= new MODAL(array(
    'id'=>"core-general-print-".time(),
    'title'=>TXT['Dataset'],
    'content'=>$modalContent,
    'contentSize'=>'modal-xl',//modal-xl
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Cancel'],
    'actionLabel'=>'',//TXT['Delete'],
    'actionPath'=>'',//"core/actions/action.be.general.delete.php",
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>