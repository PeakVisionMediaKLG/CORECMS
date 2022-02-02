<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 


$ContentConfig['children']=array('container','row','text_image','fixed_aspect_image','image','carousel','button','facebook_wall','background_video','custom'); //'navbar','language_menu','text_image','carousel','responsive_video','custom_content','background_video','image_aggregator'

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['classes'][0]=array(
	'col'=>$ContentConfig['txt']['just a flexbox column'],
	''=>$ContentConfig['txt']['Extra small (<576px) - no style selected'],
	'col-1'=>$ContentConfig['txt']['Extra small (<576px) - column width: 1/12'],
	'col-2'=>$ContentConfig['txt']['Extra small (<576px) - column width: one sixth'],
	'col-3'=>$ContentConfig['txt']['Extra small (<576px) - column width: one fourth'],
	'col-4'=>$ContentConfig['txt']['Extra small (<576px) - column width: one third'],
	'col-5'=>$ContentConfig['txt']['Extra small (<576px) - column width: 5/12'],
	'col-6'=>$ContentConfig['txt']['Extra small (<576px) - column width: half'],
	'col-7'=>$ContentConfig['txt']['Extra small (<576px) - column width: 7/12'],
	'col-8'=>$ContentConfig['txt']['Extra small (<576px) - column width: two thirds'],
	'col-9'=>$ContentConfig['txt']['Extra small (<576px) - column width: three fourths'],
	'col-10'=>$ContentConfig['txt']['Extra small (<576px) - column width: five sixths'],
	'col-11'=>$ContentConfig['txt']['Extra small (<576px) - column width: 11/12'],
	'col-12'=>$ContentConfig['txt']['Extra small (<576px) - column width: full width'],
	'd-none d-sm-block'=>$ContentConfig['txt']['Extra small (<576px) - column hidden on this device'],
	'd-none'=>$ContentConfig['txt']['Extra small (<576px) - column hidden on this device and upwards'],	
);

$ContentConfig['classes'][1]=array(
	''=>$ContentConfig['txt']['Small (>576px) - no style selected'],
	'col-sm'=>$ContentConfig['txt']['Small (>576px) - flexbox column'],
	'col-sm-1'=>$ContentConfig['txt']['Small (>576px) - column width: 1/12'],
	'col-sm-2'=>$ContentConfig['txt']['Small (>576px) - column width: one sixth'],
	'col-sm-3'=>$ContentConfig['txt']['Small (>576px) - column width: one fourth'],
	'col-sm-4'=>$ContentConfig['txt']['Small (>576px) - column width: one third'],
	'col-sm-5'=>$ContentConfig['txt']['Small (>576px) - column width: 5/12'],
	'col-sm-6'=>$ContentConfig['txt']['Small (>576px) - column width: half'],
	'col-sm-7'=>$ContentConfig['txt']['Small (>576px) - column width: 7/12'],
	'col-sm-8'=>$ContentConfig['txt']['Small (>576px) - column width: two thirds'],
	'col-sm-9'=>$ContentConfig['txt']['Small (>576px) - column width: three fourths'],
	'col-sm-10'=>$ContentConfig['txt']['Small (>576px) - column width: five sixths'],
	'col-sm-11'=>$ContentConfig['txt']['Small (>576px) - column width: 11/12'],
	'col-sm-12'=>$ContentConfig['txt']['Small (>576px) - column width: full width'],
	'd-block d-sm-none d-md-block'=>$ContentConfig['txt']['Small (>576px) - column hidden on this device'],
	'd-sm-none'=>$ContentConfig['txt']['Small (>576px) - column hidden on this device and upwards'],
	'd-none d-md-block'=>$ContentConfig['txt']['Small (>576px) - column hidden on this device and downwards'],	
);

$ContentConfig['classes'][2]=array(
	''=>$ContentConfig['txt']['Medium (>768px) - no style selected'],
	'col-md'=>$ContentConfig['txt']['Medium (>768px) - flexbox column'],
	'col-md-1'=>$ContentConfig['txt']['Medium (>768px) - column width: 1/12'],
	'col-md-2'=>$ContentConfig['txt']['Medium (>768px) - column width: one sixth'],
	'col-md-3'=>$ContentConfig['txt']['Medium (>768px) - column width: one fourth'],
	'col-md-4'=>$ContentConfig['txt']['Medium (>768px) - column width: one third'],
	'col-md-5'=>$ContentConfig['txt']['Medium (>768px) - column width: 5/12'],
	'col-md-6'=>$ContentConfig['txt']['Medium (>768px) - column width: half'],
	'col-md-7'=>$ContentConfig['txt']['Medium (>768px) - column width: 7/12'],
	'col-md-8'=>$ContentConfig['txt']['Medium (>768px) - column width: two thirds'],
	'col-md-9'=>$ContentConfig['txt']['Medium (>768px) - column width: three fourths'],
	'col-md-10'=>$ContentConfig['txt']['Medium (>768px) - column width: five sixths'],
	'col-md-11'=>$ContentConfig['txt']['Medium (>768px) - column width: 11/12'],
	'col-md-12'=>$ContentConfig['txt']['Medium (>768px) - column width: full width'],
	'd-block d-md-none d-lg-block'=>$ContentConfig['txt']['Medium (>768px) - column hidden on this device'],
	'd-md-none'=>$ContentConfig['txt']['Medium (>768px) - column hidden on this device and upwards'],
	'd-none d-lg-block'=>$ContentConfig['txt']['Medium (>768px) - column hidden on this device and downwards'],
);

$ContentConfig['classes'][3]=array(
	''=>$ContentConfig['txt']['Large (>992px) - no style selected'],
	'col-lg'=>$ContentConfig['txt']['Large (>992px) - flexbox column'],
	'col-lg-1'=>$ContentConfig['txt']['Large (>992px) - column width: 1/12'],
	'col-lg-2'=>$ContentConfig['txt']['Large (>992px) - column width: one sixth'],
	'col-lg-3'=>$ContentConfig['txt']['Large (>992px) - column width: one fourth'],
	'col-lg-4'=>$ContentConfig['txt']['Large (>992px) - column width: one third'],
	'col-lg-5'=>$ContentConfig['txt']['Large (>992px) - column width: 5/12'],
	'col-lg-6'=>$ContentConfig['txt']['Large (>992px) - column width: half'],
	'col-lg-7'=>$ContentConfig['txt']['Large (>992px) - column width: 7/12'],
	'col-lg-8'=>$ContentConfig['txt']['Large (>992px) - column width: two thirds'],
	'col-lg-9'=>$ContentConfig['txt']['Large (>992px) - column width: three fourths'],
	'col-lg-10'=>$ContentConfig['txt']['Large (>992px) - column width: five sixths'],
	'col-lg-11'=>$ContentConfig['txt']['Large (>992px) - column width: 11/12'],
	'col-lg-12'=>$ContentConfig['txt']['Large (>992px) - column width: full width'],
	'd-block d-lg-none d-xl-block'=>$ContentConfig['txt']['Large (>992px) - column hidden on this device'],
	'd-lg-none'=>$ContentConfig['txt']['Large (>992px) - column hidden on this device and upwards'],
	'd-none d-xl-block'=>$ContentConfig['txt']['Large (>992px) - column hidden on this device and downwards'],
);

$ContentConfig['classes'][4]=array(
	''=>$ContentConfig['txt']['Extra large (>1200px) - no style selected'],
	'col-xl'=>$ContentConfig['txt']['Extra large (>1200px) - flexbox column'],
	'col-xl-1'=>$ContentConfig['txt']['Extra large (>1200px) - column width: 1/12'],
	'col-xl-2'=>$ContentConfig['txt']['Extra large (>1200px) - column width: one sixth'],
	'col-xl-3'=>$ContentConfig['txt']['Extra large (>1200px) - column width: one fourth'],
	'col-xl-4'=>$ContentConfig['txt']['Extra large (>1200px) - column width: one third'],
	'col-xl-5'=>$ContentConfig['txt']['Extra large (>1200px) - column width: 5/12'],
	'col-xl-6'=>$ContentConfig['txt']['Extra large (>1200px) - column width: half'],
	'col-xl-7'=>$ContentConfig['txt']['Extra large (>1200px) - column width: 7/12'],
	'col-xl-8'=>$ContentConfig['txt']['Extra large (>1200px) - column width: two thirds'],
	'col-xl-9'=>$ContentConfig['txt']['Extra large (>1200px) - column width: three fourths'],
	'col-xl-10'=>$ContentConfig['txt']['Extra large (>1200px) - column width: five sixths'],
	'col-xl-11'=>$ContentConfig['txt']['Extra large (>1200px) - column width: 11/12'],
	'col-xl-12'=>$ContentConfig['txt']['Extra large (>1200px) - column width: full width'],
	'd-block d-xl-none'=>$ContentConfig['txt']['Extra large (>1200px) - column hidden on this device'],	
);

$ContentConfig['classes'][5]=array(
	''=>$ContentConfig['txt']['no column order'],
    'order-first'=>$ContentConfig['txt']['use first'],
    'order-last'=>$ContentConfig['txt']['use last'],
	'order-1'=>$ContentConfig['txt']['order-1'],
	'order-2'=>$ContentConfig['txt']['order-2'],
	'order-3'=>$ContentConfig['txt']['order-3'],
	'order-4'=>$ContentConfig['txt']['order-4'],
	'order-5'=>$ContentConfig['txt']['order-5'],
	'order-6'=>$ContentConfig['txt']['order-6'],
	'order-7'=>$ContentConfig['txt']['order-7'],
	'order-8'=>$ContentConfig['txt']['order-8'],
	'order-9'=>$ContentConfig['txt']['order-9'],
	'order-10'=>$ContentConfig['txt']['order-10'],
	'order-11'=>$ContentConfig['txt']['order-11'],
	'order-12'=>$ContentConfig['txt']['order-12'],	
);

$ContentConfig['classes'][6]=array(
	''=>$ContentConfig['txt']['Small (>576px) no column order'],
    'order-sm-first'=>$ContentConfig['txt']['use first'],
    'order-sm-last'=>$ContentConfig['txt']['use last'],    
	'order-sm-1'=>$ContentConfig['txt']['Small (>576px) order-1'],
	'order-sm-2'=>$ContentConfig['txt']['Small (>576px) order-2'],
	'order-sm-3'=>$ContentConfig['txt']['Small (>576px) order-3'],
	'order-sm-4'=>$ContentConfig['txt']['Small (>576px) order-4'],
	'order-sm-5'=>$ContentConfig['txt']['Small (>576px) order-5'],
	'order-sm-6'=>$ContentConfig['txt']['Small (>576px) order-6'],
	'order-sm-7'=>$ContentConfig['txt']['Small (>576px) order-7'],
	'order-sm-8'=>$ContentConfig['txt']['Small (>576px) order-8'],
	'order-sm-9'=>$ContentConfig['txt']['Small (>576px) order-9'],
	'order-sm-10'=>$ContentConfig['txt']['Small (>576px) order-10'],
	'order-sm-11'=>$ContentConfig['txt']['Small (>576px) order-11'],
	'order-sm-12'=>$ContentConfig['txt']['Small (>576px) order-12'],
);

$ContentConfig['classes'][7]=array(
	''=>$ContentConfig['txt']['Medium (>768px) no column order'],
    'order-md-first'=>$ContentConfig['txt']['use first'],
    'order-md-last'=>$ContentConfig['txt']['use last'],     
	'order-md-1'=>$ContentConfig['txt']['Medium (>768px) order-1'],
	'order-md-2'=>$ContentConfig['txt']['Medium (>768px) order-2'],
	'order-md-3'=>$ContentConfig['txt']['Medium (>768px) order-3'],
	'order-md-4'=>$ContentConfig['txt']['Medium (>768px) order-4'],
	'order-md-5'=>$ContentConfig['txt']['Medium (>768px) order-5'],
	'order-md-6'=>$ContentConfig['txt']['Medium (>768px) order-6'],
	'order-md-7'=>$ContentConfig['txt']['Medium (>768px) order-7'],
	'order-md-8'=>$ContentConfig['txt']['Medium (>768px) order-8'],
	'order-md-9'=>$ContentConfig['txt']['Medium (>768px) order-9'],
	'order-md-10'=>$ContentConfig['txt']['Medium (>768px) order-10'],
	'order-md-11'=>$ContentConfig['txt']['Medium (>768px) order-11'],
	'order-md-12'=>$ContentConfig['txt']['Medium (>768px) order-12'],
);

$ContentConfig['classes'][8]=array(
	''=>$ContentConfig['txt']['Large (>992px) no column order'],
    'order-lg-first'=>$ContentConfig['txt']['use first'],
    'order-lg-last'=>$ContentConfig['txt']['use last'],     
	'order-lg-1'=>$ContentConfig['txt']['Large (>992px) order-1'],
	'order-lg-2'=>$ContentConfig['txt']['Large (>992px) order-2'],
	'order-lg-3'=>$ContentConfig['txt']['Large (>992px) order-3'],
	'order-lg-4'=>$ContentConfig['txt']['Large (>992px) order-4'],
	'order-lg-5'=>$ContentConfig['txt']['Large (>992px) order-5'],
	'order-lg-6'=>$ContentConfig['txt']['Large (>992px) order-6'],
	'order-lg-7'=>$ContentConfig['txt']['Large (>992px) order-7'],
	'order-lg-8'=>$ContentConfig['txt']['Large (>992px) order-8'],
	'order-lg-9'=>$ContentConfig['txt']['Large (>992px) order-9'],
	'order-lg-10'=>$ContentConfig['txt']['Large (>992px) order-10'],
	'order-lg-11'=>$ContentConfig['txt']['Large (>992px) order-11'],
	'order-lg-12'=>$ContentConfig['txt']['Large (>992px) order-12'],
);

$ContentConfig['classes'][9]=array(
	''=>$ContentConfig['txt']['Extra large (>1200px) no column order'],
    'order-xl-first'=>$ContentConfig['txt']['use first'],
    'order-xl-last'=>$ContentConfig['txt']['use last'],      
	'order-xl-1'=>$ContentConfig['txt']['Extra large (>1200px) order-1'],
	'order-xl-2'=>$ContentConfig['txt']['Extra large (>1200px) order-2'],
	'order-xl-3'=>$ContentConfig['txt']['Extra large (>1200px) order-3'],
	'order-xl-4'=>$ContentConfig['txt']['Extra large (>1200px) order-4'],
	'order-xl-5'=>$ContentConfig['txt']['Extra large (>1200px) order-5'],
	'order-xl-6'=>$ContentConfig['txt']['Extra large (>1200px) order-6'],
	'order-xl-7'=>$ContentConfig['txt']['Extra large (>1200px) order-7'],
	'order-xl-8'=>$ContentConfig['txt']['Extra large (>1200px) order-8'],
	'order-xl-9'=>$ContentConfig['txt']['Extra large (>1200px) order-9'],
	'order-xl-10'=>$ContentConfig['txt']['Extra large (>1200px) order-10'],
	'order-xl-11'=>$ContentConfig['txt']['Extra large (>1200px) order-11'],
	'order-xl-12'=>$ContentConfig['txt']['Extra large (>1200px) order-12'],
);

$ContentConfig['classes'][10]=array(
	''=>$ContentConfig['txt']['Extra small (<576px) - no margin'],
	'ml-auto'=>$ContentConfig['txt']['Extra small (<576px) - left margin'],
	'mr-auto'=>$ContentConfig['txt']['Extra small (<576px) - right margin'],
	'ml-auto mr-auto'=>$ContentConfig['txt']['Extra small (<576px) - margin on both sides'],
);

$ContentConfig['classes'][11]=array(
	''=>$ContentConfig['txt']['Small (>576px) - no margin'],
	'ml-sm-auto'=>$ContentConfig['txt']['Small (>576px) - left margin'],
	'mr-sm-auto'=>$ContentConfig['txt']['Small (>576px) - right margin'],
	'ml-sm-auto mr-sm-auto'=>$ContentConfig['txt']['Small (>576px) - margin on both sides'],
);

$ContentConfig['classes'][12]=array(
	''=>$ContentConfig['txt']['Medium (>768px) - no margin'],
	'ml-md-auto'=>$ContentConfig['txt']['Medium (>768px) - left margin'],
	'mr-md-auto'=>$ContentConfig['txt']['Medium (>768px) - right margin'],
	'ml-md-auto mr-md-auto'=>$ContentConfig['txt']['Medium (>768px) - margin on both sides'],
);

$ContentConfig['classes'][13]=array(
	''=>$ContentConfig['txt']['Large (>992px) - no margin'],
	'ml-lg-auto'=>$ContentConfig['txt']['Large (>992px) - left margin'],
	'mr-lg-auto'=>$ContentConfig['txt']['Large (>992px) - right margin'],
	'ml-lg-auto mr-lg-auto'=>$ContentConfig['txt']['Large (>992px) - margin on both sides'],
);

$ContentConfig['classes'][14]=array(
	''=>$ContentConfig['txt']['Extra Large (>1200px) - no margin'],
	'ml-xl-auto'=>$ContentConfig['txt']['Extra Large (>1200px) - left margin'],
	'mr-xl-auto'=>$ContentConfig['txt']['Extra Large (>1200px) - right margin'],
	'ml-xl-auto mr-xl-auto'=>$ContentConfig['txt']['Extra Large (>1200px) - margin on both sides'],
);

$ContentConfig['customselects'][0]=array(
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

$ContentConfig['customselects'][1]=array(
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


$ContentConfig['customselects'][2]=array(
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
    $ContentConfig['txt']['Alternative fixed height value']=>'',    
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