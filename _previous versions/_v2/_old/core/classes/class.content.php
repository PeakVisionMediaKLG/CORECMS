<?php

class CONTENT 
{

    public 	    $DB;
    public 	    $PAGE;
    public      $USER;
	public 		$DISALLOWED;
    private 	$contentrowscounter;
    private 	$contentrowsfetched;	

    function __construct($DB,$PAGE,$USER)
        {
            $this->DB = $DB;
            $this->PAGE = $PAGE;
            $this->USER = $USER;
			$this->DISALLOWED = array();

            $languagetoload = $this->USER->GET_USERVAL("language") ?? 'EN';
            include('txt/'.$languagetoload.'.php');
            $this->TXT = $TXT;

            $this->contentrowscounter=0;
            $this->contentrowsfetched=array();
			if($this->USER->USER_AUTH_OK) $this->PROHIBITED_ELEMENTS();
        }
	
	function PROHIBITED_ELEMENTS($nextparent="")
	{
		if($nextparent=="")
		{
			$nextparent = @$_SESSION['copied_content_id'] ?? "error";
			if($nextparent=="error") return; else array_push($this->DISALLOWED,$_SESSION['copied_content_id']);
		}
		$kids=$this->DB->MULTI_ROW("SELECT cUID FROM content WHERE cParent= '".$nextparent."'");
		
		while($thekid = $kids->fetch_array())
		{
			array_push($this->DISALLOWED,$thekid['cUID']);	
			$this->PROHIBITED_ELEMENTS($thekid['cUID']);
		}
		
	}


    function BUILD_GLOBAL_ARRAY(&$value, $key){
        $this->contentrowsfetched[$this->contentrowscounter][$key]=$value;
        //echo $key."---".$value."<br>";
    }		

    
    function PRE_INCLUDES ($myparent="")
    {
        if($this->USER->USER_AUTH_OK and $this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1) 
            {
                $showDisabledContent=1; 
            }
        else $showDisabledContent=0;
        
        $precontentset = $this->DB->PREP_QUERY("SELECT cActive, cType, cUID FROM content WHERE cLanguage=? and cParent=? and cPageUID=? and cDeleted=0 ORDER BY cPosition ASC",
                                            'content',
                                            array('cLanguage','cParent','cPageUID'),
                                            array($this->PAGE->GET_PAGEVAL('pLanguage'),$myparent,$this->PAGE->GET_PAGEVAL('pUID')),
                                            @$DB->SETTINGS['mysqlErrorReporting']);
        
        $this->contentrowscounter=0; 
        
        if (mysqli_num_rows($precontentset)!==0){
            
            while($preInfo=$precontentset->fetch_array()){
                
                if($preInfo['cActive']==1 or $showDisabledContent==1){ // ???? what is $showDisabledContent ---
                    
                    $includePath='core/content/'.$preInfo['cType']."/";

                    if(file_exists($includePath.$preInfo['cType'].'.pre_include.php')) {include_once($includePath.$preInfo['cType'].'.pre_include.php'); }
                   
                    $this->PRE_INCLUDES($preInfo['cUID']);        
                    
                }
            }
        }
    }
    
    function POST_INCLUDES ($myparent="")
    {

        if($this->USER->USER_AUTH_OK and $this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1) 
            {
                $showDisabledContent=1; 
            }
        else $showDisabledContent=0;
        
        $postcontentset = $this->DB->PREP_QUERY("SELECT cActive, cType, cUID FROM content WHERE cLanguage=? and cParent=? and cPageUID=? and cDeleted=0 ORDER BY cPosition ASC",
                                            'content',
                                            array('cLanguage','cParent','cPageUID'),
                                            array($this->PAGE->GET_PAGEVAL('pLanguage'),$myparent,$this->PAGE->GET_PAGEVAL('pUID')),
                                            @$DB->SETTINGS['mysqlErrorReporting']);
        
        $this->contentrowscounter=0; 
        
        if (mysqli_num_rows($postcontentset)!==0){
            
            while($postInfo=$postcontentset->fetch_array()){
                
                if($postInfo['cActive']==1 or $showDisabledContent==1){ // 
                    
                    $includePath='core/content/'.$postInfo['cType']."/";

                    if(file_exists($includePath.$postInfo['cType'].'.post_include.php')) {include_once($includePath.$postInfo['cType'].'.post_include.php'); }
                   
                    $this->POST_INCLUDES($postInfo['cUID']);        
                    
                }
            }
        }
    }

    function BUILD_CONTENT ($myparent="")
    {
        if($this->USER->USER_AUTH_OK and $this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1) 
            {
                $showDisabledContent=1; 
            }
        else $showDisabledContent=0;
        
        $contentset = $this->DB->PREP_QUERY("SELECT * FROM content WHERE cLanguage=? and cParent=? and cPageUID=? and cDeleted=0 ORDER BY cPosition ASC",
                                            'content',
                                            array('cLanguage','cParent','cPageUID'),
                                            array($this->PAGE->GET_PAGEVAL('pLanguage'),$myparent,$this->PAGE->GET_PAGEVAL('pUID')),
                                            @$DB->SETTINGS['mysqlErrorReporting']);
        
        $this->contentrowscounter=0; 
        
        if (mysqli_num_rows($contentset)!==0){
            
            while($ContentBasics=$contentset->fetch_array()){
                
                if($ContentBasics['cActive']==1 or $showDisabledContent==1){ //
                    
                    if($ContentBasics['cAttrId']!="") $ContentBasics['cAttrId']=" id='".$ContentBasics['cAttrId']."'"; else $ContentBasics['cAttrId']="";
                    
                    switch($ContentBasics['cStaticCopyOf'])
                    {
                        case 0: case -1:

                            // check if user overrides content element with custom content
                            if(file_exists('custom/content/'.$ContentBasics['cType'].'/')) $includePath='custom/content/'; else $includePath='core/content/';    
                            
                            $mylanguage = $_SESSION['userlanguage'] ?? 'EN';
                            @include($includePath."/txt/".$mylanguage.".php");
                            
                            include($includePath.$ContentBasics['cType'].'/_'.$ContentBasics['cType'].'.config.php'); 

                            foreach ($ContentConfig as $key=>$value) //extend data array with contentdata vals from config file
                                {
                                    $ContentBasics[$key]=$value;
                                }
                            
                            $contentdataset = $this->DB->PREP_QUERY("SELECT * FROM contentdata WHERE cUID=?",
                                    'contentdata',
                                    array('cUID'),
                                    array($ContentBasics['cUID']),
                                    @$DB->SETTINGS['mysqlErrorReporting']);
                             
                            while ($thedata=$contentdataset->fetch_array())
                                {
                                    if($thedata['cDataType']=="ckeditable")
                                    {
                                        $ContentData[$thedata['cDataType']][$thedata['cDataEnum']]['cDataContent']=$thedata['cDataContent'];
                                        $ContentData[$thedata['cDataType']][$thedata['cDataEnum']]['cDataUID']=$thedata['cDataUID'];
                                    }
                                    else
                                    {
                                        $ContentData[$thedata['cDataType']][$thedata['cDataEnum']]=$thedata['cDataContent'];
                                    }
                                    
                                }                           
                            
                            $ContentBasics['realID']=$ContentBasics['cUID'];
                            
                            if($ContentBasics['cAnimation']==1) include('core/animation/animation.php'); 
                            if($ContentBasics['cLazyLoad']==1) include('core/animation/lazyload_pre.php');   
                            
                            include($includePath.$ContentBasics['cType'].'/'.$ContentBasics['cType'].'.pre.php');

                            $this->build_content($ContentBasics['cUID']); 

                            if(file_exists($includePath.$ContentBasics['cType'].'/'.$ContentBasics['cType'].'.content.php')) include($includePath.$ContentBasics['cType'].'/'.$ContentBasics['cType'].'.content.php');
                                // some content elements don't have content, as they are pure containers

                            include($includePath.$ContentBasics['cType'].'/'.$ContentBasics['cType'].'.post.php');
                            
                            if($ContentBasics['cLazyLoad']==1) include('core/animation/lazyload_post.php');
                            unset($content_vals);
                            unset($includePath);
                               
                        break;
                        default: 
                            
                                $templateData = $this->DB->PREP_QUERY("SELECT * FROM content WHERE cUID=?",
                                    'content',
                                    array('cUID'),
                                    array($ContentBasics['cStaticCopyOf']),
                                    @$DB->SETTINGS['mysqlErrorReporting']);
                                $templateData = $templateData->fetch_array();
                            
                                /*$getTemplateSQL="SELECT * FROM content WHERE cUID='".$ContentBasics['cStaticCopyOf']."'";
                                $templateData=$this->DB->SINGLEROW($getTemplateSQL);*/
                            
                                if(file_exists('custom/content/'.$templateData['cType'].'/')) $includePath='custom/content/'; else $includePath='core/content/';    
                            
                                $mylanguage = $_SESSION['userlanguage'] ?? 'EN';
                                @include($includePath."/txt/".$mylanguage.".php");

                                include('core/content/'.$templateData['cType'].'/_'.$templateData['cType'].'.config.php');

                                /*    foreach ($ContentBasics as $key=>$value){
                                        $mydata[$key]=$value;
                                    }
                                $mydata['realID']=$mydata['cUID'];
                                $mydata['cUID']=$templateData['cUID'];*/
                                foreach ($ContentConfig as $key=>$value) //extend data array with contentdata vals from config file
                                    {
                                        $ContentBasics[$key]=$value;
                                    }
                                
                                $ContentBasics['realID']=$ContentBasics['cUID'];
                                $ContentBasics['cUID']=$templateData['cUID'];

                                if($templateData['cAnimation']==1){ include('core/animation/animation.php'); }
                                if($templateData['cLazyLoad']==1){ include('core/animation/lazyload_pre.php'); }

                                include('core/content/'.$templateData['cType'].'/'.$templateData['cType'].'.pre.php');

                                /*if($templatepage=="")
                                    {
                                        $orgpage = $this->DB->SINGLEROW("SELECT cPageUID FROM content WHERE cUID='".$mydata['cStaticCopyOf']."'");
                                        $orgpage = $orgpage[0]; //echo "hier template empty";
                                    } 
                                else 
                                    {
                                        $orgpage = $templatepage; //echo "hier template";
                                    }
                                */
                                $orgpage = $this->DB->SINGLE_ROW("SELECT cPageUID FROM content WHERE cUID='".$ContentBasics['cStaticCopyOf']."'");
                                $orgpage = $orgpage[0];
                            
                                $this->build_content($ContentBasics['cStaticCopyOf'],$orgpage); 

                                if(file_exists('core/content/'.$templateData['cType'].'/'.$templateData['cType'].'.content.php')) include('core/content/'.$templateData['cType'].'/'.$templateData['cType'].'.content.php');
                                    // some content elements don't have content, as they are pure containers

                                include('core/content/'.$templateData['cType'].'/'.$templateData['cType'].'.post.php');
                                
                                if($ContentBasics['cLazyLoad']==1) include('core/animation/lazyload_post.php');
                        break;    
                    }
                } //end if only active pages
            } //end while $ContentBasics

        }
    }


    function PREPARE($what,$cUID,$myclass="")
        {
            switch($what){

                case "classes":

                    $get_classes_sql="SELECT * FROM contentdata WHERE (cUID='$cUID' AND (cDataType='class' OR cDataType='animationdata'))";//echo $get_classes_sql;
                    $result=$this->DB->MULTI_ROW($get_classes_sql);

                    $theprintout = "";
                        while($printoutrow=$result->fetch_array()){

                            if(($printoutrow['cDataType']=="animationdata" and $printoutrow['cDataEnum']==0 and $printoutrow['cDataContent']!="" and $this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')!=1))
                            {
                                $theprintout.="core-wow ".$printoutrow['cDataContent']." ";
                            }
                            if($printoutrow['cDataType']=="class" and $printoutrow['cDataContent']!="")
                            {
                                $theprintout.=$printoutrow['cDataContent']." ";
                            }
                        }

                    $theprintout.=$myclass;
                    if(($this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1)) {$theprintout.=" core-admin-view"; }
                    echo $theprintout;

                break;
                case "attributes":

                    $get_attributes_sql="SELECT * FROM contentdata WHERE (cUID='$cUID' AND (cDataType='attribute' OR cDataType='animationdata'))";//echo $get_classes_sql;
                    $result=$this->DB->MULTI_ROW($get_attributes_sql);

                    $theprintout = "";
                    //$i=0;
                        while($printoutrow=$result->fetch_array()){

                            if(($printoutrow['cDataType']=="animationdata" and $printoutrow['cDataEnum']>0 and $printoutrow['cDataContent']!="" and $this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')!=1))
                            {	
                                if($printoutrow['cDataEnum']==1) $theprintout.=" data-wow-duration='".$printoutrow['cDataContent']."'";
                                if($printoutrow['cDataEnum']==2) $theprintout.=" data-wow-delay='".$printoutrow['cDataContent']."'";
                            }
                            if($printoutrow['cDataType']=="attribute" and $printoutrow['cDataContent']!="")
                            {
                                $theprintout.=" ".$printoutrow['cDataContent']." ";
                            }
                        }

                    
                    echo $theprintout;
                break;
                case "styles":
                break; 
                case "paths":
                    $get_paths_sql="SELECT * FROM contentdata WHERE (cUID='$cUID' AND cDataType='path')"; //echo $get_classes_sql;
                    $result=$this->DB->MULTI_ROW($get_paths_sql);
                    return $result;
                break;
                case "id":
                
                    
                break;
                default:
                break;	
            }	

        }	





    function MOVE_CONTENT ($cType,$cUID,$cParent,$cPosition,$cPageUID,$relocated=0)
        {      
            if($relocated==0) $expendable = " core-expendable"; else $expendable = "";  
            //$same_elements_on_level_sql="SELECT cUID, cPosition FROM content WHERE cParent='$cParent' AND cDeleted=0 ORDER BY cPosition ASC";
            //echo $same_elements_on_level_sql;
            $same_elements_on_level=array();
            //$same_elements_on_level=$this->DB->MULTIROW($same_elements_on_level_sql); 
            $same_element_count=0;
            $same_elements_on_level=$this->DB->PREP_QUERY('SELECT cUID, cPosition FROM content WHERE cParent=? AND cPageUID = ? AND cDeleted=0 ORDER BY cPosition ASC',
                                                          'content',
                                                          array('cParent','cPageUID'),
                                                          array($cParent,$cPageUID),
                                                          0); //@$this->DB->SETTINGS['mysqlErrorReporting']
                
                while($sameelementsrow=$same_elements_on_level->fetch_array()){
                    if($same_element_count==0){$firstone=$sameelementsrow['cUID'];}
                    $same_element_count+=1; $lastone=$sameelementsrow['cUID'];
                }
            if ($same_element_count>1){
                if($firstone!=$cUID){
                ?>
                <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>" 
                        data-cUID='<?php echo $cUID; ?>'
                        data-cParent="<?php echo $cParent; ?>"
                        data-cPosition="<?php echo $cPosition; ?>"
                        data-cPageUID="<?php echo $cPageUID; ?>"
                        data-action-path="core/actions/content.move.up.php">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                </button>


                <?php } 
                if($lastone!=$cUID){
                ?>
                <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>" 
                        data-cUID='<?php echo $cUID; ?>'
                        data-cParent="<?php echo $cParent; ?>"
                        data-cPosition="<?php echo $cPosition; ?>"
                        data-cPageUID="<?php echo $cPageUID; ?>"
                        data-action-path="core/actions/content.move.down.php">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </button>
                <?php  }
            }
        }

    function COPY_CONTENT ($cType,$cUID,$cParent,$relocated=0)
        {
            if($relocated==0) $expendable = " core-expendable"; else $expendable = ""; 
            if(@$_SESSION['current_mode']!="branch_copied" and @$_SESSION['current_mode']!="branch_cut"){ 
        ?>     
                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>" 
                            data-content-id="<?php echo $cUID; ?>" 
                            data-content-type="<?php echo $cType; ?>"
                            data-mode="branch_copied"
                            data-action-path="core/actions/content.cut.copy.php">
                        <i class="far fa-copy"></i>
                    </button>

        <?php	}
        }

    function CUT_CONTENT ($cType,$cUID,$cParent,$relocated=0)
        {  
            if($relocated==0) $expendable = " core-expendable"; else $expendable = "";
            if(@$_SESSION['current_mode']!="branch_copied" and @$_SESSION['current_mode']!="branch_cut"){ 
                    ?>     
                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>"  
                            data-content-id="<?php echo $cUID; ?>" 
                            data-content-type="<?php echo $cType; ?>"
                            data-mode="branch_cut"                            
                            data-action-path="core/actions/content.cut.copy.php">
                        <i class="fas fa-cut"></i>
                    </button>
        <?php	}
        }

    function ACTIVATE_DEACTIVATE_CONTENT ($cUID,$cActive,$relocated=0)
        {      
            if($relocated==0) $expendable = " core-expendable"; else $expendable = "";    
            if($cActive){ ?>     

                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>"  
                            data-content-id="<?php echo $cUID; ?>" 
                            data-action-path="core/actions/content.deactivate.php">
                        <i class="fas fa-toggle-on"></i>
                    </button>

        <?php	}
            else{ ?>     

                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>"  
                            data-content-id="<?php echo $cUID; ?>" 
                            data-action-path="core/actions/content.deactivate.php">
                        <i class="fas fa-toggle-off"></i>
                    </button>

        <?php	}
        }    

    
    function LOCK_UNLOCK_CONTENT ($cUID,$cLocked,$relocated=0)
        {      
            if($relocated==0) $expendable = " core-expendable"; else $expendable = "";    
            if($cLocked){ ?>     

                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>"  
                            data-content-id="<?php echo $cUID; ?>" 
                            data-action-path="core/actions/content.lock.unlock.php">
                        <i class="fas fa-lock"></i>
                    </button>

        <?php	}
            else{ ?>     

                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>"  
                            data-content-id="<?php echo $cUID; ?>" 
                            data-action-path="core/actions/content.lock.unlock.php">
                        <i class="fas fa-unlock"></i>
                    </button>

        <?php	}
        }     
    
    
    function PASTE_COPIED_CONTENT ($possible_children,$cUID,$relocated=0)
        {
			if(in_array($cUID,$this->DISALLOWED)) return;
		
			if($relocated==0) $expendable = " core-expendable"; else $expendable = "";
            $copied_type = $_SESSION['element_type'] ?? 'none';
            $copied_element= $_SESSION['copied_content_id'] ?? 'error';
            if (in_array($copied_type,$possible_children)) {
                if($copied_element!="error" and $cUID!=$copied_element){
            ?>
                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>" 
                            data-content-id="<?php echo $cUID; ?>" 
                            data-copied-content-id="<?php echo $copied_element ?>" 
                            data-page-id="<?php echo $this->PAGE->GET_PAGEVAL('pUID');?>"
                            data-page-language="<?php echo $this->PAGE->GET_PAGEVAL('pLanguage');?>"
                            data-action-path="core/actions/content.paste.from.copy.php" >
                                <i class="far fa-edit"></i>
                    </button>
            <?php	
                }
            }

        }

    function PASTE_CUT_CONTENT ($possible_children,$cUID,$relocated=0)
        {
            if($relocated==0) $expendable = " core-expendable"; else $expendable = "";
            $copied_type = $_SESSION['element_type'] ?? 'none';
            $copied_element = $_SESSION['cut_content_id'] ?? 'error';
            if (in_array($copied_type,$possible_children)) {
                if($copied_element!="error" and $cUID!=$copied_element){
            ?>

                    <button type="button" class="core-action-btn btn btn-sm core-ontop btn-secondary<?php echo $expendable; ?>" 
                            data-content-id="<?php echo $cUID; ?>" 
                            data-copied-content-id="<?php echo $copied_element ?>" 
                            data-page-id="<?php echo $this->PAGE->GET_PAGEVAL('pUID');?>"
                            data-page-language="<?php echo $this->PAGE->GET_PAGEVAL('pLanguage');?>"
                            data-action-path="core/actions/content.paste.from.cut.php" >
                                <i class="fas fa-reply"></i>
                    </button>

            <?php	
                }
                else
                {    if(@$_SESSION['current_mode']=="branch_cut")
                        {      ?>
                <div class="core-cut-element"></div>
            <?php       }
                }
            }

        }    

    function CONTENT_CONTROLS ($content_dataset,$show_content_info=1)
        {   //print_r($content_dataset);
            if($show_content_info==1)
            {
                echo "<p class='core-content-description' data-cuid='".$content_dataset['cUID']."'>";$content_dataset['cAttrClass']=$content_dataset['cAttrClass'] ?? ''; 
                /*if(strlen($content_dataset['cType'])>8) {$typetext=substr($content_dataset['cType'],0,7); $lenflag=1;} else {$typetext=$content_dataset['cType']; $lenflag=0;}
                if(strlen($content_dataset['cAttrClass'])>5) {$classtext=substr($content_dataset['cAttrClass'],0,5); $lenflag=1;} else {$classtext=$content_dataset['cAttrClass']; $lenflag=0;}*/
                /*if($lenflag)*/ $dots="<a href='#' class='core-no-style' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='".$content_dataset['cAttrClass']."'> <i class='fas fa-ellipsis-h' ></i></a>";
                $dots_dark="<a href='#' style='color:black;' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='".$content_dataset['cAttrClass']."'> <i class='fas fa-ellipsis-h' ></i></a>";/*else $dots="";*/
                echo "<b>".$content_dataset['cType']."</b> ".$content_dataset['cAttrClass'];
                echo "</p>"; //$dots.
            }

            ?>

            <div class="float-right">
                
                <?php if(($content_dataset['cLockedByAdmin']==1 and $this->USER->IS_ADMIN == 1) or ($content_dataset['cLockedByAdmin']==0)){ ?>
                
                <div class="btn-group btn-secondary" role="group">
                    <?php $this->PASTE_COPIED_CONTENT($content_dataset['children'],$content_dataset['cUID'],0); ?>
                    <?php $this->PASTE_CUT_CONTENT($content_dataset['children'],$content_dataset['cUID'],0); ?>
                    <?php $this->CUT_CONTENT($content_dataset['cType'],$content_dataset['cUID'],$content_dataset['cParent'],0); ?>
                    <?php $this->COPY_CONTENT($content_dataset['cType'],$content_dataset['cUID'],$content_dataset['cParent'],0); ?>
                    <?php $this->MOVE_CONTENT($content_dataset['cType'],$content_dataset['realID'],$content_dataset['cParent'],$content_dataset['cPosition'],$content_dataset['cPageUID'],0); ?> 

                    <button type="button" class="btn btn-secondary btn-sm">

                        <a href="#" class="core-no-style"  data-toggle="tooltip" data-html="true" data-placement="bottom" title="<?php echo $this->TXT['edited by:']; echo " <b>".$content_dataset['cLastEditor']."</b><br>"; echo $this->TXT['edited on:']; echo " <b>".date('Y-m-d H:i:s', $content_dataset['cDate'])." GMT</b>"; ?>">
                            <?php echo $content_dataset['realID'];?></a> 
                    <?php
                        if($content_dataset['cStaticTemplate']==1) echo " <i class='fa fa-copyright' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='".$this->TXT['This is a static template.']."'></i>"; if($content_dataset['cStaticCopyOf']!=-1) echo " <i class='fa fa-registered' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='".$this->TXT['This is a static copy.']."'></i>"; ?> </button>

                    <?php $this->ACTIVATE_DEACTIVATE_CONTENT ($content_dataset['cUID'],$content_dataset['cActive'],0); ?>
                    <?php if($this->USER->IS_ADMIN) $this->LOCK_UNLOCK_CONTENT ($content_dataset['cUID'],$content_dataset['cLockedByAdmin'],0); ?>

                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </button>
                      <div class="dropdown-menu core-moreontop" aria-labelledby="dropdownMenuButton">
                        <span class="dropdown-item-text core-relocated">
                            <?php echo "<b>".$content_dataset['cType']."</b>".$dots_dark."<br>"; ?>
                            <div class="btn-group btn-secondary" role="group">
                            <?php $this->PASTE_COPIED_CONTENT($content_dataset['children'],$content_dataset['cUID'],1); ?>
                            <?php $this->PASTE_CUT_CONTENT($content_dataset['children'],$content_dataset['cUID'],1); ?>
                            <?php $this->CUT_CONTENT($content_dataset['cType'],$content_dataset['cUID'],$content_dataset['cParent'],$content_dataset['cPageUID'],1); ?>
                            <?php $this->COPY_CONTENT($content_dataset['cType'],$content_dataset['cUID'],$content_dataset['cParent'],$content_dataset['cPageUID'],1); ?>
                            <?php $this->MOVE_CONTENT($content_dataset['cType'],$content_dataset['realID'],$content_dataset['cParent'],$content_dataset['cPosition'],$content_dataset['cPageUID'],1); ?>
                            <?php $this->ACTIVATE_DEACTIVATE_CONTENT ($content_dataset['cUID'],$content_dataset['cActive'],1); ?>
                            <?php if($this->USER->IS_ADMIN) $this->LOCK_UNLOCK_CONTENT ($content_dataset['cUID'],$content_dataset['cLockedByAdmin'],1); ?>    
                                <button type="button" class="btn btn-secondary btn-sm">
                                    <a href="#" class="core-no-style"  data-toggle="tooltip" data-html="true" data-placement="bottom" title="<?php echo $this->TXT['edited by:']; echo " <b>".$content_dataset['cLastEditor']."</b><br>"; echo $this->TXT['edited on:']; echo " <b>".date('Y-m-d H:i:s', $content_dataset['cDate'])." GMT</b>"; ?>">
                                        <?php echo $content_dataset['realID'];?></a> 
                                <?php
                                    if($content_dataset['cStaticTemplate']==1) echo " <i class='fa fa-copyright' aria-hidden='true' alt='".$this->TXT['This is a static template.']."'></i>"; if($content_dataset['cStaticCopyOf']!=-1) echo " <i class='fa fa-registered' aria-hidden='true' alt='".$this->TXT['This is a static copy.']."'></i>"; ?> 
                                </button>    
                            </div>
                        </span>  
                        <a href="#" class="dropdown-item core-modal-btn" 
                           data-cUID='<?php echo $content_dataset['realID'];?>' 
                           data-cType='<?php echo $content_dataset['cType'];?>'
                           data-pUID='<?php echo $this->PAGE->GET_PAGEVAL('pUID');?>' 
                           data-action-path="core/modals/content.delete.modal.php"><?php echo $this->TXT['delete']; ?></a>

                        <?php if($content_dataset['cStaticCopyOf']==-1) { ?>

                        <a href="#" class="dropdown-item core-modal-btn" 
                           data-cUID='<?php echo $content_dataset['realID'];?>'
                           data-cType='<?php echo $content_dataset['cType'];?>' 
                           data-action-path="core/modals/content.edit.modal.php"><?php echo $this->TXT['edit']; ?></a>

                            <?php if(count($content_dataset['children'])>0){ ?>

                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item core-modal-btn" 
                                       data-cUID='<?php echo $content_dataset['realID'];?>'
                                       data-cType='<?php echo $content_dataset['cType'];?>' 
                                       data-pLanguage='<?php echo $this->PAGE->GET_PAGEVAL('pLanguage');?>'
                                       data-pUID='<?php echo $this->PAGE->GET_PAGEVAL('pUID');?>' 
                                       data-action-path="core/modals/content.new.modal.php"><?php echo $this->TXT['add content']; ?></a>
                        <?php      } 
                            }
                          ?>
                      </div>
                    </div>

                </div> 
                <?php } else { ?>
                
                <i class="fas fa-lock ml-2 mr-2" style="color:white"></i>
                
                <?php } ?>
            </div>
    <?php		
        }

    function ADD_TOPLEVEL_CONTENT()
    { 
            if($this->USER->SHOW_TO_ADMIN()){
                include('core/content/body/_body.config.php');            
                ?>
                <div class="container-fluid core-admin-view">	
                    <div class="float-right">
                        <div class="btn-group btn-secondary" role="toolbar">
                        <?php 
                            $this->PASTE_COPIED_CONTENT($ContentConfig['children'],'');
                            $this->PASTE_CUT_CONTENT($ContentConfig['children'],''); 
                        ?>
                            <div class="dropdown">
                              <button type="button" id="core-new-toplevel-content" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="core-new-toplevel-content">
                                <a href="#" class="dropdown-item core-modal-btn" 
                                   data-cUID='' 
                                   data-cType='body'
                                   data-pLanguage="<?php echo $this->PAGE->GET_PAGEVAL('pLanguage');?>"
                                   data-pUID="<?php echo $this->PAGE->GET_PAGEVAL('pUID');?>" 
                                   data-action-path="core/modals/content.new.modal.php">
                                <?php echo $this->TXT['add content']; ?>
                                </a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php 
            }
    }
	
}//end class




?>