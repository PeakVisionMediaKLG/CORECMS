<?php
include_once("../includes/user.auth.php");
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');

    include_once(ROOT."core/classes/class.modal.php");

    include_once(ROOT."core/classes/class.be.php");
    $BE = new BE();
    $BE->DB = $DB;

$coredata = array();
foreach($data as $key => $value)
{
    if(strpos($key,'core_data__')!==false) $coredata[str_replace('core_data__','',$key)] = $value;
}
//print_r($data);

$dataSet = $DB->EASY_QUERY ("SELECT",
                            $coredata['table'], 
                            array('*'),
                            array(),
                            array($coredata['condition']),
                            array($coredata['conditionvalue']),
                            'LIMIT 1');
//print_r($dataSet);

$modalContent="<div class='row w90 mx-auto'><table class='core-table-std'>";

    foreach($dataSet->fetch_array() as $key => $value)
    {
        if(!is_numeric($key)){
            if(is_array($value)) $value = var_export($value,true); 
            $modalContent.="<tr class='core-tablerow-std'><td class='p-2'><b>".$key."</b></td><td class='p-2'>".$value."</td></tr>";
        }    
    }

$modalContent.="</table></div>";


$modal= new CORE\MODAL(array(
    'id'=>"core-dataset-view-".time(),
    'title'=>TXT['View dataset'],
    'content'=>$modalContent,
    'contentSize'=>'modal-xl',
    'staticModal'=>'',//'data-bs-backdrop="static"',
    'cancelLabel'=>TXT['Close'],
    'actionLabel'=>'',
    'actionPath'=>'',
    'dataAttributes'=>NULL, //array()array('table'=>$data['table'],'condition'=>$data['condition'],'conditionvalue'=>$data['conditionvalue'])
    'actionDisabled'=>'', //'disabled'
    ));

echo $modal->GET_MODAL();  

?>