<?php 
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("uLanguage") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');
	
include_once('../classes/class.content.php');
include_once('../classes/class.page.php');
$PAGE = new PAGE($DB,@$_GET['url']);	
$content = new CONTENT($DB,$PAGE,$USER);

$cUID = $_POST['data']['cuid'];
$cType = $_POST['data']['ctype'];	
	
include("../content/$cType/_$cType.config.php");	

if($ContentConfig['cAnimation_possible']==1)
    {
        include("../animation/animation.select.php");
    }	
	
header("Cache-Control: no-cache");

$primary_data = $DB->PREP_QUERY('SELECT * FROM content WHERE cUID=?','content',array('cUID'),array($cUID));
$primary_data = $primary_data->fetch_array();    
	
	
$extend="";

$extend.="
		<button type='button' class='core-accordion'><i class='far fa-caret-square-down'></i> ".$TXT['content identification']."</button>
		<div class='core-panel-open'>
		<p>";
	$extend.="<div class='form-group'>
			<label for='cAttrId'>".$content->TXT['content id']."</label>
			<input type='text' class='form-control' id='cAttrId' name='cAttrId' value='".$primary_data['cAttrId']."'>
			</div>";
	$extend.="<div class='form-group'>
			<label for='cAttrClass'>".$content->TXT['content css class']."</label>
			<input type='text' class='form-control' id='cAttrClass' name='cAttrClass' value='".$primary_data['cAttrClass']."'>
			</div>";
	$extend.="<div class='form-group'>
			<label for='cAttrClass'>".$content->TXT['content style']."</label>
			<textarea class='form-control' id='cAttrStyle' name='cAttrStyle' value='".$primary_data['cAttrStyle']."'>".$primary_data['cAttrStyle']."</textarea>
			</div>";
    
	/*if($primary_data['cOverridePosition']==1){ $override=" selected"; } else $override="";
		
	$extend.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='cLazyLoad' name='cLazyLoad' value='".$primary_data['cOverridePosition']."' ".$override."><label class='form-check-label' for='cLazyLoad'>".$TXT['override positioning in admin view']."</label></div>";	*/
		
				
			
			
	$extend.="</p></div>";
	
//------------------------------------------get secondary data----------------------------------------
	
//$get_secondary_data_sql = "SELECT * FROM contentdata WHERE cUID='$cUID'";
$secondary_data = $DB->PREP_QUERY('SELECT * FROM contentdata WHERE cUID=?','contentdata',array('cUID'),array($cUID));
    //$DB->multirow($get_secondary_data_sql);	

$secondary_fetched=array();	
$sec_counter=0;
$sec_classes=0;
$sec_attrs=0;	
$sec_paths=0;
$sec_custominputs=0;
$sec_customselects=0;	
	
while($secondary_row=$secondary_data->fetch_array()){
 	$secondary_fetched[$sec_counter]=$secondary_row;
	$sec_counter++;	
	if($secondary_row['cDataType']=="class")$sec_classes=1;
	if($secondary_row['cDataType']=="attribute")$sec_attrs=1;
	if($secondary_row['cDataType']=="path")$sec_paths=1;
	if($secondary_row['cDataType']=="customselect")$sec_customselects=1;
	if($secondary_row['cDataType']=="custominput")$sec_custominputs=1;
	if($primary_data['cStaticTemplate']!=-1)$sec_attrs=1;
	if($primary_data['cLazyLoad']==1)$sec_attrs=1;
}	
//print_r($secondary_fetched);	


if($sec_classes ==1 or $sec_attrs ==1 or $sec_paths ==1 or $sec_customselects ==1 or $sec_custominputs ==1){	
		$extend.="
		<button type='button' class='core-accordion'><i class='far fa-caret-square-down'></i> ".$TXT['basic options']."</button>
		<div class='core-panel-open'>
		<p>";
	}		
	
//------------------------------------------classes----------------------------------------		

	
$myclasses="";
	
$ccount=0;
for($i=0;$i<count($secondary_fetched);$i++){
	
		
		if($secondary_fetched[$i]['cDataType']=='class'){ //echo"es gibt";
			
					$myclasses.="<br><select class='form-control' id='".$secondary_fetched[$i]['cDataUID']."' name='classes[".$secondary_fetched[$i]['cDataUID']."]'>";
					$cicount=0;
					//print_r($secondary_fetched[$ccount]);
					//print_r($content_data[$cType]['classes']);
					foreach (@$ContentConfig['classes'][$ccount] as $key => $value) 
					{	
						if($key == $secondary_fetched[$i]['cDataContent']) { $csel="selected"; } else {$csel="";}
						$myclasses.="<option value='{$key}' $csel>{$value}</option>";
						$cicount++;
						$csel="";
					}
					$myclasses.="</select>";
					$ccount++;
				}
	
}
$extend.=$myclasses;	

	
//------------------------------------------attributes----------------------------------------		
	
$myattrs="";
	
$ccount=0;
for($i=0;$i<count($secondary_fetched);$i++){
	
		
		if($secondary_fetched[$i]['cDataType']=='attribute'){  //echo"es gibt";
			
					$myattrs.="<br><select class='form-control' id='".$secondary_fetched[$i]['cDataUID']."' name='attributes[".$secondary_fetched[$i]['cDataUID']."]'>";
					$cicount=0;
					//print_r($secondary_fetched[$ccount]);
					//print_r($content_data[$cType]['classes']);
					foreach (@$ContentConfig['attributes'][$ccount] as $key => $value) 
					{	
						if($key == $secondary_fetched[$i]['cDataContent']) { $csel="selected"; } else {$csel="";}
						$myattrs.="<option value='{$key}' $csel>{$value}</option>";
						$cicount++;
						$csel="";
					}
					$myattrs.="</select>";
					$ccount++;
				}
	
}
$extend.=$myattrs;	
	

//------------------------------------------paths----------------------------------------	
/*
$mypaths="";
	
$ccount=0;
for($i=0;$i<count($secondary_fetched);$i++){
	
		
		if($secondary_fetched[$i]['cDataType']=='path'){
			
					//$cicount=0;
					//print_r($secondary_fetched[$ccount]);
					//print_r($content_data[$cType]['classes']);
					foreach (@$ContentConfig['paths'] as $key => $value) 
					{	
                     
                        
                            $mypaths.="<div class='form-group'>
                            <label for='secondary[".$secondary_fetched[$i]['cDataUID']."]'><i class='far fa-folder'></i> ".$key."</label>
                            <input type='text' class='form-control' id='secondary[".$secondary_fetched[$i]['cDataUID']."]' name='paths[".$secondary_fetched[$i]['cDataUID']."]' value='".$secondary_fetched[$i]['cDataContent']."'  onclick='openKCFinder(this)'>
                            </div>";

					}
					$ccount++;
				}
	
}
$extend.=$mypaths;	 */   
//------------------------------------------paths new------------------------------------    
    
	
$mypaths="";
	
$ccount=0;
    
$mydatauid_array = array();
$mycontent_array = array();
    
for($i=0;$i<count($secondary_fetched);$i++)
    {		
    
        if($secondary_fetched[$i]['cDataType']=='path')
        {
            $mydatauid_array[$secondary_fetched[$i]['cDataEnum']] = $secondary_fetched[$i]['cDataUID'];
            $mycontent_array[$secondary_fetched[$i]['cDataEnum']] = $secondary_fetched[$i]['cDataContent'];            
        }
    

    }

asort($mydatauid_array);
asort($mycontent_array);    
		
                    $pcount=0;
    if(isset($ContentConfig['paths'])){
					foreach (@$ContentConfig['paths'] as $key => $value) 
					{	
                     
                        
                            $mypaths.="<div class='form-group'>
                            <label for='secondary[".$mydatauid_array[$pcount]."]'><i class='far fa-folder'></i> ".$key."</label>
                            <input type='text' class='form-control' id='secondary[".$mydatauid_array[$pcount]."]' name='paths[".$mydatauid_array[$pcount]."]' value='".$mycontent_array[$pcount]."'  onclick='openKCFinder(this)'>
                            </div>";
                        $pcount++;
					}
    }
	

$extend.=$mypaths;
	
	
//------------------------------------------custom selects----------------------------------------		
	
$mycusels="";
	
$ccount=0;
for($i=0;$i<count($secondary_fetched);$i++){
	
		
		if($secondary_fetched[$i]['cDataType']=='customselect'){  //echo"es gibt";
			
					$mycusels.="<br><select class='form-control' id='".$secondary_fetched[$i]['cDataUID']."' name='customselects[".$secondary_fetched[$i]['cDataUID']."]'>";
					$cicount=0;
					//print_r($secondary_fetched[$ccount]);
					//print_r($content_data[$cType]['classes']);
					foreach (@$ContentConfig['customselects'][$ccount] as $key => $value) 
					{	
						if($key == $secondary_fetched[$i]['cDataContent']) { $csel="selected"; } else {$csel="";}
						$mycusels.="<option value='{$key}' $csel>{$value}</option>";
						$cicount++;
						$csel="";
					}
					$mycusels.="</select>";
					$ccount++;
				}
	
}
$extend.=$mycusels;	
	
//------------------------------------------custom inputs----------------------------------------	

$mycusins="";
	
$ccount=0;
   
for($i=0;$i<count($secondary_fetched);$i++){
	
		
		if($secondary_fetched[$i]['cDataType']=='custominput'){
			
					//$cicount=0;
					//print_r($secondary_fetched[$ccount]);
					//print_r($content_data[$cType]['classes']);
            
                    $realcusincount=0;
					foreach (@$ContentConfig['custominputs'] as $key => $value) 
					{	
                        if($secondary_fetched[$i]['cDataEnum']==$realcusincount){
                            $mycusins.="<br><div class='form-group'>
                            <label for='secondary[".$secondary_fetched[$i]['cDataUID']."]'>".$key."</label>
                            <input type='text' class='form-control' id='secondary[".$secondary_fetched[$i]['cDataUID']."]' name='custominputs[".$secondary_fetched[$i]['cDataUID']."]' value='".$secondary_fetched[$i]['cDataContent']."'>
                            </div>";
                            
                        }
                        $realcusincount++;
					}
                    //$ccount++;
				}
	
}
$extend.=$mycusins;	
	



//------------------------------------------lazyload---------------------------------------	
	
	if($ContentConfig['cLazyLoad_possible']==1){
		if($primary_data['cLazyLoad']==1){$llsel=" checked"; $llval=1;} else {$llsel=""; $llval=0;}
		$extend.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='cLazyLoad' name='cLazyLoad' value='$llval' $llsel><label class='form-check-label' for='cLazyLoad'>".$TXT['lazy load this content']."</label></div>";	
		
	}
	
//------------------------------------Static Template-----------------------------------------------------------	
if($primary_data['cStaticTemplate']==1) {$this_static_checked = " checked"; $stval=1;} else {$this_static_checked = ""; $stval=0;}

$extend.="<br><div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='cStaticTemplate' name='cStaticTemplate' value='$stval' $this_static_checked><label class='form-check-label' for='cStaticTemplate'>".$TXT['This is a static template.']."</label></div>";
	
	
//------------------------------------------animation---------------------------------------		

$myanims="";
	
$ccount=0;
if($ContentConfig['cAnimation_possible']==1){
	$extend.="	
			</p></div><button type='button' class='core-accordion' href='#'><i class='far fa-caret-square-down'></i> ".$TXT['animation options']."</button>
			<div class='core-panel'>
			<p>";
	
	for($i=0;$i<count($secondary_fetched);$i++){


			if($secondary_fetched[$i]['cDataType']=='animationdata'){ //echo"es gibt";

						$myanims.="<br><select class='form-control' id='".$secondary_fetched[$i]['cDataUID']."' name='animationdata[".$secondary_fetched[$i]['cDataUID']."]'>";
						$cicount=0;
						//print_r($secondary_fetched[$ccount]);
						//print_r($content_data[$cType]['classes']);
						foreach ($animselect['animation'][$ccount] as $key => $value) 
						{	
							if($key == $secondary_fetched[$i]['cDataContent']) { $csel="selected"; } else {$csel="";}
							$myanims.="<option value='{$value}' $csel>{$key}</option>";
							$cicount++;
							$csel="";
						}
						$myanims.="</select>";
						$ccount++;
					}

	}

}
//	if($content_data[$cType]['cAnimation_possible']==1){	$extend.="</p></div>";}	
$extend.=$myanims;	

	
if($sec_classes ==1 or $sec_attrs ==1 or $sec_paths ==1 or $sec_customselects ==1 or $sec_custominputs ==1){	
		$extend.="</p></div>";}		
	


	
//------------------------------------hidden fields-----------------------------------------------------------		
$extend.="<input type='hidden' name='cType' value='".$primary_data['cType']."'>
          <input type='hidden' name='cUID' value='".$primary_data['cUID']."'>
          <input type='hidden' name='cAnimation' value='".$ContentConfig['cAnimation_possible']."'>";	
	
	
	
	
	
	
	
$extend = str_replace(array("\r", "\n"), '',$extend);
//echo $extend;	

    
$modal= new MODAL("core-edit-content", //modal id
							$TXT['edit content'], //modal title
							$extend, //modal content
							$TXT['cancel'], //cancel caption
							$TXT['save changes'], //action caption
							"core/actions/content.update.php",//action path
							"",//data-attribute
							"core-edit-content-form",//form class	
							"");//modal body class 	    
	
echo $modal->GET_MODAL();	
	
	
} 
else {echo "unauthorized access"; exit;}
?>		
	