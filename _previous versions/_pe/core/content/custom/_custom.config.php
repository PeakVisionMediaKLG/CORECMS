<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array(); //'navbar','language_menu','text_image','carousel','responsive_video','custom_content','background_video','image_aggregator'

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['paths']=array(
	$ContentConfig['txt']['file to include']=>$ContentConfig['txt']['file to include']
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