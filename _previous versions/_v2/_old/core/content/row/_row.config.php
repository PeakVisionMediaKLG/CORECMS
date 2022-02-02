<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array('column','column_bgswitcher','column_fixed_aspect');

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['classes'][0]=array(
	'no-gutters'=>$ContentConfig['txt']['margin-free layout'],
	''=>$ContentConfig['txt']['use bootstrap gutter']	
);

$ContentConfig['classes'][1]=array(
	''=>$ContentConfig['txt']['no alignment options'],
	'justify-content-start'=>$ContentConfig['txt']['left'],
	'justify-content-center'=>$ContentConfig['txt']['center'],
	'justify-content-end'=>$ContentConfig['txt']['right'],
	'justify-content-around'=>$ContentConfig['txt']['around'],
	'justify-content-between'=>$ContentConfig['txt']['between'],
);

$ContentConfig['classes'][2]=array(
	''=>$ContentConfig['txt']['no vertical alignment options'],
	'align-items-start'=>$ContentConfig['txt']['top'],
	'align-items-center'=>$ContentConfig['txt']['center'],
	'align-items-end'=>$ContentConfig['txt']['bottom'],
);

$ContentConfig['classes'][3]=array(
    ''=>$ContentConfig['txt']['Extra small (<576px) - visible'],
    'd-none d-sm-block'=>$ContentConfig['txt']['Extra small (<576px) - row hidden on this device'],
	'd-none'=>$ContentConfig['txt']['Extra small (<576px) - row hidden on this device and upwards'],
);

$ContentConfig['classes'][4]=array(
    ''=>$ContentConfig['txt']['Small (>576px) - visible'],
	'd-block d-sm-none d-md-block'=>$ContentConfig['txt']['Small (>576px) - row hidden on this device'],
	'd-sm-none'=>$ContentConfig['txt']['Small (>576px) - row hidden on this device and upwards'],
	'd-none d-md-block'=>$ContentConfig['txt']['Small (>576px) - row hidden on this device and downwards'],	
);

$ContentConfig['classes'][5]=array(
    ''=>$ContentConfig['txt']['Medium (>768px) - visible'],
	'd-block d-md-none d-lg-block'=>$ContentConfig['txt']['Medium (>768px) - row hidden on this device'],
	'd-md-none'=>$ContentConfig['txt']['Medium (>768px) - row hidden on this device and upwards'],
	'd-none d-lg-block'=>$ContentConfig['txt']['Medium (>768px) - row hidden on this device and downwards'],
);

$ContentConfig['classes'][6]=array(
    ''=>$ContentConfig['txt']['Large (>992px) - visible'],
	'd-block d-lg-none d-xl-block'=>$ContentConfig['txt']['Large (>992px) - row hidden on this device'],
	'd-lg-none'=>$ContentConfig['txt']['Large (>992px) - row hidden on this device and upwards'],
	'd-none d-xl-block'=>$ContentConfig['txt']['Large (>992px) - row hidden on this device and downwards'],
);

$ContentConfig['classes'][7]=array(
    ''=>$ContentConfig['txt']['Extra large (>1200px) - visible'],
	'd-block d-xl-none'=>$ContentConfig['txt']['Extra large (>1200px) - row hidden on this device'],
);

$ContentConfig['paths']=array(
$ContentConfig['txt']['background picture']=>$ContentConfig['txt']['background picture']
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