<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];
	
header("Cache-Control: no-cache");

$data=$_POST['data'];    
print_r($data);
    
$original_cUID = $data['copiedContentId']; 
$new_parent = $data['contentId'];
$new_page = $data['pageId']; 
$new_language = $data['pageLanguage'];


$original_data=$DB->PREP_QUERY ('SELECT cUID, cParent, cPageUID, cStaticTemplate, cStaticCopyOf FROM content WHERE cUID=? LIMIT 1', 
                                'content', 
                                array('cUID'),
                                array($original_cUID), 
                                @$DB->SETTINGS['mysqlErrorReporting']);
$original_data=$original_data->fetch_array();

$original_page=$original_data['cPageUID'];
$original_parent=$original_data['cParent'];
	
$original_is_template=$original_data['cStaticTemplate'];
$copied_from_template=$original_data['cStaticCopyOf'];
	
$copier = new copy_content ($DB, $USER);	
	
switch ($original_is_template)
	{
	case 1:
		
		$copier->copy_template($original_data,$new_parent,$new_page,$new_language); //
		
	break;
		
	case 0:
		
		switch ($copied_from_template)
		{
			case -1:
				$copier->copy_standard($original_cUID,$new_parent,$new_page,$new_language);// $copy_what,$copy_where,$new_page,$new_language
			break;
				
			default:
				$copier->copy_template($original_data,$new_parent,$new_page,$new_language);//
			break;	
		}
			
	break;
	}
	


} else {echo "unauthorized access"; exit;}
	
class copy_content
{
	private $DB;

	function __construct($DB, $USER)
		{
			$this->USER = $USER;
			$this->DB = $DB;
			$this->max_counter = 0;
		}

	function copy_template ($original_data,$new_parent,$new_page,$new_language) //
		{
					$THETIME=time();
					
					$getmaxidsql="SELECT MAX(cUID) FROM content";
					$getmaxid=$this->DB->SINGLE_ROW($getmaxidsql);
					$mainid=$getmaxid[0] + 1;
		
					$getmaxpossql="SELECT MAX(cPosition) FROM content";
					$getmaxpos=$this->DB->SINGLE_ROW($getmaxpossql);
					$newpos=$getmaxpos[0] + 5;
                    
                    print_r($original_data);
                    
					$copyprocess = $this->DB->PREP_QUERY ("INSERT INTO content
								  ( cUID
								  ,	cPageUID
								  , cParent
								  , cLanguage
								  , cType
								  , cAttrId
								  ,	cAttrClass
								  ,	cAttrStyle                                  
								  , cPosition
								  , cAnimation
								  , cLazyLoad
								  , cStaticTemplate
								  , cStaticCopyOf
								  , cActive
								  , cDeleted
								  , cDate
								  , cAuthor
								  , cLastEditor
								  )
							 SELECT ?
								  , ?
								  , ?
								  , ?
								  , cType
								  , cAttrId
								  ,	cAttrClass
								  ,	cAttrStyle                                   
								  , ?
								  , cAnimation
								  , cLazyLoad
								  , 0
								  , ?
								  , cActive
								  , cDeleted
								  , ?
								  , ?
								  , ?
							  FROM content WHERE cPageUID = ? AND cUID = ?",
                            'content', 
                            array('cUID','cPageUID','cParent','cLanguage','cPosition','cStaticCopyOf','cDate','cAuthor','cLastEditor','cPageUID','cUID'),
                            array($mainid,$new_page,$new_parent,$new_language,$newpos,$original_data['cUID'],$THETIME,$this->USER->USERVALS['uUser'],$this->USER->USERVALS['uUser'],$original_data['cPageUID'],$original_data['cUID']), 
                            @$DB->SETTINGS['mysqlErrorReporting']); 

							/*echo $copyprocesssql;
							$copyprocess=$this->DB->QUERY($copyprocesssql);*/
		
	
		}
	
	
	function copy_standard ($copy_what,$copy_where,$new_page,$new_language)//
		{	
					$THETIME=time();
					
					
                    $what = $this->DB->PREP_QUERY ('SELECT * FROM content WHERE cUID=? AND cDeleted=0 ORDER BY cPosition ASC LIMIT 1', 
                                'content', 
                                array('cUID'),
                                array($copy_what), 
                                @$DB->SETTINGS['mysqlErrorReporting']);
                    $what=$what->fetch_array();

					$getmaxidsql="SELECT MAX(cUID) FROM content";
					$getmaxid=$this->DB->SINGLE_ROW($getmaxidsql);
					$new_cUID=$getmaxid[0] + 1;	

					$getmaxpossql="SELECT MAX(cPosition) FROM content";
					$getmaxpos=$this->DB->SINGLE_ROW($getmaxpossql);
					$newpos=$getmaxpos[0] + 5;
		
                        $copyprocess = $this->DB->PREP_QUERY ('INSERT INTO content
											  ( cUID
											  ,	cPageUID
											  , cParent
											  , cLanguage
											  , cType
											  , cAttrId
											  ,	cAttrClass
                                              ,	cAttrStyle 
											  , cPosition
											  , cAnimation
											  , cLazyLoad
											  , cStaticTemplate
											  , cStaticCopyOf
											  , cActive
											  , cDeleted
											  , cDate
											  , cAuthor
											  , cLastEditor
											  )
										 SELECT ?
											  , ?
											  , ?
											  , ?
											  , cType
											  , cAttrId
											  ,	cAttrClass
                                              ,	cAttrStyle 
											  , ?
											  , cAnimation
											  , cLazyLoad
											  , 0
											  , -1
											  , cActive
											  , cDeleted
											  , ?
											  , ?
											  , ?
										  FROM content WHERE cPageUID = ? AND cUID = ?', 
                                            'content', 
                                            array('cUID','cPageUID','cParent','cLanguage','cPosition','cDate','cAuthor','cLastEditor',$what['cPageUID'],$what['cUID']),
                                            array($new_cUID,$new_page,$copy_where,$new_language,$newpos,$THETIME,$this->USER->USERVALS['uUser'],$this->USER->USERVALS['uUser'],$what['cPageUID'],$what['cUID']), 
                                            @$DB->SETTINGS['mysqlErrorReporting']);
        
		
										$this->copy_data($what['cUID'],$new_cUID);

                        $what_next = $this->DB->PREP_QUERY ('SELECT * FROM content WHERE cParent=? AND cDeleted=0 ORDER BY cPosition ASC', 
                                'content', 
                                array('cParent'),
                                array($copy_what), 
                                @$DB->SETTINGS['mysqlErrorReporting']);        
        
						
						while($next_child=$what_next->fetch_array()){ //content on same level
		
							$this->copy_standard($next_child['cUID'],$new_cUID,$new_page,$new_language);
							
						} //while children
		} // function copy standard
	
	function copy_data($what,$where)
		{   
            $secondarydata = $this->DB->PREP_QUERY ('SELECT * FROM contentdata WHERE cUID=?', 
                                'contentdata', 
                                array('cUID'),
                                array($what), 
                                @$DB->SETTINGS['mysqlErrorReporting']);
        
			$maxidsql="SELECT MAX(cDataUID) FROM contentdata";
			$maxid=$this->DB->SINGLE_ROW($maxidsql);
			$maxid=$maxid[0]+1;

			if($secondarydata){

            while($contentdataset = $secondarydata->fetch_array()){
 
                $secondaryprocess = $this->DB->PREP_QUERY ('INSERT INTO contentdata
                                                              ( cDataUID
                                                              ,	cUID
                                                              , cDataEnum
                                                              , cDataType
                                                              , cDataContent
                                                              ,	cDataDeleted
                                                              )
                                                         SELECT ?
                                                              ,	?
                                                              , cDataEnum
                                                              , cDataType
                                                              , cDataContent
                                                              ,	cDataDeleted
                                                          FROM contentdata WHERE cDataUID=?', 
                                'contentdata', 
                                array('cDataUID','cUID','cDataUID'),
                                array($maxid,$where,$contentdataset['cDataUID']), 
                                @$DB->SETTINGS['mysqlErrorReporting']);	

				$maxid++;

			}
            }
		
		}// function copy data
	
	
} // class copy_content


?>