<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
	
print_r($_POST);
if (isset($_POST["content"])) $content = $_POST["content"]; else exit;
if (isset($_POST["id"])) $id=$_POST["id"]; else exit;


$sql="UPDATE contentdata SET cDataContent=? WHERE cDataUID=?";
echo $sql;

$result = $DB->PREP_QUERY($sql,'contentdata',array('cDataContent','cDataUID'),array($content,$id),@$DB->SETTINGS['mysqlErrorReporting']);
echo $result;

} else {echo "unauthorized access"; exit;}
?>