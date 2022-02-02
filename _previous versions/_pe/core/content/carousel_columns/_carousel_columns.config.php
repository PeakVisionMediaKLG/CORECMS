<?php
//carousel_columns
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array('carousel_column_group');

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['customselects'][0]=array(
'1'=>$ContentConfig['txt']['with controls'],
'0'=>$ContentConfig['txt']['without controls'],
);

$ContentConfig['customselects'][1]=array(
'1'=>$ContentConfig['txt']['with indicators'],
'0'=>$ContentConfig['txt']['without indicators'],
);

$ContentConfig['customselects'][2]=array(
'false'=>$ContentConfig['txt']['interval'].': false',    
'1000'=>$ContentConfig['txt']['interval'].' 1000ms',
'2000'=>$ContentConfig['txt']['interval'].' 2000ms',
'3000'=>$ContentConfig['txt']['interval'].' 3000ms',
'4000'=>$ContentConfig['txt']['interval'].' 4000ms',
'5000'=>$ContentConfig['txt']['interval'].' 5000ms',
'7000'=>$ContentConfig['txt']['interval'].' 7000ms',
'10000'=>$ContentConfig['txt']['interval'].' 10000ms',
);

$ContentConfig['customselects'][3]=array(
"'hover'"=>$ContentConfig['txt']['pause on hover'],
''=>$ContentConfig['txt']["don't pause"],
);

$ContentConfig['customselects'][4]=array(
'false'=>$ContentConfig['txt']['automatic autocycle'],
'true'=>$ContentConfig['txt']['start autocycle manually'],
);

$ContentConfig['customselects'][5]=array(
'true'=>$ContentConfig['txt']['continuous autocycle'],
'false'=>$ContentConfig['txt']['stop autocycle at last slide'],
);

$ContentConfig['customselects'][6]=array(
'true'=>$ContentConfig['txt']['keyboard controls enabled'],
'false'=>$ContentConfig['txt']['keyboard controls disabled'],
);

$ContentConfig['customselects'][7]=array(
''=>$ContentConfig['txt']['carousel mode: slide'],
'carousel-fade'=>$ContentConfig['txt']['carousel mode: fade'],
);

$ContentConfig['customselects'][8]=array(
1=>$ContentConfig['txt']['fixed height pictures'],
0=>$ContentConfig['txt']['standard pictures'],
);

$ContentConfig['custominputs']=array(
	$ContentConfig['txt']['fixed height with units']=>'',
    $ContentConfig['txt']['fixed width with units']=>'',
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