<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];
	
header("Cache-Control: no-cache");

$data=$_POST['data'];    
print_r($data);

if($_SESSION['current_mode']=="branch_cut")
{    
$original_cUID = $_SESSION['cut_content_id']; 
$new_parent = $data['contentId'];
$new_page = $data['pageId']; 
$new_language = $data['pageLanguage'];


$original_data=$DB->PREP_QUERY ('UPDATE content SET cParent=? WHERE cPageUID=? AND cUID=? LIMIT 1', 
                                'content', 
                                array('cParent','cPageUID','cUID'),
                                array($new_parent,$new_page,$original_cUID), 
                                @$DB->SETTINGS['mysqlErrorReporting']);
    
unset($_SESSION['copied_content_id']);
unset($_SESSION['cut_content_id']);
unset($_SESSION['current_mode']);
unset($_SESSION['element_type']);
    
}
 } else {echo "unauthorized access"; exit;}   