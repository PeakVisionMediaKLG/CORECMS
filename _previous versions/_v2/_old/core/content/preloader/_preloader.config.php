<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 

$ContentConfig['children']=array('custom_content'); 

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['custominputs']=array(
    'background color'=>'',
    'optional heading'=>'',
);

$ContentConfig['customselects'][0]=array(
    ''=>'no heading',
    'h1'=>'heading size h1',
    'h2'=>'heading size h2',
    'h3'=>'heading size h3',
    'h4'=>'heading size h4',
);

$ContentConfig['customselects'][1]=array(
    'bootstrap spinner'=>'bootstrap spinner',
    'spinner 2'=>'spinner type 2',
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