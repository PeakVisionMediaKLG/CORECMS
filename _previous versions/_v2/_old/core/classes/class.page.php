<?php
class PAGE 
{
public 	    $DB;   			
public  	$URL;			
public 		$PAGEVALS;		
public		$VALID_URLS;	
public      $ALL_PAGES_ARRAY;

function __construct($DB,$url)
	{
		$this->DB = $DB;
		
		$this->URL = $url;
		
		
		$this->VALID_URLS = $DB->MULTI_ROW("SELECT pURL, pActive FROM pages WHERE pDeleted=0");
		$url_isvalid=0;
		$default_url_isvalid=0;
	
		while($row = $this->VALID_URLS->fetch_array())
		{
			if($row['pURL']==$this->URL) $url_isvalid=1;
            if($row['pURL']==$this->DB->SETTINGS['default_URL']) $default_url_isvalid=1; else $default_url_isvalid=0;
		}
		
		if($url_isvalid==0 and $default_url_isvalid==1) 
            {
                $this->URL = $this->DB->SETTINGS['default_URL'];
            } // redirect to default page
        elseif($url_isvalid==0 and $default_url_isvalid==0) 
            {
                $this->URL = $this->DB->SINGLE_ROW('SELECT pURL FROM pages WHERE pUID = (SELECT MIN(pUID) FROM pages)');
                $this->URL=$this->URL['pURL'];
            }// redirect to first available page
				
		$this->PAGEVALS = $DB->SINGLE_ROW("SELECT pages.* FROM pages WHERE pages.pURL = '$this->URL'");
		
		if (count($this->PAGEVALS) != 0) {
			array_walk($this->PAGEVALS,array(&$this, 'STRIP_PAGE'));
		}
		
        $this->ALL_PAGES_ARRAY = $this->COMPLETEPAGESET(); 
    
		$_SESSION['Session_pUID'] = $this->PAGEVALS['pUID'];

	}
    
    
function JS_SESSION_CREATE()
	{
		echo "<script>";
		echo "var Core_scroll_pos = '".@$this->DB->SESSIONDATA->GET_VAL('interface','scroll_pos')."';";
        echo "var Core_js_pUID = '".$this->PAGEVALS['pUID']."';";
		echo "var Core_js_pLanguage = '".$this->PAGEVALS['pLanguage']."';";
		echo "var Core_js_currentMode = '".@$_SESSION['current_mode']."';";
		echo "var Core_js_elementType = '".@$_SESSION['element_type']."';";
		echo "var Core_js_copiedContentID = '".@$_SESSION['copied_content_id']."';";
        echo "var Core_jQueryDebugging = '".$this->DB->SETTINGS["jQueryDebugging"]."';";
		echo "</script>";
        unset($_SESSION['KCFINDER']);
	}
	
	
function STRIP_PAGE(&$item1, $key)
	{
		$item1 = stripslashes($item1);
		return $item1;
	}
	
	
function GET_PAGEVAL($which_val)
	{	
		return $this->PAGEVALS[$which_val];
	}

    
function COMPLETEPAGESET()
	{
		$allitems=$this->DB->MULTI_ROW("SELECT * FROM pages WHERE pDeleted=0 ORDER BY pNavPosition ASC");
		$allitemsfetched=array();

		$allitemscounter=0;
            
			while($allitemsrow=$allitems->fetch_array()){
                foreach ($allitemsrow as $key => $value)
				
                $allitemsfetched[$allitemscounter][$key]=$allitemsrow[$key];    
                    
				$allitemscounter++;
			}
		return $allitemsfetched;
		}

}
?>