<?php
//carousel_slide
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array('text_image','row');

$ContentConfig['cAnimation_possible']=0;
$ContentConfig['cLazyLoad_possible']=0;

$ContentConfig['paths']=array(
	$ContentConfig['txt']['background picture']=>$ContentConfig['txt']['background picture']
);

$ContentConfig['customselects'][0]=array(
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

?>