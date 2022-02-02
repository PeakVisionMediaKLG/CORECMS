<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array('card_title','text_image','button','container','fixed_aspect_image','image','carousel'); 

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;


$ContentConfig['classes'][0]=array(
	''=>$ContentConfig['txt']['no text align'],
	'text-center'=>$ContentConfig['txt']['centered text'],
	'text-left'=>$ContentConfig['txt']['align text left'],
	'text-right'=>$ContentConfig['txt']['align text right'],
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