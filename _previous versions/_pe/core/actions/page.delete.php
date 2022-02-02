<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

$myvars['the_editor'] = $USER->USERVALS['uUser'];	
$myvars['sharedid'] = $_POST['pSharedID'] ?? die('no pSharedID sent');
$myvars['pparent'] = $_POST['pParent'] ?? die('no pParent sent');
$myvars['del_subs'] = $_POST['del-subs'] ?? 0;

include_once('../classes/class.page.php');    
$PAGE = new PAGE($DB,@$_POST['url']);	


$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');    
    
switch($myvars['del_subs'])
    {
        case 1:
             $query=$DB->PREP_QUERY ('UPDATE pages SET pDeleted=?, pActive=?,pDate=?,pLastEditor=? WHERE pSharedID=?', 
                'pages', 
                array('pDeleted','pActive','pDate','pLastEditor','pSharedID'), //
                array(1,0,time(),$myvars['the_editor'],$myvars['sharedid']), 
                @$DB->SETTINGS['mysqlErrorReporting']);
             recursive_deleter($myvars['sharedid'],$PAGE,$DB,$myvars);
             echo $query;
            if($query) $DB->SESSIONDATA->SET_VAL('alert_once_success','delete_page'.time(),$TXT['The page has been successfully deleted.']); else $DB->SESSIONDATA->SET_VAL('alert_once_fail','delete_page'.time(),$TXT['The page could not be deleted.']);
            
        break;    

        default:
             $query=$DB->PREP_QUERY ('UPDATE pages SET pDeleted=?,pActive=?,pDate=?,pLastEditor=? WHERE pSharedID=?', 
                'pages', 
                array('pDeleted','pActive','pDate','pLastEditor','pSharedID'), //
                array(1,0,time(),$myvars['the_editor'],$myvars['sharedid']), 
                @$DB->SETTINGS['mysqlErrorReporting']);

             echo $query;
 
                    $nextparent = $DB->PREP_QUERY('SELECT pParent FROM pages WHERE pSharedID=? LIMIT 1', 
                            'pages', 
                            array('pSharedID'), 
                            array($myvars['pparent']), 
                            @$DB->SETTINGS['mysqlErrorReporting']);
                    $nextparent=$nextparent->fetch_array();
                    //print_r($child);
        
                    $nextparentresult = $DB->PREP_QUERY('UPDATE pages SET pParent=?, pDate=? ,pLastEditor=? WHERE pParent=?', 
                            'pages', 
                            array('pParent','pDate','pLastEditor','pParent'), 
                            array($nextparent[0],time(),$myvars['the_editor'],$myvars['sharedid']), //$myvars['sharedid']
                            @$DB->SETTINGS['mysqlErrorReporting']);
        
             if($query) $DB->SESSIONDATA->SET_VAL('alert_once_success','delete_page'.time(),$TXT['The page has been successfully deleted.']); else $DB->SESSIONDATA->SET_VAL('alert_once_fail','delete_page'.time(),$TXT['The page could not be deleted.']);
        
        break;    
    }

} else {echo "unauthorized access"; exit;}



function recursive_deleter ($parent,$PAGE,$DB,$myvars)
    {
        for($i=0;$i<count($PAGE->ALL_PAGES_ARRAY);$i++)
            {
                if($PAGE->ALL_PAGES_ARRAY[$i]['pParent']==$parent){

                        $DB->PREP_QUERY ('UPDATE pages SET pDeleted=?, pActive=?, pDate=?, pLastEditor=? WHERE pParent=?', 
                                'pages', 
                                array('pDeleted','pActive','pDate','pLastEditor','pParent'), 
                                array(1,0,time(),$myvars['the_editor'],$parent), 
                                @$DB->SETTINGS['mysqlErrorReporting']);                    
                        recursive_deleter ($PAGE->ALL_PAGES_ARRAY[$i]['pSharedID'],$PAGE,$DB,$myvars);
                }
            }
    }
?>