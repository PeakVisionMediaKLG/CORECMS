<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array(); 

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['paths']=array(
	$ContentConfig['txt']['choose picture']=>$ContentConfig['txt']['choose picture'],    
	//$ContentConfig['txt']['overlay picture']=>$ContentConfig['txt']['overlay picture'],
);

$ContentConfig['custominputs']=array(
'&lt;img alt=""&gt; tag'=>''
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