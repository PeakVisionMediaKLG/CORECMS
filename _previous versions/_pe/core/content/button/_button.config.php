<?php
$mylanguage = $_SESSION['userlanguage'] ?? 'EN';
@include("txt/".$mylanguage.".php"); 

$ContentConfig['editor_rights']=array('edit');

$ContentConfig['children']=array();

$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

$ContentConfig['classes'][0]=array(
	'btn-custom'=>$ContentConfig['txt']['custom button'],
	'btn-primary'=>$ContentConfig['txt']['Bootstrap Primary button'],
    'btn-secondary'=>$ContentConfig['txt']['Bootstrap Secondary button'],
    'btn-success'=>$ContentConfig['txt']['Bootstrap Success button'],
    'btn-danger'=>$ContentConfig['txt']['Bootstrap Danger button'],
    'btn-warning'=>$ContentConfig['txt']['Bootstrap Warning button'],
    'btn-info'=>$ContentConfig['txt']['Bootstrap Info button'],
    'btn-light'=>$ContentConfig['txt']['Bootstrap Light button'],    
    'btn-dark'=>$ContentConfig['txt']['Bootstrap Dark button'],
    'btn-link'=>$ContentConfig['txt']['Bootstrap Link button'],
    
	'btn-outline-primary'=>$ContentConfig['txt']['Bootstrap Primary button (outline)'],
    'btn-outline-secondary'=>$ContentConfig['txt']['Bootstrap Secondary button (outline)'],
    'btn-outline-success'=>$ContentConfig['txt']['Bootstrap Success button (outline)'],
    'btn-outline-danger'=>$ContentConfig['txt']['Bootstrap Danger button (outline)'],
    'btn-outline-warning'=>$ContentConfig['txt']['Bootstrap Warning button (outline)'],
    'btn-outline-info'=>$ContentConfig['txt']['Bootstrap Info button (outline)'],
    'btn-outline-light'=>$ContentConfig['txt']['Bootstrap Light button (outline)'],    
    'btn-outline-dark'=>$ContentConfig['txt']['Bootstrap Dark button (outline)'],
    'btn-outline-link'=>$ContentConfig['txt']['Bootstrap Link button (outline)'],    
);

$ContentConfig['classes'][1]=array(
	''=>$ContentConfig['txt']['normal size button'],
	'btn-lg'=>$ContentConfig['txt']['large size button'],
    'btn-sm'=>$ContentConfig['txt']['small size button'],
);


$ContentConfig['classes'][2]=array(
    ''=>$ContentConfig['txt']['standard button'],
    'btn-block'=>$ContentConfig['txt']['block-style button'],
);    

$ContentConfig['attributes'][0]=array(
	''=>$ContentConfig['txt']['enabled'],
	'disabled'=>$ContentConfig['txt']['disabled'],
);

$ContentConfig['customselects'][0]=array(
	'button'=>$ContentConfig['txt']['&lt;button&gt;'],
	'a'=>$ContentConfig['txt']['&lt;a&gt;'],
    'input'=>$ContentConfig['txt']['&lt;input&gt;'],
);

$ContentConfig['customselects'][1]=array(
	''=>$ContentConfig['txt']['no type tag'],
	'button'=>$ContentConfig['txt']['&lt;input type="button"&gt;'],
	'submit'=>$ContentConfig['txt']['&lt;input type="submit"&gt;'],
);


$ContentConfig['paths']=array(
	$ContentConfig['txt']['choose picture (optional)']=>$ContentConfig['txt']['choose picture (optional)'],    
	//$ContentConfig['txt']['overlay picture']=>$ContentConfig['txt']['overlay picture'],
);

$ContentConfig['custominputs']=array(
$ContentConfig['txt']['caption']=>'',   
$ContentConfig['txt']['use link (optional)']=>''
);


/*
-------------------------Tutorial-------------------------
$content_data['column']['attributes'][0]=array(
'mykey'=>'myvalue'],
'mykey2'=>'myvalue2'],
);

$content_data['column']['customselects'][0]=array(
'mykeycs'=>'myvaluex'],
'mykey2cs'=>'myvaluex2'],
);


$content_data['column']['custominputs']=array(
'mylabel'=>'myinput'
);


$content_data['column']['paths']=array(
$content_data['column']['txt']['background picture']=>$content_data['column']['txt']['background picture']
);

*/

?>