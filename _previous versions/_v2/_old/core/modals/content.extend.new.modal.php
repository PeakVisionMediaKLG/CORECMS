<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("uLanguage") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');
include_once('../content/_txt/'.$languagetoload.'.php');	
	
include_once('../classes/class.content.php');
include_once('../classes/class.page.php');
$PAGE = new PAGE($DB,@$_GET['url']);	
$content = new CONTENT($DB,$PAGE,$USER);
	
	
header("Cache-Control: no-cache");


	
$input = array();	
$input = $_POST['data'] ?? exit;
//print_r($input);    
$cType = $input[0];

	//echo $cType;

function print_option ($value, $key) 
{  "<option value='$key'>$value</option>"; }	
	
include("../content/$cType/_$cType.config.php");
	
if(@$ContentConfig['cAnimation_possible']==1){
	
include("../animation/animation.select.php");
}
	
if($USER->IS_ADMIN) $open="-open"; else $open="";
    
$extend="";

$extend.="
		<button type='button' class='core-accordion'><i class='far fa-caret-square-down'></i> ".$TXT['content identification']."</button>
		<div class='core-panel$open'>
		<p>";
	$extend.="<div class='form-group'>
			<label for='cAttrId'>".$content->TXT['content id']."</label>
			<input type='text' class='form-control' id='cAttrId' name='cAttrId' value=''>
			</div>";
	$extend.="<div class='form-group'>
			<label for='cAttrClass'>".$content->TXT['content css class']."</label>
			<input type='text' class='form-control' id='cAttrClass' name='cAttrClass' value=''>
			</div>";
    $extend.="<div class='form-group'>
			<label for='cAttrClass'>".$content->TXT['content style']."</label>
			<textarea class='form-control' id='cAttrStyle' name='cAttrStyle'></textarea>
			</div></p></div>";
	
//------------------------------------------classes----------------------------------------	
	
	if(count(@$ContentConfig['classes'])>0 or count(@$ContentConfig['attributes'])>0 or count(@$ContentConfig['paths'])>0 or count(@$ContentConfig['customselects'])>0 or count(@$ContentConfig['custominputs'])>0){	
		$extend.="
		<button type='button' class='core-accordion'><i class='far fa-caret-square-down'></i> ".$TXT['basic options']."</button>
		<div class='core-panel-open'>
		<p>";

		
		
		if(count(@$ContentConfig['classes'])>0){ //echo"es gibt ".count($content_data[$cType]['classes'])." classes";
			$myclasses="";
			for ($counter=0;$counter<count(@$ContentConfig['classes']);$counter++)
				{
					$myclasses.="<br><select class='form-control' id='classes[$counter]' name='classes[$counter]'>";
					foreach (@$ContentConfig['classes'][$counter] as $key => $value) 
					{
						$myclasses.="<option value='{$key}'>{$value}</option>";
					}
					$myclasses.="</select>";
				}

			$extend.=$myclasses;
		}
	}
//------------------------------------------attributes----------------------------------------		
		if(count(@$ContentConfig['attributes'])>0){ //print_r($content_data[$cType]['attributes']);
			$myattributes="";
			for ($counter=0;$counter<count(@$ContentConfig['attributes']);$counter++)
				{
					$myattributes.="<br><select class='form-control' id='attributes[$counter]' name='attributes[$counter]'>";
					foreach (@$ContentConfig['attributes'][$counter] as $key => $value) 
					{
						$myattributes.="<option value='{$key}'>{$value}</option>";
					}
					$myattributes.="</select>";
				}

			$extend.=$myattributes;
		}
//------------------------------------------paths----------------------------------------		
		if(count(@$ContentConfig['paths'])>0){ //echo"es gibt ".count($content_data[$cType]['classes'])." classes";
			$mypaths="";
			$pathcounter=0;
			foreach (@$ContentConfig['paths'] as $key => $value)
				{
					$mypaths.="<div class='form-group'>
					<label for='".$key."'><i class='far fa-folder'></i> ".$value."</label>
					<input type='text' class='form-control' id='".$key."' name='paths[".$pathcounter."]' value=''  onclick='openKCFinder(this)'>
					</div>";
                    $pathcounter++;
				}

			$extend.=$mypaths;
		}

//------------------------------------------custom-selects---------------------------------------	
		if(count(@$ContentConfig['customselects'])>0){ //print_r($content_data[$cType]['attributes']);
			$mycusels="";
			for ($counter=0;$counter<count($ContentConfig['customselects']);$counter++)
				{
					$mycusels.="<br><select class='form-control' id='customselects[$counter]' name='customselects[$counter]'>";
					foreach (@$ContentConfig['customselects'][$counter] as $key => $value) 
					{
						$mycusels.="<option value='{$key}'>{$value}</option>";
					}
					$mycusels.="</select>";
				}

			$extend.=$mycusels;
		}
//------------------------------------------custom-inputs---------------------------------------	
	if(count(@$ContentConfig['custominputs'])>0){ //echo"es gibt ".count($content_data[$cType]['classes'])." classes";
		$myinputs="";
		foreach (@$ContentConfig['custominputs'] as $key => $value)
			{
				$myinputs.="<br><div class='form-group'>
				<label for='".$key."'>".$key."</label>
				<input type='text' class='form-control' id='".$key."' name='custominputs[".$key."]' value='$value'>
				</div>";
			}

		$extend.=$myinputs;
	}

//------------------------------------------ckeditor_content---------------------------------------	
	if(count(@$ContentConfig['ckeditable'])>0){ //echo"es gibt ".count($content_data[$cType]['classes'])." classes";
		$myckeditables="";
		foreach (@$ContentConfig['ckeditable'] as $key => $value)
			{
				$myckeditables.="<input type='hidden' class='form-control' id='".$key."' name='ckeditable[".$key."]' value='$value'>";
			}

		$extend.=$myckeditables;
	}	
	
//------------------------------------------lazyload---------------------------------------	
	
	if(@$ContentConfig['cLazyLoad_possible']==1){
		$extend.="<br><div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='cLazyLoad' name='cLazyLoad' ><label class='form-check-label' for='cLazyLoad'>".$TXT['lazy load this content']."</label></div>";	
		
	}
		$extend.="	
		</p>
		</div>";

//------------------------------------------animation---------------------------------------		
		if(@$ContentConfig['cAnimation_possible']==1){	
			$extend.="	
			<button type='button' class='core-accordion' href='#'><i class='far fa-caret-square-down'></i> ".$TXT['animation options']."</button>
			<div class='core-panel'>
			<p>";
			$myanims="";
			for ($counter=0;$counter<count($animselect['animation']);$counter++)
				{
					$myanims.="<br><select class='form-control' id='animationdata[$counter]' name='animationdata[$counter]'>";
					foreach ($animselect['animation'][$counter] as $key => $value) 
					{
						$myanims.="<option value='{$value}'>{$key}</option>";
					}
					$myanims.="</select>";
				}

			$extend.=$myanims;
			
			
			$extend.="</p>
			<input type='hidden' name='cAnimation' value='1'></div>";
			
		} else {$extend.="<input type='hidden' name='cAnimation' value='0'>"; }
	
	
	
	
$extend = str_replace(array("\r", "\n"), '',$extend);
echo $extend;	
	
} 
else {echo "unauthorized access"; exit;}
?>	