<?php 

class ADMIN
{
	public 	$DB;
	public 	$PAGE;
	public  $USER;

    public  $TEMP_PARENTS;
	
    function __construct($DB,$PAGE,$USER)
        {
            $this->DB = $DB;
            $this->PAGE = $PAGE;
            $this->USER = $USER;	

            $languagetoload = $this->USER->GET_USERVAL("uLanguage") ?? 'EN';
            include('txt/'.$languagetoload.'.php');
            $this->TXT = $TXT;
        
            $this->TEMP_PARENTS = "";
            $this->parent_indent=0;

        }
    
    function TOOLBAR()
        {
        ?>
        <div class="core-view-switch">
            <button type="button" class="btn btn-secondary core-action-btn"  
                    data-action-path="core/actions/toggle.toolbar.php"
                    data-input1="checked">
                <i class="<?php if($this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==0) echo "fas fa-eye"; else echo "far fa-eye-slash";?>" aria-hidden="true"></i>
            </button>
        </div>
        <div class="row no-gutters">
                <?php if($this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1){ ?>			
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 core-admin-toolbar card core-card-edgy core-fixed-pos">
                            <div class="card-body">
                                
                                <div class="dropdown">
                                  <a class="btn btn-outline-primary dropdown-toggle text-left" href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-user"></i> <?php echo substr($this->USER->GET_USERVAL("uFirstName"),0,1).". ".$this->USER->GET_USERVAL("uLastName"); ?>
                                  </a>

                                  <div class="dropdown-menu" aria-labelledby="dropdownUser">
                                    <a class="dropdown-item core-action-btn" data-action-path="core/actions/sign.out.php" href="#"><i class="fas fa-sign-out-alt"></i> <?php echo $this->TXT['sign out']; ?></a>
                                  </div>
                                </div><br>
                                <?php 
                                        if($this->DB->SESSIONDATA->GET_VAL('interface','toolbar_expand_system')==1) 
                                            {$accordion_upper=""; $accordion_lower="-open";} 
                                        else 
                                            {$accordion_upper="-open";$accordion_lower="";}      
                                ?>
                                <button type='button btn text-left' class='core-accordion'><b class="core-accordion-header"> <?php echo $this->TXT['web']; ?></b> <i class="fas fa-caret-down"></i></button>
                                    <div class='core-panel<?php echo $accordion_upper; ?>'>
                                        <p>
                                            <?php if($accordion_lower=="-open"){ ?>    
                                            <button type="button" class="btn btn-outline-secondary text-left" onclick="location.href = 'show.php?url=<?php echo $this->PAGE->GET_PAGEVAL('pURL'); ?>'">
                                                <i class="fas fa-th"></i> <?php echo $this->TXT['show pages']; ?>
                                            </button> 
                                            <?php } ?>    
                                        <?php $this->SHOW_LANGUAGE_MENU(); ?>
                                        <br><br>
                                        	
                                            <h2><?php echo $this->TXT['navigate']; ?></h2>

                                            <select class='form-control core-page-navigator' name='' onchange="window.open(this.options[this.selectedIndex].value,'_top')">
                                                    <?php $this->POPULATE_NAVSELECT(); ?>
                                            </select>
                                        <?php if($this->USER->IS_ADMIN==1){?>
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left"  
                                                    data-action-path="core/modals/page.new.modal.php"
                                                    data-pUID="<?php echo $this->PAGE->GET_PAGEVAL("pUID"); ?>">
                                                <i class="far fa-file" aria-hidden="true"></i> <?php echo $this->TXT['new page']; ?>
                                            </button>
                                            <?php if($this->PAGE->GET_PAGEVAL('pUID')!="") {?>
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left" 
                                                    data-action-path="core/modals/page.edit.modal.php"
                                                    data-pSharedID="<?php echo $this->PAGE->GET_PAGEVAL("pSharedID");?>"
                                                    data-pLanguage="<?php echo $this->PAGE->GET_PAGEVAL("pLanguage"); ?>"
                                                    data-pUID="<?php echo $this->PAGE->GET_PAGEVAL("pUID"); ?>">
                                                <i class="far fa-edit" aria-hidden="true"></i> <?php echo $this->TXT['edit page']; ?>
                                            </button>

                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left"  
                                                    data-action-path="core/modals/page.delete.modal.php" 
                                                    data-pUID="<?php echo $this->PAGE->GET_PAGEVAL("pUID"); ?>"
                                                    data-pLinkText="<?php echo $this->PAGE->GET_PAGEVAL("pLinkText"); ?>"
                                                    data-pSharedID="<?php echo $this->PAGE->GET_PAGEVAL("pSharedID"); ?>"
                                                    data-pParent="<?php echo $this->PAGE->GET_PAGEVAL("pParent"); ?>">
                                                <i class="far fa-trash-alt" aria-hidden="true"></i> <?php echo $this->TXT['delete page']; ?>
                                            </button>
                                            <?php } } ?>
                                        </p>
                                    </div>    
                                <button type='button btn text-left' class='core-accordion'><b class="core-accordion-header"> <?php echo $this->TXT['files']; ?></b> <i class="fas fa-caret-down"></i></button>
                                    <div class='core-panel<?php echo $accordion_upper; ?>'><br>
                                        <p>
                                            <button type="button" class="btn btn-outline-secondary text-left" onclick="openKCFinder(this)" >
                                                <i class="far fa-file-image" aria-hidden="true"></i> <?php echo $this->TXT['file manager']; ?>
                                            </button><br>
                                        </p>
                                    </div>                                 
                                <?php if($this->USER->IS_ADMIN==1){?> 
                                <button type='button btn text-left' class='core-accordion'><b class="core-accordion-header"> <?php echo $this->TXT['system']; ?></b> <i class="fas fa-caret-down"></i></button>
                                    <div class='core-panel<?php echo $accordion_lower; ?>'><br>
                                        <p>
                                            <button type="button" class="btn btn-outline-secondary text-left" onclick="location.href = 'system.php?mode=configuration';">
                                                <i class="fas fa-cogs"></i> <?php echo $this->TXT['configuration']; ?>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary text-left" onclick="location.href = 'system.php?mode=languages';">
                                                <i class="fas fa-globe-americas"></i> <?php echo $this->TXT['languages']; ?>
                                            </button>                                            
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left" onclick="location.href = 'system.php?mode=event.log';">
                                                <i class="fas fa-terminal"></i> <?php echo $this->TXT['event log']; ?>
                                            </button>                                            
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left" onclick="location.href = 'system.php?mode=users';">
                                                <i class="far fa-user fa-sm"></i> <?php echo $this->TXT['users']; ?>
                                            </button>

                                        </p>
                                    </div> 
                                 <button type='button btn text-left' class='core-accordion'><b class="core-accordion-header"> <?php echo $this->TXT['extensions']; ?></b> <i class="fas fa-caret-down"></i></button>
                                    <div class='core-panel<?php echo $accordion_lower; ?>'><br>
                                        <p>
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left" onclick="location.href = 'system.php?mode=extensions';">
                                                <i class="fas fa-boxes"></i> <?php echo $this->TXT['extension manager']; ?>
                                            </button>                                            
                                            <button type="button" class="btn btn-outline-secondary core-modal-btn text-left" onclick="location.href = 'system.php?mode=themes';">
                                                <i class="fab fa-trello"></i> <?php echo $this->TXT['theme manager']; ?>
                                            </button>
                                        </p>
                                    </div>                                 
                                    	


                                
                                
                                <?php }?>	

                            </div>
                    </div>
                    <?php } ?>
                    <div class="<?php if($this->DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1){ echo"core-admin-viewport col-sm-6 col-md-6 col-lg-8 col-xl-10 ml-auto";} else {echo "col-12";} ?>">
        <?php
        }


    function SHOW_LANGUAGE_MENU()
        {
            echo "<h2>".$this->TXT['switch language']."<br><br>"; 

                $complete_page_set=$this->PAGE->COMPLETEPAGESET();
                $config_languages = $this->DB->MULTI_ROW('SELECT * FROM languages');
                
                while($config_language = $config_languages->fetch_array()){
                
                for($y=0;$y<count($complete_page_set);$y++){ 
                            
                            if($config_language['lLanguageCode']==$this->PAGE->GET_PAGEVAL('pLanguage')) $activelanguage="core-active-language"; else $activelanguage="";

                            if(($complete_page_set[$y]['pSharedID']==$this->PAGE->GET_PAGEVAL('pSharedID')) and ($complete_page_set[$y]['pLanguage']==$config_language['lLanguageCode']))
                            {
                                echo "<a href='show.php?url=".$complete_page_set[$y]['pURL']."' class='$activelanguage'>".$config_language['lShortCaption']."</a> ";
                            }    
                        }    
                    
                    
                }
            echo "</h2>";
        }

    
    function TOOLBAR_CLOSETAGS()
        {
            echo "</div></div>";
        }

    
    function POPULATE_PARENTSELECT ($currentparent,$originalelement,$currentlanguage,$preselect=0)
    {
            $myoriginalelement = $this->GET_ARRAYKEY($originalelement,'pUID', $this->PAGE->ALL_PAGES_ARRAY) ?? 1; 
            //print_r($this->PAGE->ALL_PAGES_ARRAY[$myoriginalelement]);    
            $this->parent_indent++;
                
            for($i=0;$i<count($this->PAGE->ALL_PAGES_ARRAY);$i++)
            {
                
                if(($this->PAGE->ALL_PAGES_ARRAY[$i]['pLanguage']==$currentlanguage) 
                       and ($this->PAGE->ALL_PAGES_ARRAY[$i]['pParent']==$currentparent))
                {
                    $indent = str_repeat("&nbsp;",$this->parent_indent);
                    
                    if($this->PAGE->ALL_PAGES_ARRAY[$i]['pSharedID']==@$this->PAGE->ALL_PAGES_ARRAY[$myoriginalelement]['pParent']) $parentselected="selected"; else $parentselected="";
                    
                    if($this->PAGE->ALL_PAGES_ARRAY[$i]['pActive']==0) $deactivated=" core-select-grayedout"; else $deactivated="";
                    
                    if($this->PAGE->ALL_PAGES_ARRAY[$i]['pUID']==@$this->PAGE->ALL_PAGES_ARRAY[$myoriginalelement]['pUID']) $disableoption=" disabled"; else $disableoption="";

                    $this->TEMP_PARENTS .="<option value='".$this->PAGE->ALL_PAGES_ARRAY[$i]['pSharedID']."' class='$deactivated' $parentselected $disableoption>".$indent.$this->PAGE->ALL_PAGES_ARRAY[$i]['pLinkText']."</option>";
                    
                    $this->POPULATE_PARENTSELECT ($this->PAGE->ALL_PAGES_ARRAY[$i]['pSharedID'],$originalelement,$currentlanguage,$preselect);
                    
                }
                
            }
            $this->parent_indent--;
    } 
    
    
    function GET_ARRAYKEY($whattolookfor, $wheretolook, $array) {
       foreach ($array as $key => $val) {
           if ($val[$wheretolook] === $whattolookfor) {
               return $key;
           }
       }
       return null;
    }
    

    function POPULATE_NAVSELECT()
        {
            $get_all_pages_sql="SELECT pSharedID, pURL, pParent, pLinkText, pActive, pNavPosition FROM pages WHERE pLanguage='".$this->PAGE->GET_PAGEVAL("pLanguage")."' AND pDeleted=0 ORDER BY pNavPosition ASC";
            $allpages=$this->DB->MULTI_ROW($get_all_pages_sql);

            $allpages_array=array();
            while($currentpage=$allpages->fetch_array())
            {
                array_push($allpages_array,$currentpage);
            }

            $this->looper_indent=0;
            $this->POPULATE_LOOPER("",$allpages_array,$this->PAGE->GET_PAGEVAL("pSharedID"));

        }

    
    function POPULATE_LOOPER($parent,$allpages_array,$thecurrentpage)
        {		echo $this->looper_indent;
                $this->looper_indent++;

                 for($i=0;$i<count($allpages_array);$i++)
                    {
                        if ($allpages_array[$i]['pParent']==$parent)
                        { 
                            if($allpages_array[$i]['pSharedID']==$thecurrentpage) $selected="selected"; else $selected="";
                            if($allpages_array[$i]['pActive']==0) $deactivated=" core-select-grayedout"; else $deactivated=""; 

                            $indent=str_repeat("&nbsp;",$this->looper_indent);
                            echo"<option value='show.php?url=".$allpages_array[$i]['pURL']."' class='$deactivated' $selected>".$indent.$allpages_array[$i]['pLinkText']."</option>"; 

                            $this->POPULATE_LOOPER($allpages_array[$i]['pSharedID'],$allpages_array,$thecurrentpage);
                        }
                    }
                $this->looper_indent--;
        }
}			
