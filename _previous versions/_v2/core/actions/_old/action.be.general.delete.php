<?php //delete dataset
include_once("../includes/user.auth.php");
    
    header("Cache-Control: no-cache");
	
	//print_r($_POST);

	$table = $_POST['table'] ?? $_POST['data']['table'] ?? die('no table');
	$condition = $_POST['condition'] ?? $_POST['data']['condition'] ?? die('no condition');
	$conditionValue = $_POST['conditionvalue'] ?? $_POST['data']['conditionvalue'] ?? die('no condition value');

    $data = $_POST['data'] ?? die('no data sent');

	//print_r($data);

	$DB->EASY_QUERY( "DELETE", 
						$table,
						array(),
						array(),
						array($condition),
						array($conditionValue),
						);	

?>