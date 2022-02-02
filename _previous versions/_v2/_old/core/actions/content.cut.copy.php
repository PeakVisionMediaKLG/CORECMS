<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
print_r($_POST);
//$mode = $_POST['mode'] ?? '';
$mode = $_POST['data']['mode'] ?? 'error';    
$data = $_POST['data'] ?? 'error';
   
switch ($mode)
{
    case "branch_copied":
        $_SESSION['copied_content_id']=$data['contentId'];
        unset($_SESSION['cut_content_id']); 
        $_SESSION['current_mode']="branch_copied";
        $_SESSION['element_type']=$data['contentType'];
    break;
    
    case "branch_cut": 
        $_SESSION['cut_content_id']=$data['contentId'];
        unset($_SESSION['copied_content_id']); 
        $_SESSION['current_mode']="branch_cut";
        $_SESSION['element_type']=$data['contentType'];
    break;
        
    case 'remove': default: 
        unset($_SESSION['copied_content_id']);
        unset($_SESSION['cut_content_id']);
        unset($_SESSION['current_mode']);
        unset($_SESSION['element_type']);
    break;    
        
}    

/*    
if($mode!="remove")
    {   
        
    $_SESSION['copied_content_id']=$data['contentId']; 
    $_SESSION['current_mode']="branch_copied";
    $_SESSION['element_type']=$data['contentType'];

    } 
else 
    {
    unset($_SESSION['copied_content']); 
    unset($_SESSION['current_mode']);
    unset($_SESSION['element_type']);
	}*/

} else {echo "unauthorized access"; exit;}
?>