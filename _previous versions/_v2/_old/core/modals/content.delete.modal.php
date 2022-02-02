<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');

$data= array();	
$data = $_POST['data'] ?? die('no data sent');
$content_to_delete = $data['cuid'];
$cType_to_delete = $data['ctype'];
$thePage = $data['puid'];	
	
include("../classes/class.page.php");
	$page = new PAGE($DB,$thePage,"");
	
include("../classes/class.content.php");
	$content = new CONTENT($DB,$page,$USER);
	

	
	
$modalcontent="<p>".$content->TXT['Are you sure you want to delete this']." <b>".$cType_to_delete." (".$content_to_delete.")</b> ".$content->TXT['content element and all its subelements?']."</p>";
$modalcontent.="<input type='hidden' id='cUID' name='cUID' value='$content_to_delete'>";

$modal= new MODAL("core-delete-content.".$content_to_delete, //modal id
							$TXT['delete'], //modal title
							$modalcontent, //modal content
							$TXT['cancel'], //cancel caption
							$TXT['delete'], //action caption
							"core/actions/content.delete.php",//action path
							$content_to_delete,//data-attribute
							"core-delete-content-form",//form class	
							"");//modal body class 	
echo $modal->GET_MODAL();	
}
?>