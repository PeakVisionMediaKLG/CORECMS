<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 

$ContentConfig['editor_rights']=array('edit');

$ContentConfig['children']=array('column','column_fixed_aspect','column_bgswitcher');

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['customselects'][0]=array(
    '100'=>'aspect 1:1',
    '56.25'=>'aspect 16:9',
    '62.50'=>'aspect 16:10',
    '75'=>'aspect 4:3',
    '133.33'=>'aspect 3:4',
    '160'=>'aspect 10:16',
    '177.77'=>'aspect 9:16',
);

$ContentConfig['classes'][0]=array(
	'no-gutters'=>'margin-free layout',
	''=>'use bootstrap gutter',	
);

$ContentConfig['custominputs']=array(
    $ContentConfig['txt']['facebook page id']=>'',
    $ContentConfig['txt']['facebook access token']=>'',   
    
    $ContentConfig['txt']['number of rows on xl viewport']=>'',   
    $ContentConfig['txt']['number of rows on lg viewport']=>'',
    $ContentConfig['txt']['number of rows on md viewport']=>'',
    $ContentConfig['txt']['number of rows on sm viewport']=>'',
    $ContentConfig['txt']['number of rows on xs viewport']=>'',
    
    $ContentConfig['txt']['facebook background color 1']=>'',
    $ContentConfig['txt']['facebook background color 2']=>'',    

);

$ContentConfig['customselects'][1]=array(
    '12'=>$ContentConfig['txt']['12 tiles per row on xl viewport'],
    '6'=>$ContentConfig['txt']['6 tiles per row on xl viewport'],
    '4'=>$ContentConfig['txt']['4 tiles per row on xl viewport'],
    '3'=>$ContentConfig['txt']['3 tiles per row on xl viewport'],    
    '2'=>$ContentConfig['txt']['2 tiles per row on xl viewport'],
    '1'=>$ContentConfig['txt']['1 tile per row on xl viewport'],    
);


$ContentConfig['customselects'][2]=array(
    '12'=>$ContentConfig['txt']['12 tiles per row on lg viewport'],
    '6'=>$ContentConfig['txt']['6 tiles per row on lg viewport'],
    '4'=>$ContentConfig['txt']['4 tiles per row on lg viewport'],
    '3'=>$ContentConfig['txt']['3 tiles per row on lg viewport'],     
    '2'=>$ContentConfig['txt']['2 tiles per row on lg viewport'],
    '1'=>$ContentConfig['txt']['1 tile per row on lg viewport'],    
);


$ContentConfig['customselects'][3]=array(
    '6'=>$ContentConfig['txt']['6 tiles per row on md viewport'],
    '4'=>$ContentConfig['txt']['4 tiles per row on md viewport'],
    '3'=>$ContentConfig['txt']['3 tiles per row on md viewport'],     
    '2'=>$ContentConfig['txt']['2 tiles per row on md viewport'],
    '1'=>$ContentConfig['txt']['1 tile per row on md viewport'],    
);


$ContentConfig['customselects'][4]=array(
    '4'=>$ContentConfig['txt']['4 tiles per row on sm viewport'],
    '3'=>$ContentConfig['txt']['3 tiles per row on sm viewport'],    
    '2'=>$ContentConfig['txt']['2 tiles per row on sm viewport'],
    '1'=>$ContentConfig['txt']['1 tile per row on sm viewport'],    
);


$ContentConfig['customselects'][5]=array(
    '4'=>$ContentConfig['txt']['4 tiles per row on xs viewport'],
    '3'=>$ContentConfig['txt']['3 tiles per row on xs viewport'],    
    '2'=>$ContentConfig['txt']['2 tiles per row on xs viewport'],
    '1'=>$ContentConfig['txt']['1 tile per row on xs viewport'],    
);

?>