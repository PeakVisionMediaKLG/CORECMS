<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("uLanguage") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');
	
$input = array();	
$input = $_POST['data'] ?? die('no data sent');
	
$possible_languages=$TXT['select language for new page']."<select name='core-page-set-language' class='core-extend form-control' data-action-path='core/modals/page.extend.new.modal.php'><option class=''></option>";

$config_languages = $DB->MULTI_ROW('SELECT * FROM languages');
                
    while($config_language = $config_languages->fetch_array()){    
        //print_r($config_language);
		$possible_languages.="<option value='".$config_language['lLanguageCode']."'>".$config_language['lLanguageName']."</option>";	
	}
$possible_languages.="</select><br><br>";

$modalcontent=$possible_languages;
							
$modal= new MODAL(  "core-new-page-modal", //modal id
                    $TXT['new page'], //modal title
                    $modalcontent, //modal content
                    $TXT['cancel'], //cancel label
                    $TXT['create'], //action label
                    "core/actions/page.insert.php",//action path
                    "",//data-attribute
                    1); //action button disabled 	
    
echo $modal->GET_MODAL();	
	
} else {echo "unauthorized access"; exit;}
?>