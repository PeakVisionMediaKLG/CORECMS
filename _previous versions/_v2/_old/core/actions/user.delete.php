<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
   
    header("Cache-Control: no-cache");
    
    $uid = $_POST['data']['uuid'] ?? die('no user id sent');
    if ($uid<>1){
        $deluser = $DB->PREP_QUERY("DELETE FROM users WHERE uUID = ? LIMIT 1","users",array('uUID'),array($uid),@$DB->SETTINGS['mysqlErrorReporting']);
        echo $deluser;
    }
    
} 
else { echo "unauthorized access"; exit; }
?>