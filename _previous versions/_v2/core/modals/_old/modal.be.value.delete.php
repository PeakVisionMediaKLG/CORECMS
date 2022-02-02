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

    $modalContent="<p>".TXT['Are you sure you want to delete this dataset?']."</p><br>";

    $getValues = $DB->EASY_QUERY( "SELECT", 
                                            $data['table'],
                                            array('*'),
                                            array(),
                                            array('id'),
                                            array($data['condition']));

    $getValues = $getValues->fetch_array(); 

    $modalContent.="(".$data['table'].")<br><br><div class='row'>";
        foreach($getValues as $key => $value)
        {
            if(!is_numeric($key))  $modalContent.="<div class='col col-auto me-2'>$key: $value </div>";	
        }
    $modalContent.="</div>";
    $modalContent.= HIDDEN::PRINT_R(array('name'=>'table','value'=>$data['table'])).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')).
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition']));

    $modal= new MODAL(array(
        'id'=>"core-delete-general-".time(),
        'title'=>TXT['Delete'],
        'content'=>$modalContent,
        'contentSize'=>'modal-xl',
        'staticModal'=>'',//'data-bs-backdrop="static"',
        'cancelLabel'=>TXT['Cancel'],
        'actionLabel'=>TXT['Delete'],
        'actionPath'=>"core/actions/action.be.general.delete.php",
        'dataAttributes'=>'', //array()
        'actionDisabled'=>'', //'disabled'
        ));

    echo $modal->GET_MODAL();  

?>