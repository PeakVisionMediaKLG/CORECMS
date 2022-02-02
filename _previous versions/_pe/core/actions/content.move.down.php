<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
	
    $the_author = $USER->USERVALS['uUser'];
    $THETIME=time();

    header("Cache-Control: no-cache");

    $cUID = $_POST['data']['cuid'];
    $cParent = $_POST['data']['cparent'];
    $cPosition = $_POST['data']['cposition'];
    $cPageUID = $_POST['data']['cpageuid'];    
    print_r($_POST['data']);    
                                                                                        
    $counterpart_cPosition = $DB->PREP_QUERY ('SELECT cPosition, cUID FROM content WHERE (cParent=? AND cPageUID=? AND cDeleted=0) ORDER BY cPosition ASC', 
                                         'content', 
                                         array('cParent','cPageUID'),
                                         array($cParent,$cPageUID), 
                                     1);
    $i=0; $equals= array();
    while($samelevel = $counterpart_cPosition->fetch_array()) 
    {
        print_r($samelevel);
        $equals[$i]['cPosition']=$samelevel['cPosition'];
        $equals[$i]['cUID']=$samelevel['cUID'];    
        $i++;   
    }

    for($i=0;$i<count($equals);$i++)
    {
        if($cUID==$equals[$i]['cUID']){

            $first_action = $DB->PREP_QUERY ('UPDATE content SET cPosition = ? WHERE cUID = ?', 
                                                 'content', 
                                                 array('cPosition','cUID'),
                                                 array('-99999',$cUID), 
                                             1);
            
            $second_action = $DB->PREP_QUERY ('UPDATE content SET cPosition = ? WHERE cUID = ?', 
                                                 'content', 
                                                 array('cPosition','cUID'),
                                                 array($equals[$i]['cPosition'],$equals[$i+1]['cUID']), 
                                             1);
            
            $third_action = $DB->PREP_QUERY ('UPDATE content SET cPosition = ? WHERE cUID = ?', 
                                                 'content', 
                                                 array('cPosition','cUID'),
                                                 array($equals[$i+1]['cPosition'],$cUID), 
                                             1);            
            
        }
    }     
 
} else {echo "unauthorized access"; exit;}    

?>