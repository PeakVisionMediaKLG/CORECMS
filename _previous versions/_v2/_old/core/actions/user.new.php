<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

    header("Cache-Control: no-cache");
    $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
    include('../classes/txt/'.$languagetoload.'.php');
    
    $maxUserID = $DB->SINGLE_ROW("SELECT MAX(uUID) FROM users");
    $maxUserID = $maxUserID[0] +1;
    
    $language = $USER->GET_USERVAL("uLanguage") ?? 'EN';
    
    
    
    $DB->PREP_QUERY ('INSERT INTO users (uUser,uPassword,uFirstName,uLastName,uUserTitle,uEmail,uIdentifier,uToken,uTimeout,uAdmin,uLanguage,uUID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)', 
                         'users', 
                         array('uUser','uPassword','uFirstName','uLastName','uUserTitle','uEmail','uIdentifier','uToken','uTimeout','uAdmin','uLanguage','uUID'), //
                         array('new_user'.time(),md5("this is a new user"),'','','','add email','','',0,0,$language,$maxUserID), 
                         0); //@$DB->SETTINGS['mysqlErrorReporting']
    
    $user_data = $DB->SINGLE_ROW("SELECT * FROM users WHERE uUID = $maxUserID");
    if($user_data['uAdmin']==1) $admin=" checked value='1'"; else $admin=" value='0'"; 
    
$modalcontent="
    <div class='row core-newrow '>
        <div class='col '>
        ".$TXT['user name']."<br>
        <input type='text' class='core-in-place-edit' data-sanitizetype='unique_text' data-table='users' data-object='uUser' data-condition='".$user_data['uUID']."' value='".$user_data['uUser']."'>
        </div>
        <div class='col '>
        ".$TXT['e-mail']."<br>   
        <input type='text' class='core-in-place-edit' data-sanitizetype='email' data-table='users' data-object='uEmail' data-condition='".$user_data['uUID']."' value='".$user_data['uEmail']."'>
        </div>
        <div class='col '>
        ".$TXT['admin']."<br>
        <input class='core-checkbox core-in-place-edit' data-sanitizetype='bool' data-table='users' data-object='uAdmin' data-condition='".$user_data['uUID']."' type='checkbox' $admin>    

        </div>
        <div class='w-100'></div>
        <div class='col '>
        ".$TXT['usertitle']."<br>
        <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uUserTitle' data-condition='".$user_data['uUID']."' value='".$user_data['uUserTitle']."'>
        </div>
        <div class='col '>
        ".$TXT['first name']."<br>    
        <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uFirstName' data-condition='".$user_data['uUID']."' value='".$user_data['uFirstName']."'>
        </div>
        <div class='col '>
        ".$TXT['last name']."<br>   
        <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uLastName' data-condition='".$user_data['uUID']."'value='".$user_data['uLastName']."'>
        </div>
        <div class='w-100'></div>

        <div class='col '>
        <br><button type='button' class='btn btn-dark core-action-notimeout-btn' data-action-path='core/actions/user.reset.password.php' data-uUID='".$user_data['uUID']."' value='reset'>".$TXT['reset password']."</button>

        </div>
        <div class='col '>


        </div>
        <div class='col '><br><button type='button' class='btn btn-primary core-action-btn' data-action-path='core/actions/user.delete.php' data-uUID='".$user_data['uUID']."'>".$TXT['delete user']."</button><br><br></div>
    </div>";
    
echo str_replace(array("\r", "\n"), '', $modalcontent);    
} 
else { echo "unauthorized access"; exit; }
?>