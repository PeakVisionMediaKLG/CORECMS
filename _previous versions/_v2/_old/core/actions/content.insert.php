<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];
	
print_r($_POST);	

$cPageUID = $_POST["cPageUID"] ?? ''; 
$cLanguage = $_POST["cLanguage"] ?? '';
$cParent = $_POST["cParent"] ?? ''; 
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

$primary_insertion = $DB->PREP_QUERY ('INSERT INTO content (cPageUID, cParent, cLanguage, cType, cAttrId, cAttrClass, cAttrStyle, cPosition, cAnimation, cLazyLoad, cStaticTemplate, cStaticCopyOf, cActive, cDeleted, cDate, cAuthor, cLastEditor) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                        'content', array('cPageUID','cParent','cLanguage','cType','cAttrId','cAttrClass','cAttrStyle','cPosition','cAnimation','cLazyLoad','cStaticTemplate','cStaticCopyOf','cActive','cDeleted','cDate','cAuthor','cLastEditor'),
                         array($cPageUID,$cParent,$cLanguage,$cType,$cAttrId,$cAttrClass,$cAttrStyle,$max_cPos,$cAnimation,$cLazyLoad,$cStaticTemplate,$cStaticCopyOf,1,0,$THETIME,$the_author,$the_author), 
                        @$DB->SETTINGS['mysqlErrorReporting']); // @$DB->SETTINGS['mysqlErrorReporting']  

    
$getCUIDsql="SELECT MAX(cUID) FROM content WHERE cDate='$THETIME'";
echo $getCUIDsql;	
$cUID_result = $DB->SINGLE_ROW($getCUIDsql);
if(@$cUID_result->num_rows === 0) echo 'Error: could not determine content id';	
$cUID=$cUID_result['MAX(cUID)'];

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

                    foreach($supkey as &$value) 
                    {    
                                
                                $secondary_insertion = $DB->PREP_QUERY ('INSERT INTO contentdata (cUID,cDataEnum,cDataType,cDataContent,cDataDeleted) VALUES (?,?,?,?,?)', 
                                     'contentdata', 
                                     array('cUID','cDataEnum','cDataType','cDataContent','cDataDeleted'),
                                     array($cUID,$counters[$key],$mytype,$value,0), 
                                 @$DB->SETTINGS['mysqlErrorReporting']);

                                $counters[$key]++;  
                    }
            }
    }    
 print_r($counters);  
	
} else {echo "unauthorized access"; exit;}
?>	