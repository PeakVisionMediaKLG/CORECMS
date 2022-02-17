<?php
/*
--------------------------------------------
WebYurt.com - Resource license terms
---------------------------------------------
The Web Yurt TinyMCE Image Manager plugin is free for use in personal website projects.
For use in commercial websites, a donation is required to the PayPal email address: info@webyurt.com

You can modify this resource to your requirements to fit into your own projects, however we do not accept responsibility for any misuse.

We would appreciate a link back to WebYurt.com, in order to help spread the word about us so we can continue our work.

Redistribution, reselling, leasing, licensing, sub-licensing or offering this resource to any third party is strictly prohibited. This includes uploading our resources to another website, marketplace or media-sharing tool, and offering our resources as a separate attachment from any of your work. If you do plan to include this resource on any project that will be sold on a website or marketplace, please contact us first to determine the proper use of our resource.

HOTLINKING is strictly prohibited i.e. you cannot make a direct link to the actual download file for this resource. For any attribution, please link to the page where the resource can be downloaded from on WebYurt.com.

These license terms are subject to change at any time without prior notice.

---------------------------------------------
Regards,
The WebYurt.com Team.
---------------------------------------------
http://www.webyurt.com

*/

class Pagination{

	public $Page = 1;
	public $PerPage = 10;
	public $Adjacents;
	public $TotalRecords;
	public $Start;
	public $URL = '?';
	
	#--------------------------
	# START LIMIT
	#--------------------------
	public function GetStartLimit() {
		if (isset($_GET['page'])){$this->Page = $_GET['page'];}
			if($this->Page){
				$this->Start = ($this->Page - 1) * $this->PerPage; 		#FIRST ITEM TO DISPLAY
			} else {
				$this->Start = 0;										#DEFAULT 0, IF NO PAGE GIVEN
			}
		}
	#--------------------------
	# TOTAL RECORDS
	#--------------------------
	public function GetTotalRecords($sql){
		if ($sql != NULL) {
			$TotalRecords = FetchRows(ExecuteSQL($sql));
			$this->TotalRecords = $TotalRecords['Total'];
			return $this->TotalRecords;
		}
		}
	#--------------------------
	# TOTAL PAGES
	#--------------------------
	public function GetTotalPages(){
		return ceil($this->TotalRecords/$this->PerPage);
		}
		
    #--------------------------
    # PAGING
    #-------------------------- 
    public function GetPageNumbers(){
		$QS='';
		
		$URL = $this->URL;
		
		if (! IsEmpty($_SERVER['QUERY_STRING'])){
			$QS = RemoveVarFromURL('page', $_SERVER['QUERY_STRING']);
			if (! IsEmpty($QS)) $QS = "&$QS"; 
		}
						
    	$page = ($this->Page == 0 ? 1 : $this->Page);  
    	$start = ($this->Page - 1) * $this->PerPage;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = $this->GetTotalPages();
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	
		if($lastpage > 1) {
    		
			$pagination .= "<ul class='pager'>";
            # DETAIL
			#$pagination .= "<li class='details'>Page $page of $lastpage</li>";
			
			 # PREVIOUS
			if ($page > 1) {
				$pagination.= "<li><a href='".$URL."page=$prev".$QS."'>&laquo; Previous</a></li>";
			}
			
			# FIRST 7 NUMBERS
			if ($lastpage < 7 + ($this->Adjacents * 2)){	
    			for ($counter = 1; $counter <= $lastpage; $counter++){
    				if ($counter == $page)
    					$pagination.= "<li class='current'>$counter</li>";
    				else
    					$pagination.= "<li><a href='".$URL."page=$counter".$QS."'>$counter</a></li>";					
    			}
    		}
			
			# > 5 - 
    		elseif($lastpage > 5 + ($this->Adjacents * 2)){
    			if($page < 1 + ($this->Adjacents * 2)) {
    				for ($counter = 1; $counter < 4 + ($this->Adjacents * 2); $counter++) {
    					if ($counter == $page)
    						$pagination.= "<li class='current'>$counter</li>";
    					else
    						$pagination.= "<li><a href='".$URL."page=$counter".$QS."'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";	# RIGHT HAND
    				$pagination.= "<li><a href='".$URL."page=$lpm1".$QS."'>$lpm1</a></li>";
    				$pagination.= "<li><a href='".$URL."page=$lastpage".$QS."'>$lastpage</a></li>";		
    			} 
				elseif($lastpage - ($this->Adjacents * 2) > $page && $page > ($this->Adjacents * 2)){
    				$pagination.= "<li><a href='".$URL."page=1".$QS."'>1</a></li>";
    				$pagination.= "<li><a href='".$URL."page=2".$QS."'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $this->Adjacents; $counter <= $page + $this->Adjacents; $counter++){
    					if ($counter == $page)
    						$pagination.= "<li class='current'>$counter</li>";
    					else
    						$pagination.= "<li><a href='".$URL."page=$counter".$QS."'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='".$URL."page=$lpm1".$QS."'>$lpm1</a></li>";
    				$pagination.= "<li><a href='".$URL."page=$lastpage".$QS."'>$lastpage</a></li>";		
    			} 
				else {
    				$pagination.= "<li><a href='".$URL."page=1".$QS."'>1</a></li>";
    				$pagination.= "<li><a href='".$URL."page=2".$QS."'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $lastpage - (2 + ($this->Adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li class='current'>$counter</li>";
    					else
    						$pagination.= "<li><a href='".$URL."page=$counter".$QS."'>$counter</a></li>";					
    				}
    			}
    		}
    		
			# NEXT LAST
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='".$URL."page=$next".$QS."'>Next &raquo;</a></li>";
                #$pagination.= "<li><a href='".$URL."page=$lastpage".$QS."'>Last</a></li>";
    		}
			
    		$pagination.= "</ul>\n";		
    	} 
      return $pagination;
    }

}
?>