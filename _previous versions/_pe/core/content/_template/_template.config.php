<?php
//template
//content element name for easy identification

//specify possible children elements
$ContentConfig['children']=array('container','row','custom');

//specify if content element can be animated with animate.css or if lazy loading is possible
$ContentConfig['cAnimation_possible']=1;
$ContentConfig['cLazyLoad_possible']=1;

//specify css classes with as many options as desired, shown as a select field in the content element editing modals
//each css class must have a number which must be used incrementally
//
//the correct syntax for the array is: 'class name' that will be added in the HTML class tag => 'option text' in modal's select field
//
$ContentConfig['classes'][0]=array(
    'container-fluid'=>$ContentConfig['txt']['full-width container'],
    'container'=>$ContentConfig['txt']['fixed-width container'],
    ''=>$ContentConfig['txt']['simple div (no bootstrap)'],	
);

$ContentConfig['classes'][1]=array(
    'core-nopadding'=>$ContentConfig['txt']['margin-free layout'],
    ''=>$ContentConfig['txt']['use bootstrap gutter']
);

$ContentConfig['classes'][2]=array(
    ''=>$ContentConfig['txt']['no stick to top'],
    'core-sticky'=>$ContentConfig['txt']['stick to top']
);

//specify HTML attributes with as many options as desired, shown as a select field in the content element editing modals
//each attribute must have a number which must be used incrementally
//
//the correct syntax for the array is: 'attribute name' that will be added in the HTML class tag => 'option text' in modal's select field
//
$ContentConfig['attributes'][0]=array(
'mykey'=>'myvalue',
'mykey2'=>'myvalue2',
);



$ContentConfig['paths']=array(
$ContentConfig['txt']['background picture']=>$ContentConfig['txt']['background picture']
);


/*
-------------------------Tutorial-------------------------


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