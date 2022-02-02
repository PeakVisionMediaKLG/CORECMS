<?php
class BE
{
	public $DB;
	public $USER;
	public $SHOWTOADMIN;
	public $SHOWTOEDITOR;
	
	public $SHOWBE;
	public $BECURRENTAREA;
	public $BECURRENTPAGE;
	public $BELANGUAGES;
	
	function __construct()
	{	
		$this->SHOWBE = $_SESSION['CORE.SHOWBE'] ?? 0;
		$this->BECURRENTAREA = $_SESSION['BE.CURRENTAREA'] ?? "dashboard";
		$this->BECURRENTPAGE = $_SESSION['CORE.CURRENTPAGE'] ?? "dashboard.start";

		$this->BECURRENTPAGE_HEADINCLUDES = "";
		$this->BECURRENTPAGE_BODYINCLUDES = "";
	}
	
	function GETBELANGUAGES()
	{	
		$this->BELANGUAGES = array();
		$dir = new DirectoryIterator(ROOT."core/txt/");
		foreach ($dir as $fileinfo) {
			$this->BELANGUAGES[substr($fileinfo,0, -4)]=substr($fileinfo,0, -4);
			}

		foreach(array_keys($this->BELANGUAGES) as $key)
		{
			if(is_numeric($key) or $key=="") unset($this->BELANGUAGES[$key]);
		}	
		//print_r($this->BELANGUAGES);
	}

	function JS_SESSION_CREATE()
	{
		echo "<script>";
		echo "var JQUERY_DEBUG_CONSOLE = ".$this->DB->jQueryDebugConsole.";";
		echo "var JQUERY_DEBUG_PRINT = ".$this->DB->jQueryDebugPrint.";";
		echo "</script>";

		/*echo "var Core_scroll_pos = '".@$_SESSION['interface']['scroll_pos']."';";
        echo "var Core_js_pUID = '".@$_SESSION['content_copy']['pUID']."';";
		echo "var Core_js_pLanguage = '".@$_SESSION['content_copy']['pLanguage']."';";
		echo "var Core_js_currentMode = '".@$_SESSION['content_copy']['copyMode']."';";
		echo "var Core_js_elementType = '".@$_SESSION['content_copy']['cType']."';";
		echo "var Core_js_copiedContentID = '".@$_SESSION['content_copy']['copyCUID']."';";
		echo "var Core_js_cutContentID = '".@$_SESSION['content_copy']['cutCUID']."';";
        echo "var Core_BackendAnimation = ".$this->DB->SETTINGS["sBackendAnimation"].";"

        //unset($_SESSION['KCFINDER']);;*/
	} 
	
	function INCLUDES()
	{	
		?>
			<script src="required/jquery/jquery-3.5.1.min.js"></script>

			<script src="required/fancybox-master/dist/jquery.fancybox.min.js"></script>
			<link rel="stylesheet" href="required/fancybox-master/dist/jquery.fancybox.min.css">

			<script src="required/chosen-select/chosen.jquery.min.js"></script>
			<link rel="stylesheet" href="required/chosen-select/chosen.min.css">
			

    		<link rel="stylesheet" href="core/css/core.be.css">
		    <script src="core/js/core.functions.js"></script>

			<script> var CKEDITOR_BASEPATH = 'required/ckeditor/';	</script>
			<script src="required/ckeditor/ckeditor.js"></script>
		<?php

		$dir = new DirectoryIterator(ROOT."core/pages/");
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot() and strpos($fileinfo->getFilename(), "_includes")!== false) {
				require_once(ROOT."core/pages/".$fileinfo->getFilename());
			}
		}
		echo $this->BECURRENTPAGE_HEADINCLUDES;

		$this->JS_SESSION_CREATE();
	}
	
	function BODYINCLUDES()
	{
		?><script>$(".chosen-select").chosen();</script><?php	
	}
	
	function BACKEND()
	{		//print_r($_SESSION);
			CARD::PRE(array('class'=>'col-12 g-0 core-be-menu core-card-edgy'));

				ROW::PRE(array('style'=>'position:relative;top:-15px;'));
					COLUMN::PRE(array('class'=>'me-auto col-sm-12 col-md-auto order-2 order-md-1'));
						ROW::PRE(array('class'=>'align-items-center core-be-menu-height'));
							COLUMN::PRE(array('class'=>'col-12 d-md-none'));
								HR::PRINT(array('class'=>'d-md-none','style'=>'height:1px;border-width:0;color:gray;background-color:gray; margin:0'));
							COLUMN::POST();
							COLUMN::PRE(array('class'=>'col-auto'));
								if(@$_SESSION['CORE.EDITMODE']) $currentViewState ="eye-slash-fill"; else $currentViewState ="eye-fill";
						
								BTN::PRE(array(	'class'=>'btn btn-outline-primary core-action-btn',
												'caption'=>BI::GET(array('icon'=>$currentViewState,'size'=>'20',
												'style'=>'position:relative;left:-3px;')),
												'style'=>'max-width:2.5rem;'),
										array(	'data-path'=>'core/actions/session.toggle.value.php',
												'data-thekey'=>'CORE.EDITMODE',
												'data-bs-toggle'=>'button'));
								BTN::POST();
							COLUMN::POST();
							COLUMN::PRE(array('class'=>'col-auto'));
								if($this->SHOWBE) $beActive="active"; else $beActive="";
								BTN::PRE(array(	'class'=>'btn btn-outline-secondary core-toggle-action-btn'." $beActive",
												'caption'=>BI::GET(array('icon'=>'gear','size'=>'20','style'=>'position:relative;left:-3px;')),
												'style'=>'max-width:2.5rem;'),
										 array(	'data-elementtotoggle'=>'.core-be-page',
												'data-toggle'=>'button',
												'data-path'=>'core/actions/session.toggle.value.php',
												'data-thekey'=>'CORE.SHOWBE'));
								BTN::POST();
							COLUMN::POST();	
						ROW::POST();
					COLUMN::POST();

					COLUMN::PRE(array('class'=>'ms-auto col-sm-12 col-md-auto order-1 order-md-2'));
						if($this->USER->AVATAR=="") $this->USER->AVATAR = "core/img/img_avatar_".$this->USER->GENDER.".png";
							ROW::PRE(array('class'=>'align-items-center core-be-menu-height'));
								COLUMN::PRE(array('class'=>'col-auto'));
									IMG::PRINT(array('src'=>$this->USER->AVATAR,'class'=>'','style'=>'border-radius:50% !important; height:7vh;'));
								COLUMN::POST();
								COLUMN::PRE(array('class'=>'col-auto'));
									BTN_DROPDOWN::PRE(array('class'=>'btn-outline-primary w-100','caption'=>BI::GET(array('icon'=>'person','size'=>'16'))."&nbsp;&nbsp;".$this->USER->FIRST_NAME));
										DROPDOWN_ITEM::PRINT(array('class'=>'core-action-btn','caption'=>BI::GET(array('icon'=>'lock','size'=>'16'))."&nbsp;&nbsp;".TXT['Sign out']),array('data-path'=>'core/actions/user.sign.out.php'));
										//DROPDOWN_ITEM::PRINT(array('caption'=>BI::GET(array('icon'=>'gear','size'=>'16'))."&nbsp;&nbsp;".TXT['Manage account'],'href'=>''));		
									BTN_DROPDOWN::POST();
								COLUMN::POST();
							ROW::POST();
					COLUMN::POST();
				ROW::POST();
				/*	*/		
			CARD::POST();
			
			if(!$this->SHOWBE) $hidden="display:none;"; else $hidden="";
			ROW::PRE(array('class'=>'g-0 core-be-page', 'style'=>$hidden));
				COLUMN::PRE(array('class'=>'col-xs-12 col-md-4 col-lg-3 col-xxl-2 core-be-leftmenu'));
					ACCORDION::PRE(array('class'=>'core-be-accordion','id'=>'core-be-accordion'));

						if(substr($this->BECURRENTPAGE,0,strpos($this->BECURRENTPAGE,".")) == "dashboard" or @$_SESSION['CORE.SHOWDASHBOARDAREA']) $showDashboard="show"; else $showDashboard="";
						ACCORDION_ITEM::PRE(array('id'=>'core-be-page-dashboard',
												'parentid'=>'core-be-accordion',
												'heading'=>BI::GET(array('icon'=>'graph-up','size'=>'16'))."&nbsp;&nbsp;".TXT['DASHBOARD'],
												'show'=>$showDashboard,
												'buttonclass'=>'text-start core-action-btn-nr'),
											array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWDASHBOARDAREA')
										);
						ACCORDION_ITEM::POST();	
						
				
						if(substr($this->BECURRENTPAGE,0,strpos($this->BECURRENTPAGE,".")) == "pages" or @$_SESSION['CORE.SHOWPAGESAREA']) $showPages="show"; else $showPages="";
						ACCORDION_ITEM::PRE(array('id'=>'core-be-page-pages',
												'parentid'=>'core-be-accordion',
												'heading'=>BI::GET(array('icon'=>'file-earmark-post','size'=>'16'))."&nbsp;&nbsp;".TXT['PAGES'],
												'show'=>$showPages,
												'buttonclass'=>'text-start core-action-btn-nr'),
											array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWPAGESAREA')
										);
						ACCORDION_ITEM::POST();	

						if(substr($this->BECURRENTPAGE,0,strpos($this->BECURRENTPAGE,".")) == "content" or @$_SESSION['CORE.SHOWCONTENTAREA']) $showContent="show"; else $showContent="";
						ACCORDION_ITEM::PRE(array('id'=>'core-be-page-content',
												'parentid'=>'core-be-accordion',
												'heading'=>BI::GET(array('icon'=>'diagram-3','size'=>'16'))."&nbsp;&nbsp;".TXT['CONTENT'],
												'show'=>$showContent,
												'buttonclass'=>'text-start core-action-btn-nr'),
											array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWCONTENTAREA')
										);

										A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'cloud-arrow-down','size'=>'16'))."&nbsp;&nbsp;".TXT['Includes']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'content.includes'));
										A::POST();

						ACCORDION_ITEM::POST();

						
						if($this->BECURRENTAREA == "files" or @$_SESSION['CORE.SHOWFILESAREA']) $showFiles="show"; else $showFiles="";
						ACCORDION_ITEM::PRE(array('id'=>'core-be-files',
												  'parentid'=>'core-be-accordion',
												  'heading'=>BI::GET(array('icon'=>'folder','size'=>'16'))."&nbsp;&nbsp;".TXT['FILES'],
												  'show'=>$showFiles,
												  'buttonclass'=>'text-start core-action-btn-nr'),
											array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWFILESAREA')
										   );
							if($this->USER->IS_ADMIN){	
								A::PRE(array('class'=>'btn btn-outline-secondary text-start iframe-btn w-100','href'=>'required/filemanager/filemanager/dialog.php?type=0','caption'=>BI::GET(array('icon'=>'folder-plus','size'=>'16'))."&nbsp;&nbsp;".TXT['File manager']));
								A::POST();
							}
						ACCORDION_ITEM::POST();	
						
						
						if(substr($this->BECURRENTPAGE,0,strpos($this->BECURRENTPAGE,".")) == "system" or @$_SESSION['CORE.SHOWSYSTEMAREA']) $showSystem="show"; else $showSystem="";							
						ACCORDION_ITEM::PRE(array('id'=>'core-be-system',
													'parentid'=>'core-be-accordion',
													'heading'=>BI::GET(array('icon'=>'gear','size'=>'16'))."&nbsp;&nbsp;".TXT['SYSTEM'],
													'show'=>$showSystem,
													'buttonclass'=>'text-start core-action-btn-nr'),
												array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWSYSTEMAREA')
											);
											
							if($this->USER->IS_ADMIN){					
								A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'sliders','size'=>'16'))."&nbsp;&nbsp;".TXT['Settings']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'system.settings'));
								A::POST();

								/*A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'globe2','size'=>'16'))."&nbsp;&nbsp;".TXT['Localization']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'system.localization'));
								A::POST();*/

								A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'card-list','size'=>'16'))."&nbsp;&nbsp;".TXT['Value sets']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'system.valuesets'));
								A::POST();
							}
							A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'people','size'=>'16'))."&nbsp;&nbsp;".TXT['Users']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'system.users'));
							A::POST();

						ACCORDION_ITEM::POST();
						if($this->USER->IS_ADMIN){
							if(@$_SESSION['CORE.SHOWDBAREA']) $showDatabase="show"; else $showDatabase="";	
							ACCORDION_ITEM::PRE(array('id'=>'core-be-database',
													'parentid'=>'core-be-accordion',
													'heading'=>BI::GET(array('icon'=>'archive','size'=>'16'))."&nbsp;&nbsp;".TXT['DATABASE'],
													'show'=>$showDatabase,
													'buttonclass'=>'text-start core-action-btn-nr'),
														array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWDBAREA')
													);

								/*A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'file-earmark-arrow-down-fill','size'=>'16'))."&nbsp;&nbsp;".TXT['Backup']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'database.backup'));
								A::POST();*/

								A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'file-earmark-arrow-up','size'=>'16'))."&nbsp;&nbsp;".TXT['Backup & Recovery']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'database.recovery'));
								A::POST();
	
								A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'file-earmark-text','size'=>'16'))."&nbsp;&nbsp;".TXT['Log']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'database.log'));
								A::POST();

							ACCORDION_ITEM::POST();	

							if($this->BECURRENTAREA == "tools" or @$_SESSION['CORE.SHOWTOOLSAREA']) $showTools="show"; else $showTools="";
							ACCORDION_ITEM::PRE(array('id'=>'core-be-files',
													  'parentid'=>'core-be-accordion',
													  'heading'=>BI::GET(array('icon'=>'tools','size'=>'16'))."&nbsp;&nbsp;".TXT['TOOLS'],
													  'show'=>$showTools,
													  'buttonclass'=>'text-start core-action-btn-nr'),
												array('data-path'=>'core/actions/session.toggle.value.php','data-thekey'=>'CORE.SHOWTOOLSAREA')
											   );
								
								if($this->USER->IS_SYSTEMADMIN){
									A::PRE(array('role'=>'button','class'=>'btn btn-outline-secondary core-action-btn text-start w-100 mb-2','caption'=>BI::GET(array('icon'=>'info-square','size'=>'16'))."&nbsp;&nbsp;".TXT['PHP Info']), array('data-path'=>'core/actions/session.set.value.php','data-thekey'=>'CORE.CURRENTPAGE','data-thevalue'=>'system.phpinfo'));
									A::POST();	
								}
								
							ACCORDION_ITEM::POST();	

							ACCORDION_ITEM::PRE(array('id'=>'core-acc-extensions','parentid'=>'core-menu-accordion','heading'=>BI::GET(array('icon'=>'hexagon-half','size'=>'16'))."&nbsp;&nbsp;".TXT['EXTENSIONS'],'buttonclass'=>'text-start'));
						
							ACCORDION_ITEM::POST();
						}							
					ACCORDION::POST();
				COLUMN::POST();

				COLUMN::PRE(array('class'=>'col-xs-12 col-md-8 col-lg-9 col-xxl-10 g-3'));

					ROW::PRE();
						COLUMN::PRE(array('class'=>'core-alert-space'));
							HTML::PRINT(array('content'=>'<PRE>'));
							if(isset($_SESSION['CORE.ACTIONMESSAGE']))
							{	
								foreach($_SESSION['CORE.ACTIONMESSAGE'] as $key => $value)
								{	
									ALERT::PRE(array('class'=>'alert-info w90 mx-auto text-break','dismissable'=>'dismissable'));
										echo $value;
									ALERT::POST();
								}
							}
							HTML::PRINT(array('content'=>'</PRE>'));
						COLUMN::POST();
					ROW::POST();
					//print_r($_SESSION);
					require_once(ROOT."core/pages/$this->BECURRENTPAGE.php");
				COLUMN::POST();
			ROW::POST();

			IFRAME::PRINT(array('name'=>'core-fe-preview-frame','src'=>'preview.php','class'=>'core-fe-preview-frame'));

			echo $this->BECURRENTPAGE_BODYINCLUDES;
	}

	function LOADVALUESET($name=NULL,$useCaptions=0)
	{
		$theValues = $this->DB->EASY_QUERY( "SELECT", 
												"core_values",
												array('name','value','caption_en'),
												array(),
												array(),
												array(),
												"ORDER BY name ASC"
												);	
		
		if($name)
		{
			$theValueset = $this->DB->EASY_QUERY( "SELECT", 
												"core_valuesets",
												array('contained_values'),
												array(),
												array('name'),
												array($name)
												);
			$theValueset = $theValueset->fetch_array();
			$theValueset = $theValueset['contained_values'];
			$theValueset = json_decode($theValueset);
		}
		
		$allValues=array();
		
		while($valueSetRow = $theValues->fetch_array())
		{
			if((isset($theValueset) and in_array($valueSetRow['name'],$theValueset)) or !$name) 
			{
				if($useCaptions)
				{
					/*echo $this->USER->PREFERRED_LANGUAGE,$valueSetRow['value'] ;
					$theCaption = $this->DB->EASY_QUERY( "SELECT", 
										"be_captions",
										array($this->USER->PREFERRED_LANGUAGE),
										array(),
										array('name'),
										array($valueSetRow['caption'])
										);	
					$theCaption = $theCaption->fetch_array();

					$theCaption = 
					$theCaption = $theCaption[$this->USER->PREFERRED_LANGUAGE];*/

					$theCaption = $valueSetRow['caption_'.$this->USER->PREFERRED_LANGUAGE]; //$theCaption = TXT[$valueSetRow['caption_en']];

					$allValues[$theCaption]=$valueSetRow['name'];
				}
				else  $allValues[$valueSetRow['name']]=$valueSetRow['name']; 
			}
		}
		return $allValues;
	}

	function GET_VALUESETS()
	{
		$theValuesets = $this->DB->EASY_QUERY( "SELECT", 
												"core_valuesets",
												array('*'),
												array(),
												array(),
												array()
												);
		$allValuesets = array();

		while($valueSetRow = $theValuesets->fetch_array())
		{
			//print_r($valueSetRow);
			$allValuesets[$valueSetRow['caption_'.$this->USER->PREFERRED_LANGUAGE]]=$valueSetRow['name'];
		}

		return $allValuesets;
	}

	function GET_CAPTION($name,$table)
	{
		$theCaption = $this->DB->EASY_QUERY( 	"SELECT", 
												$table,
												array('caption_'.$this->USER->PREFERRED_LANGUAGE),
												array(),
												array('name'),
												array($name)
												);
		$theCaption = $theCaption->fetch_array();
		$theCaption = $theCaption['caption_'.$this->USER->PREFERRED_LANGUAGE];	
		return $theCaption;	
	}


}
?>