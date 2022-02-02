<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
    $the_editor = $USER->USERVALS['uUser'];	

    $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
    include('../classes/txt/'.$languagetoload.'.php');
    
    header("Cache-Control: no-cache");

    $data = $_POST['data'] ?? die('no data sent');
    print_r($data);

    $userID = $data['uuid'] ?? die('no user id sent');
    
    $result = $DB->PREP_QUERY ('SELECT uUser,uPassword,uFirstName,uLastName,uUserTitle,uEmail,uIdentifier,uToken,uTimeout,uAdmin,uLanguage,uUID FROM users WHERE uUID = ?', 
                         'users', 
                         array('uUID'), //
                         array($userID),
                         @$DB->SETTINGS['mysqlErrorReporting']); 
    $result = mysqli_fetch_array($result);
    
    $thekeytosend=md5(implode($result));
    
    $domain = $DB->SETTINGS['domain'];
    $thelink="<a href='$domain/core/admin/admin.reset.password.php.php?key=$thekeytosend'>$domain/core/admin/admin.reset.password.php.php?key=$thekeytosend</a>";
    
    $recipient = $result['uEmail'];
    $subject = $TXT['Your content.riot password has been reset!'];
    $message = "<html>
                <head>
                  <title>".$TXT['Your content.riot password has been reset!']."</title>
                </head>
                <body>".$TXT['Your content.riot password has been reset.<br>Please click on the following link to set your new password.<br><br>'].$thelink."<br><br>content.riot</body></html>";

    $header[] = 'MIME-Version: 1.0';
    $header[] = 'Content-type: text/html; charset=iso-8859-1';

    $header[] = 'To: '.$result['uEmail'].'<'.$result['uEmail'].'>';
    $header[] = 'From: content.riot <webmaster@content.riot.com>';
    
    mail($recipient, $subject, $message, implode("\r\n", $header));
    echo $message;
    echo $domain."/core/admin/admin.reset.password.php?key=".$thekeytosend;
    
} 
else { echo "unauthorized access"; exit; }
?>