<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 

$ContentConfig['editor_rights']=array('edit');

$ContentConfig['children']=array('container','row');

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['paths']=array(
	$ContentConfig['txt']['choose poster']=>$ContentConfig['txt']['choose poster'],
    $ContentConfig['txt']['First link to video (webm)']=>$ContentConfig['txt']['First link to video (webm)'],
    $ContentConfig['txt']['Second link to video (mp4)']=>$ContentConfig['txt']['Second link to video (mp4)'],
);


$ContentConfig['attributes'][0]=array(
'loop autoplay'=>$ContentConfig['txt']['loop with autoplay'],
'loop'=>$ContentConfig['txt']['loop only'],
'autoplay'=>$ContentConfig['txt']['autoplay only'],
''=>$ContentConfig['txt']['no loop, no autoplay'],
);

$ContentConfig['attributes'][1]=array(
'muted'=>$ContentConfig['txt']['muted'],
''=>$ContentConfig['txt']['with sound'],
);

$ContentConfig['attributes'][2]=array(
''=>$ContentConfig['txt']['no controls'],
'controls'=>$ContentConfig['txt']['with controls'],
);

$ContentConfig['customselects'][0]=array(
    '0'=>$ContentConfig['txt']['no overlay'],
    '0.1'=>$ContentConfig['txt']['10% overlay'],
    '0.2'=>$ContentConfig['txt']['20% overlay'],
    '0.3'=>$ContentConfig['txt']['30% overlay'],
    '0.4'=>$ContentConfig['txt']['40% overlay'],
    '0.5'=>$ContentConfig['txt']['50% overlay'],
    '0.6'=>$ContentConfig['txt']['60% overlay'],
    '0.7'=>$ContentConfig['txt']['70% overlay'],
    '0.8'=>$ContentConfig['txt']['80% overlay'],
    '0.9'=>$ContentConfig['txt']['90% overlay'],
);

$ContentConfig['customselects'][1]=array(
    ''=>'no fixed aspect',
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

$ContentConfig['custominputs']=array(
    $ContentConfig['txt']['Alternative min-height value (instead of 450px)']=>'',    
);


?>