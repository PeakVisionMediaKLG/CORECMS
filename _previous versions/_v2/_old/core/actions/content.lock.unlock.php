<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
	
$the_author = $USER->USERVALS['uUser'];
$THETIME=time();
	
header("Cache-Control: no-cache");
print_r($_POST);
$cUID = $_POST['data']['contentId'] ?? die('no content id sent');

$current_status = $DB->PREP_QUERY ('SELECT cLockedByAdmin FROM content WHERE cUID=? LIMIT 1', 
                                     'content', 
                                     array('cUID'),
                                     array($cUID), 
                                 @$DB->SETTINGS['mysqlErrorReporting']);
    
$current_status = $current_status->fetch_array();
$current_status = $current_status[0];
    
if($current_status) $new_status=0; else $new_status=1;    
    
    $action = $DB->PREP_QUERY ('UPDATE content SET cLockedByAdmin = ?, cLastEditor = ?, cDate = ? WHERE cUID = ?', 
                                                 'content', 
                                                 array('cActive','cLastEditor','cDate','cUID'),
                                                 array($new_status,$the_author,$THETIME,$cUID), 
                                             @$DB->SETTINGS['mysqlErrorReporting']);
    echo $action;
    
} else {echo "unauthorized access"; exit;}
?>
