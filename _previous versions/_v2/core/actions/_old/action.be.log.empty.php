<?php //delete dataset
include_once("../includes/user.auth.php");
    
    header("Cache-Control: no-cache");
	
	//print_r($_POST);

    $data = $_POST['data'] ?? die('no data sent');

	//print_r($data);

	$DB->PREPARED_QUERY("TRUNCATE ".$DB->dbPrefix."db_log");	

?>