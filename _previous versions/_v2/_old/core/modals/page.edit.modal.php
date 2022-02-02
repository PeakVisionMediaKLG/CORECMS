<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
	
include_once('../classes/class.page.php');
//include_once('../../core/classes/class.content.php');
$PAGE = new PAGE($DB,@$_POST['url']);	
//$content = new content($DB,$PAGE,$USER);

include_once('../classes/class.admin.php');
$ADMIN = new ADMIN($DB,$PAGE,$USER);	
	

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');	

$pUID = $_POST['data']['puid'] ?? die('no ID sent');
$pLanguage = $_POST['data']['planguage'] ?? die('no language sent');   
		
	$page_dataset=$DB->PREP_QUERY('SELECT * FROM pages WHERE pUID=?','pages',array('pUID'),array($pUID));
    $page_dataset=$page_dataset->fetch_array();
	
			$style_selects="";
			$style_selects.="<div class='form-group'>
				<label for='pURL'>".$TXT['url']."</label>
				<input type='text' class='form-control' name='pURL' value='".$page_dataset['pURL']."'>
				</div>";
			
			$style_selects.="<div class='form-group'>
				<label for='pLinkText'>".$TXT['link text']."</label>
				<input type='text' class='form-control' name='pLinkText' value='".$page_dataset['pLinkText']."'>
				</div>";
	
			$style_selects.="<div class='form-group'>
				<label for='pTitle'>".$TXT['title']."</label>
				<input type='text' class='form-control' name='pTitle' value='".$page_dataset['pTitle']."'>
				</div>";

			$style_selects.="<div class='form-group'>
				<label for='pDescription'>".$TXT['description']."</label>
				<textarea class='form-control' name='pDescription'>".$page_dataset['pDescription']."</textarea>
				</div>";

			$style_selects.="<div class='form-group'>
				<label for='pKeywords'>".$TXT['keywords']."</label>
				<input type='text' class='form-control' name='pKeywords' value='".$page_dataset['pKeywords']."'>
				</div>";
	

			$style_selects.="<div class='form-group'>
				<label for='pStyle'>".$TXT['page-wide settings']."</label>
				<textarea class='form-control' name='pStyle'>".$page_dataset['pStyle']."</textarea>
				</div>";
	
			$style_selects.="<div class='form-group'><label for='pparent-cb'>".$TXT['parent page']."</label>
			<select id='pparent-cb' class='form-control' name='pParent'>
			<option value=''></option>";
	           
            $ADMIN->TEMP_PARENTS = "";
            $ADMIN->POPULATE_PARENTSELECT("",$page_dataset['pUID'],$pLanguage,1);
    
            $style_selects.= $ADMIN->TEMP_PARENTS;
            
            /*global $tab_stop2;
			$aif=$PAGE->ALLMENUITEMS();
			$tab_stop2=""; //echo count($aif); 
					for($i=0;$i<=count($aif);$i++){
                        
                        if ((@aif[$i]['pParent']=="" and @$aif[$i]['pUID']!=NULL) 
                    or (@$aif[$i]['pParent']=="" and @$aif[$i]['pUID']!=NULL))
					
						/*if ((@$aif[$i]['pParent']==0 and @$aif[$i]['pUID']!=NULL and @$aif[$i]['pAuthAccessOnly']==0) or (@$aif[$i]['pParent']==0 and @$aif[$i]['pUID']!=NULL and @$aif[$i]['pAuthAccessOnly']==1 and $_USER_AUTH_OK==1))*//*{
						if($aif[$i]['pSharedID']==$PAGE->PAGEVALS['pParent']) $parentselected="selected"; else $parentselected="";
						if($aif[$i]['pSharedID']!=$PAGE->PAGEVALS['pSharedID']) $style_selects.= "<option value='".$aif[$i]['pSharedID']."'".$parentselected.">".$tab_stop2.$aif[$i]['pLinkText']."</option>";
						$parentselected="";
						$ADMIN->FIND_PARENTS($aif,$aif[$i]['pSharedID']);
						
						}
					}
			*/
			$style_selects.="</select></label>";
	
	
			$style_selects.="<br><h5>".$TXT['page properties']."</h5>";	
			
			if($page_dataset['pActive']==1) {$this_pa_checked = " checked";} else $this_pa_checked = "";
	
			$style_selects.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='pActive-cb' name='pActive'".$this_pa_checked."><label class='form-check-label' for='pActive-cb'>".$TXT['page is active']."</label></div>";
	
			if($page_dataset['pShowInNav']==1) {$this_psin_checked = " checked";} else $this_psin_checked = "";
	
			$style_selects.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='psin-cb' name='pShowInNav'".$this_psin_checked."><label class='form-check-label' for='psin-cb'>".$TXT['show page in navigation']."</label></div>";
	
	       /*
			if($page_dataset['pTemplate']==1) {$this_pt_checked = " checked";} else $this_pt_checked = "";
	
			$style_selects.="<div class='form-check'><input class='form-check-input core-checkbox' type='checkbox' id='pt-cb' name='pTemplate'".$this_pt_checked."><label class='form-check-label' for='pt-cb'>".$TXT['available as a template']."</label></div>";
			

			/*
			if($page_dataset['pAuthAccessOnly']==1) $this_paao_checked = " checked"; else $this_paao_checked = "";
			$style_selects.="<div class='checkbox'><label><input type='checkbox' class='core-checkbox' name='pAuthAccessOnly'".$this_paao_checked." id='edit_paao_select'>authorised access only</label></div>";
			*/
			
				
	
			$style_selects.="<input type='hidden' name='pUID' value='".$page_dataset['pUID']."'>";
    		$style_selects.="<input type='hidden' name='pSharedID' value='".$page_dataset['pSharedID']."'>";
			
			$style_selects = str_replace(array("\r", "\n"), '', $style_selects);
	
$modalcontent=$style_selects;	
	
	
	
$modal= new MODAL("core-edit-page.".$pUID, //modal id
							$TXT['edit page'], //modal title
							$modalcontent, //modal content
							$TXT['cancel'], //cancel caption
							$TXT['save changes'], //action caption
							"core/actions/page.update.php",//action path
							"",//data-attribute
							"core-edit-page-form",//form class	
							"");//modal body class 	
echo $modal->GET_MODAL();		

} 
else {echo "unauthorized access"; exit;}
?>