<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');

$data= array();	
//$data = $_POST['data'] ?? die('no data sent');
$content_to_save = $_POST['content'] ?? die('no data sent');
$what_to_update = $_POST['id'] ?? die('no data sent');
$thePage = 1;
    
include("../classes/class.page.php");
	$page = new PAGE($DB,$thePage,"");
	
include("../classes/class.content.php");
	$content = new CONTENT($DB,$page,$USER);
	

	
	
$modalcontent="<p>".$content->TXT['Are you sure you want to save your changes?']."</p>";
$modalcontent.="<input type='hidden' id='content' name='content' value='$content_to_save'>";
$modalcontent.="<input type='hidden' id='id' name='id' value='$what_to_update'>";
    
$modal= new MODAL("core-save-content.".$what_to_update, //modal id
							$TXT['save'], //modal title
							$modalcontent, //modal content
							$TXT['cancel'], //cancel caption
							$TXT['save'], //action caption
							"core/actions/ckeditor.update.php",//action path
							$what_to_update,//data-attribute
							"core-save-content-form",//form class	
							"");//modal body class 	
echo $modal->GET_MODAL();	
}
?>