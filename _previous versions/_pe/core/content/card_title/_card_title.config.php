<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array(); 

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;


$ContentConfig['custominputs']=array(
    $ContentConfig['txt']['main title']=>$ContentConfig['txt']['main title'],
    $ContentConfig['txt']['subtitle']=>$ContentConfig['txt']['subtitle'],    
);
$ContentConfig['customselects'][0]=array(
    1=>$ContentConfig['txt']['use subtitle'],
    0=>$ContentConfig['txt']['no subtitle'],
);

$ContentConfig['customselects'][1]=array(
    'h1'=>$ContentConfig['txt']['main title size: h1 (biggest)'],
    'h2'=>$ContentConfig['txt']['main title size: h2'],
    'h3'=>$ContentConfig['txt']['main title size: h3'],
    'h4'=>$ContentConfig['txt']['main title size: h4'],
    'h5'=>$ContentConfig['txt']['main title size: h5 (smallest)'],    
);

$ContentConfig['customselects'][2]=array(
    'h1'=>$ContentConfig['txt']['subtitle size: h1 (biggest)'],
    'h2'=>$ContentConfig['txt']['subtitle size: h2'],
    'h3'=>$ContentConfig['txt']['subtitle size: h3'],
    'h4'=>$ContentConfig['txt']['subtitle size: h4'],
    'h5'=>$ContentConfig['txt']['subtitle size: h5'],    
    'h6'=>$ContentConfig['txt']['subtitle size: h6 (smallest)'],    
);

/*
-------------------------Tutorial-------------------------
$ContentConfig['attributes'][0]=array(
'mykey'=>'myvalue',
'mykey2'=>'myvalue2',
);

$ContentConfig['customselects'][0]=array(
'mykeycs'=>'myvaluex',
'mykey2cs'=>'myvaluex2',
);


$ContentConfig['custominputs']=array(
'mylabel'=>'myinput'
);


$ContentConfig['paths']=array(
$ContentConfig['txt']['background picture']=>$ContentConfig['txt']['background picture']
);

*/

?>