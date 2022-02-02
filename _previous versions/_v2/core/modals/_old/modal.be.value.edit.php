<?php
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

include_once(ROOT."core/classes/class.be.php");
$BE = new BE();
$BE->DB = $DB;
$BE->GETBELANGUAGES();

include_once(ROOT."core/classes/class.component.php");


if(!$USER->IS_SYSTEMADMIN) $disabled="disabled"; else $disabled="";

$getValue = $DB->EASY_QUERY( "SELECT", 
                                    'be_values',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "ORDER BY name ASC");

while ($valueRow=$getValue->fetch_array())
{

    $modalContent = 
    TABLE::PRE_R(array('class'=>'valuetable')).
        TR::PRE_R().
            TH::PRE_R(array('class'=>'')).
                TXT['Name'].
            TH::POST_R().
            TH::PRE_R(array('class'=>'')).
                TXT['Caption'].
            TH::POST_R().            
            TH::PRE_R(array('class'=>'')).
                TXT['Value'].
            TH::POST_R().
            TH::PRE_R(array('class'=>'')).
                TXT['Essential'].
            TH::POST_R();
        foreach($BE->BELANGUAGES as $key => $value)
        {
            $modalContent .= 
            TH::PRE_R(array('class'=>'')).
                $value.
            TH::POST_R();
        }		
    $modalContent .= 		
        TR::POST_R().
        TR::PRE_R(array('id'=>'valuerow')).
            TD::PRE_R(array('class'=>'')).
                HIDDEN::PRINT_R(array('name'=>'allvalues[0][id]','value'=>$valueRow['id'])).
                HIDDEN::PRINT_R(array('name'=>'allvalues[0][originalcaption]','value'=>$valueRow['caption'])).
                TEXTBOX::PRINT_R(array( //label,id,tabindex,autocomplete
                    'inline'=>1,
                    'class'=>'mt-2 has-validation',		
                    'type'=>'text',
                    'name'=>'allvalues[0][name]',
                    'value'=>$valueRow['name'],
                    'required'=>'required',
                    'liveValidation'=>array('alphaNum','Unique'),
                ),array('data-inum'=>0)
                ).
            TD::POST_R().
            TD::PRE_R(array('class'=>'')).
			TEXTBOX::PRINT_R(array( //label,id,tabindex,autocomplete
				'inline'=>1,
				'class'=>'mt-2 has-validation',		
				'type'=>'text',
                'name'=>'allvalues[0][caption]',
                'value'=>$valueRow['caption'],                
				'required'=>'required',
				'liveValidation'=>array('alphaNum','Unique'),
			),array('data-inum'=>0)
			).
		TD::POST_R().	            
            TD::PRE_R(array('class'=>'')).
                TEXTBOX::PRINT_R(array(
                    'inline'=>1,
                    'class'=>'mt-2 has-validation',		
                    //'label'=>TXT['Value'],
                    'type'=>'text',
                    'name'=>'allvalues[0][value]',
                    'value'=>$valueRow['value'],                    
                    //'id'=>'',
                    //'tabindex'=>'60',
                    'required'=>'required',
                    //'value'=>'',
                    //'autocomplete'=>'off',
                    'liveValidation'=>array('alphaNum'),
                    ),array('data-inum'=>0)
                ).
            TD::POST_R();

            if($valueRow['essential']==1)  $checked="checked"; else $checked="";       

            $modalContent .=
            TD::PRE_R(array('class'=>'')).
                CHECKBOX::PRINT_R(array(	'class'=>'core-checkbox mt-3',
                                            //'caption'=>TXT['Admin'],
                                            'name'=>'allvalues[0][essential]',
                                            //'id'=>'isadmin',
                                            //'tabindex'=>'200'
                                            //'checked'=>$checked,
                                            'value'=>$valueRow['essential'], 
                                            'disabled'=>$disabled,
                                        ),array('data-inum'=>0)).
            TD::POST_R();
            foreach($BE->BELANGUAGES as $key => $value)
            {
                
                $getCaption = $DB->EASY_QUERY( "SELECT", 
                                    'be_captions',
                                    array('name',$key),
                                    array(),
                                    array('name'),
                                    array($valueRow['caption']),
                                    );   
                                    
                $getCaption = $getCaption->fetch_array();
                $getCaption = $getCaption[$key];
                
                $modalContent .= 
                TD::PRE_R(array('class'=>'')).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        //'label'=>TXT['Value'],
                        'type'=>'text',
                        'name'=>'allvalues[0][lang_'.$value.']',
                        'value'=>$getCaption,
                        //'id'=>'',
                        //'tabindex'=>'60',
                        'required'=>'required',
                        //'value'=>'',
                        //'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum'),
                        ),array('data-inum'=>0)
                    ).
                TD::POST_R();
            }	
    $modalContent .=		
        TR::POST_R().
    TABLE::POST_R().
    TABLE::PRE_R();

    $modalContent .=	
    TABLE::POST_R();
}

$modal= new MODAL(array(
                        'id'=>"core-edit-value-".time(),
                        'title'=>TXT['Edit value'],
                        'content'=>$modalContent,
						'contentSize'=>'modal-xl',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/action.be.value.update.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>