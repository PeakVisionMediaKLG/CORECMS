<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

    header("Cache-Control: no-cache");
    include_once("../classes/class.modal.php");	

    $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
    include('../classes/txt/'.$languagetoload.'.php');

    $data= array();	
    $data = $_POST['data'] ?? die('no data sent');
    

    $modalcontent="<p>".$TXT['Are you sure you want to delete the following language:']." <b>".$data['llanguagename']."</b>?</p>";

    $modalcontent.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='core-delete-all-from-language' name='del-all-from-lang'><label class='form-check-label' for='core-delete-all-pages-select'>".$TXT['Permanently delete all content and pages for this language?']."</label></div><input type='hidden' name='lUID' value='".$data['luid']."'><input type='hidden' name='lLanguageCode' value='".$data['llanguagecode']."'>";	


    $modal= new MODAL("core-delete-language.".$data['luid'], //modal id
                                $TXT['delete language'], //modal title
                                $modalcontent, //modal content
                                $TXT['cancel'], //cancel caption
                                $TXT['delete'], //action caption
                                "core/actions/language.delete.php",//action path
                                $data['luid'],//data-attribute
                                "core-delete-language-form",//form class	
                                "");//modal body class 	
    echo $modal->GET_MODAL();    

} else exit;
?>