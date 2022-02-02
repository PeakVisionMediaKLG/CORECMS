<?php
include_once("../actions/session.check.php");
include_once("../classes/class.sanitizer.php");
$SANI= new SANITIZER();

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');

if($USER->USER_AUTH_OK) {
    $the_editor = $USER->USERVALS['uUser'];	

    header("Cache-Control: no-cache");

    $_POST = $_POST ?? die('no data sent');
    //print_r($_POST);

    if(isset($_POST['pShowInNav'])){$pShowInNav=$_POST['pShowInNav'];}else{$pShowInNav=0;}
    if(isset($_POST['pActive'])){$pActive=$_POST['pActive'];}else{$pActive=0;}
    if(!isset ($_POST['pParent'])) $_POST['pParent']="";    

    

    $query = $DB->PREP_QUERY("UPDATE pages SET pParent = ?,pURL = ?,pLinkText = ?,pTitle = ?,pDescription = ?,pKeywords = ?,pStyle = ?,pShowInNav = ?,pActive = ?,pDate = ?,pLastEditor = ? WHERE pUID= ?",
                   'pages',
                   array('pParent','pURL','pLinkText','pTitle','pDescription','pKeywords','pStyle','pShowInNav','pActive','pDate','pLastEditor','pUID'),
                   array($_POST['pParent'],$SANI->CLEAN($_POST['pURL'],'url'),$_POST['pLinkText'],$_POST['pTitle'],$_POST['pDescription'],$_POST['pKeywords'],$_POST['pStyle'],intval($pShowInNav),intval($pActive),time(),$the_editor,$_POST['pUID']),@$DB->SETTINGS['mysqlErrorReporting']);
    
    $query2 = $DB->PREP_QUERY ("UPDATE pages SET pParent=?,pDate=?,pLastEditor=? WHERE pSharedID=?", 
                         'pages', 
                         array('pParent','pDate','pLastEditor','pSharedID'), //
                         array($_POST['pParent'],time(),$the_editor,$_POST['pSharedID']),@$DB->SETTINGS['mysqlErrorReporting']);
    
    if($query and $query2) $DB->SESSIONDATA->SET_VAL('alert_once_success','edit_page'.time(),$TXT['The following page has been successfully updated:']." <b>".$_POST['pLinkText']."</b>"); else $DB->SESSIONDATA->SET_VAL('alert_once_fail','edit_page'.time(),$TXT['The following page has not been updated:']." <b>".$_POST['pLinkText']."</b>");
    
    
} 
else { echo "unauthorized access"; exit; }
?>