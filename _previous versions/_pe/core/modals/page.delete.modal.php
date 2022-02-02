<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

    header("Cache-Control: no-cache");
    include_once("../classes/class.modal.php");	

    $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
    include('../classes/txt/'.$languagetoload.'.php');

    $data= array();	
    $data = $_POST['data'] ?? die('no data sent');
    $page_to_delete = $data['puid'] ?? die('no pUID sent');
    $linktext = $data['plinktext'] ?? die('no pLinktext sent');	
    $sharedid = $data['psharedid'] ?? die('no pSharedID sent');
    $pparent = $data['pparent'] ?? die('no pParent sent');	

    $modalcontent="<p>".$TXT['Are you sure you want to delete the following page:']." <b>".$linktext."</b>?</p>";

    //    <div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='core-delete-all-pages-select' name='del-all'><label class='form-check-label' for='core-delete-all-pages-select'>".$TXT['Completely delete page for all language versions?']."</label></div><input type='hidden' name='pUID' value='$page_to_delete'>
    $modalcontent.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='core-delete-all-pages-select' name='del-subs'><label class='form-check-label' for='core-delete-all-pages-select'>".$TXT['Also delete subpages? If left unchecked, all subpages will move up one level.']."</label></div><input type='hidden' name='pSharedID' value='$sharedid'><input type='hidden' name='pParent' value='$pparent'>";	


    $modal= new MODAL("core-delete-page.".$page_to_delete, //modal id
                                $TXT['delete page'], //modal title
                                $modalcontent, //modal content
                                $TXT['cancel'], //cancel caption
                                $TXT['delete'], //action caption
                                "core/actions/page.delete.php",//action path
                                $sharedid,//data-attribute
                                "core-delete-page-form",//form class	
                                "");//modal body class 	
    echo $modal->GET_MODAL();    

} else exit;
?>