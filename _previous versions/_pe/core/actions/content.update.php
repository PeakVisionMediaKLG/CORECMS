<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];
	
print_r($_POST);	

$cUID =	$_POST["cUID"] ?? '';
$cType = $_POST["cType"] ?? '';	
$cAttrId = 	$_POST["cAttrId"] ?? '';
$cAttrClass = 	$_POST["cAttrClass"] ?? '';
$cAttrStyle = 	$_POST["cAttrStyle"] ?? '';
	
$cStaticTemplate = $_POST["cStaticTemplate"] ?? 0;
$cStaticCopyOf = $_POST["cStaticCopyOf"] ?? '-1';	
	
$cLazyLoad = $_POST["cLazyLoad"] ?? 0;
$cAnimation = $_POST["cAnimation"] ?? 0;
	
$THETIME=time();	
	
include("../content/$cType/_$cType.config.php");

$max_cPos_sql="SELECT MAX(cPosition) FROM content";
$max_cPos=$DB->SINGLE_ROW($max_cPos_sql);
$max_cPos=$max_cPos[0]+5;	
	

    
$primary_insertion = $DB->PREP_QUERY ('UPDATE content SET cAttrID=?,cAttrClass=?,cAttrStyle=?,cLazyLoad=?,cStaticTemplate=?,cDate=?,cLastEditor=? WHERE cUID=?', 
                         'content', 
                         array('cAttrID','cAttrClass','cAttrStyle','cLazyLoad','cStaticTemplate','cDate','cLastEditor','cUID'),
                         array($cAttrId,$cAttrClass,$cAttrStyle,$cLazyLoad,$cStaticTemplate,$THETIME,$the_author,$cUID), 
                     @$DB->SETTINGS['mysqlErrorReporting']); 
    

    $counters = array();
    $counters["classes"]=0; 
    $counters["attributes"]=0;
    $counters["paths"]=0;
    $counters["customselects"]=0;
    $counters["custominputs"]=0;
    $counters["ckeditable"]=0;
    $counters["animationdata"]=0;
    
    foreach($_POST as $key => $value )
    {   
        echo $key."\r\n";
        switch ($key)
            {
            case "classes":
                $mytype="class";
                $check_array=1;
            break;
                
            case "attributes":
                $mytype="attribute";
                $check_array=1;                
            break;
                
            case "paths":
                $mytype="path";
                $check_array=1;
            break;
                
            case "customselects":
                $mytype="customselect";
                $check_array=1;
            break;                

            case "custominputs":
                $mytype="custominput";
                $check_array=1;
            break;
                
            case "ckeditable":
                $mytype="ckeditable";
                $check_array=1;
            break;
            
            case "animationdata":
                if($_POST["cAnimation"]==1)
                {
                    $mytype="animationdata";
                    $check_array=1;
                } 
                
            break;
                
            default:
                $check_array=0;
            break;    
            }
        
            if($check_array)
            {
                $supkey=array();
                $supkey=$_POST[$key];
                print_r($supkey);

                    foreach($supkey as $newkey => $value) 
                    {    
                                $secondary_insertion = $DB->PREP_QUERY ('UPDATE contentdata SET cDataContent = ? WHERE (cDataType = ? AND cUID = ? AND cDataEnum = ?)', 
                                     'contentdata', 
                                     array('cDataContent','cDataType','cUID','cDataEnum'),
                                     array($value,$mytype,$cUID,$counters[$key]), 
                                 @$DB->SETTINGS['mysqlErrorReporting']);
                                $counters[$key]++;  
                    }
            }
    }      
 print_r($counters);   

} else {echo "unauthorized access"; exit;}
?>	