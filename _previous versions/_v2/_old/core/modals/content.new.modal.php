<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	


	
$languagetoload = $USER->GET_USERVAL("uLanguage") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');
include_once('../content/_txt/'.$languagetoload.'.php');	
	
include_once('../classes/class.content.php');
include_once('../classes/class.page.php');
$PAGE = new PAGE($DB,@$_GET['url']);	
$content = new CONTENT($DB,$PAGE,$USER);
	
	
header("Cache-Control: no-cache");


	
$input = array();	
$input = $_POST['data'] ?? die('no data sent');
//print_r($input);	
	
$cType = $input['ctype']; //echo $cType;
$cUID = $input['cuid'];
$cLanguage = $input['planguage'];
$cPageUID = $input['puid'];	
	
include("../../core/content/$cType/_$cType.config.php");

	

$possible_children="";
for($i=0;$i<count($ContentConfig['children']);$i++) { $possible_children.="<option value='".$ContentConfig['children'][$i]."'>".$content_captions[$ContentConfig['children'][$i]]."</option>"; }

    
$modalcontent="<p>".$content->TXT['Please select the content type.']."</p>
						<select name='cType' class='form-control core-extend' data-action-path='core/modals/content.extend.new.modal.php' data-cType='$cType'>
						<option class='empty_newchild'></option>
						".$possible_children."
						</select><br>";
	
$modalcontent.="<input type='hidden' name='cParent' value='$cUID' id='cParent'>
				<input type='hidden' name='cLanguage' value='$cLanguage' id='cLanguage'>
				<input type='hidden' name='cPageUID' value='$cPageUID' id='cPageUID'>";	
							
$modal= new MODAL("core-add-content", //modal id
							$TXT['add content'], //modal title
							$modalcontent, //modal content
							$TXT['cancel'], //cancel caption
							$TXT['insert content'], //action caption
							"core/actions/content.insert.php",//action path
							"",//data-attribute
							"core-new-content-form",//form class	
							"");//modal body class 
    
	
echo $modal->GET_MODAL();	
	
} 
else {echo "unauthorized access"; exit;}
?>