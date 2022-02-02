<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];		
$cUID=$_POST['cUID'];

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');   	
	
function deleter($current,$DB,$the_author)
{	

    $contentset = $DB->PREP_QUERY ('SELECT cUID,cParent FROM content WHERE cParent = ?',
                                   'content',
                                   array('cParent'),
                                   array($current),
                                   @$DB->SETTINGS['mysqlErrorReporting']);    

    $contentrow=array();

    while($contentrow=$contentset->fetch_array()){

        $DB->PREP_QUERY ('UPDATE contentdata SET cDataDeleted=1 WHERE cUID = ?', 
                        'contentdata', 
                        array('cUID'), 
                        array($contentrow['cUID']),
                        @$DB->SETTINGS['mysqlErrorReporting']);    
        
        $DB->PREP_QUERY ('UPDATE content SET cDeleted=?,cDate=?,cLastEditor=? WHERE cUID=?', 
                        'content', 
                        array('cDeleted','cDate','cLastEditor','cUID'),
                        array(1,time(),$the_author,$contentrow['cUID']), 
                        @$DB->SETTINGS['mysqlErrorReporting']);


        deleter($contentrow['cUID'],$DB,$the_author);

    }
}


deleter($cUID,$DB,$the_author);	
	
        
        $query=$DB->PREP_QUERY ('UPDATE content SET cDeleted=?,cDate=?,cLastEditor=? WHERE cUID=?', 
                        'content', 
                         array('cDeleted','cDate','cLastEditor','cUID'), //
                         array(1,time(),$the_author,$cUID), 
                        @$DB->SETTINGS['mysqlErrorReporting']);    
        
        
        $query1=$DB->PREP_QUERY ('UPDATE contentdata SET cDataDeleted=1 WHERE cUID =?', 
                         'contentdata', 
                         array('cUID'), 
                         array($cUID),
                        @$DB->SETTINGS['mysqlErrorReporting']);   
    
        if($query) $DB->SESSIONDATA->SET_VAL('alert_once_success','delete_content'.time(),$TXT['The content has been successfully deleted.']); else $DB->SESSIONDATA->SET_VAL('alert_once_fail','delete_content'.time(),$TXT['The content could not be deleted.']);

    
} else {echo "unauthorized access"; exit;}
?>	