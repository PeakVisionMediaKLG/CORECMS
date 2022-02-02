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

$ContentConfig['custominputs']=array(
    $ContentConfig['txt']['use link (optional)']=>'',
    $ContentConfig['txt']['&lt;img alt=""&gt; attribute']=>'',    
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