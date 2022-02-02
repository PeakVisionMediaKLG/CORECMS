<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 

$ContentConfig['editor_rights']=array('edit');

$ContentConfig['children']=array();

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['paths']=array(
	$ContentConfig['txt']['choose picture']=>$ContentConfig['txt']['choose picture'],    
	//$ContentConfig['txt']['overlay picture']=>$ContentConfig['txt']['overlay picture'],
);

$ContentConfig['customselects'][0]=array(
    '56.25'=>'aspect 16:9',
    '62.50'=>'aspect 16:10',
    '75'=>'aspect 4:3',
    '100'=>'aspect 1:1',
    '133.33'=>'aspect 3:4',
    '160'=>'aspect 10:16',
    '177.77'=>'aspect 9:16',
    
    '50'=>'aspect 2:1',
    '33'=>'aspect 3:1',    
    '25'=>'aspect 4:1', 
    '200'=>'aspect 1:2',
    '300'=>'aspect 1:3',    
    '400'=>'aspect 1:4',    
);

$ContentConfig['customselects'][1]=array(
'center'=>$ContentConfig['txt']['image position: center'],
'top center'=>$ContentConfig['txt']['top center'],
'bottom center'=>$ContentConfig['txt']['bottom center'],
'top left'=>$ContentConfig['txt']['top left'],
'top right'=>$ContentConfig['txt']['top right'],
'bottom left'=>$ContentConfig['txt']['bottom left'],
'bottom right'=>$ContentConfig['txt']['bottom right'],    
'left'=>$ContentConfig['txt']['left'],
'right'=>$ContentConfig['txt']['right'],
);

$ContentConfig['custominputs']=array(
    $ContentConfig['txt']['use link (optional)']=>'',
);


/*
-------------------------Tutorial-------------------------
$content_data['column']['attributes'][0]=array(
'mykey'=>'myvalue',
'mykey2'=>'myvalue2',
);

$content_data['column']['customselects'][0]=array(
'mykeycs'=>'myvaluex',
'mykey2cs'=>'myvaluex2',
);


$content_data['column']['custominputs']=array(
'mylabel'=>'myinput'
);


$content_data['column']['paths']=array(
$content_data['column']['txt']['background picture']=>$content_data['column']['txt']['background picture']
);

*/

?>