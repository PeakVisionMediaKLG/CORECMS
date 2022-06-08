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

class Upload {
 
   public $InstanceName = '';
   public $Msg = '';
   public $UploadDir = '/';
   public $arrEXT = array();
   public $MaxSize = 0;
   public $Ext = '';
   public $NewFileName = '';
   public $UploadedFile = '';
   
   
   # SET ALLOWED EXTENSION
   public function SetExts($array) {   
    $node_array = explode(',', $array); 
		foreach($node_array as $item) {
		 array_push($this->arrEXT, $item);
    	}     
   }
   
   # RETURN SET UPLOAD DIR
   public function SetUploadDir($dir) {
    $this->UploadDir = $dir;    
   }
   
   # SET MAX SIZE
   public function SetMaxSize($int) {
    $this->MaxSize = $int * 1024; 
   }
   
   # SET NEW NAME
   public function NewFileName($str) {
    $this->NewFileName = $str;
   }
	
   # DELETE FILE
   public function DeleteFile($file){
		if(file_exists($file)){
			# e("DELETED: $file");
			unlink($file);
		return true;
		}
   }
   
   # GETS FILE EXTENSION FROM FILE NAME
   public function GetExt($FileName){	
	$Ext = substr($FileName, strrpos($FileName, '.')+1);
	$Ext = strtolower($Ext);
	return $Ext;
   }
   
   # FORMAT BYTES
   public function FormatBytes($size, $precision = 2) {
    $base = log($size) / log(1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
   }
   
	# --------------------------
	# UPLOAD
	#---------------------------
	function IsValidImageType($file) {
		$Type = @getimagesize($file); # FALSE IF NOT VALID IMAGE
		$IsValid = 0;
		#d($Type);

		if($Type) { 
			$ValidTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
			if(in_array($Type[2],  $ValidTypes)) {
				$IsValid = 1;
			}
		}
		return $IsValid;
	}
   
   
   
	#---------------------------
	# UPLOAD IMAGES ONLY
	#---------------------------
	function UploadImage($Instance) {
	  global $InstanceName;
	  global $UploadDir;
	  global $UploadedFile;
	  
	  $InstanceName = $Instance;     
	  #$MaxSizeKB = $this->MaxSize/1024;
			   
	  if(strlen($this->UploadDir) <= 0) {   
		  $this->Msg = 'No Folder Selected!';
		  return $this->Msg;
		  exit;
	  }
	 
	  if(isset($_FILES[$InstanceName]) && strlen($_FILES[$InstanceName]['name'])>0) {
		 
		 # FILE NAME
		 if($_FILES[$InstanceName]['error'] > 0) {  
			$this->Msg = 'File Name Error!';
			return $this->Msg;
			exit;
		 }
		 # SIZE
		 if($_FILES[$InstanceName]['size'] > $this->MaxSize) {
			$this->Msg = 'File Size is too large, Max allowed size: '.$this->FormatBytes($this->MaxSize,0);
			return $this->Msg;
			exit;
		 }
		 # EXTENSION
		 $node_array = explode('.', $_FILES[$InstanceName]['name']);      
		 $fExt = strtolower(end($node_array));
		 $this->Ext = $fExt;
			  
			  # EXTESION CHECK
			  if(!in_array($fExt, $this->arrEXT)) {
				$this->Msg = 'File Extension Not Allowed!';
				return $this->Msg;
				exit;
			  }
		
		 # FILE TYPE
		 $FileTypeStatus = $this->IsValidImageType($_FILES[$InstanceName]['tmp_name']);
		 if ($FileTypeStatus === 0){
			$this->Msg = 'File Type Not Allowed!';
			return $this->Msg;
			exit;
		 }
		
		 try {   
		  # NEW FILE NAME
		  if(strlen($this->NewFileName)>0) {
			$UploadedFile = $this->NewFileName;
		  }else {
			$UploadedFile = basename($_FILES[$InstanceName]['name']);
		  }

			$process = move_uploaded_file($_FILES[$InstanceName]['tmp_name'], $this->UploadDir.$UploadedFile);
			
			#return $UploadedFile;
			
		 } catch (Exception $e) {
			return 'Error uploading!';
		 }   
	  }      
   }
   
   
   	#---------------------------
	# UPLOAD
	#---------------------------
	function UploadFile($Instance) {
	  global $InstanceName;
	  global $UploadDir;
	  global $UploadedFile;
	  
	  $InstanceName = $Instance;     
	  #$MaxSizeKB = $this->MaxSize/1024;
			   
	  if(strlen($this->UploadDir) <= 0) {   
		  $this->Msg = 'No Folder Selected!';
		  return $this->Msg;
		  exit;
	  }
	 
	  if(isset($_FILES[$InstanceName]) && strlen($_FILES[$InstanceName]['name'])>0) {
		 
		 # FILE NAME
		 if($_FILES[$InstanceName]['error'] > 0) {  
			$this->Msg = 'File Name Error!';
			return $this->Msg;
			exit;
		 }
		 # SIZE
		 if($_FILES[$InstanceName]['size'] > $this->MaxSize) {
			$this->Msg = 'File Size is too large, Max allowed size: '.$this->FormatBytes($this->MaxSize,0);
			return $this->Msg;
			exit;
		 }
		 # EXTENSION
		 $node_array = explode('.', $_FILES[$InstanceName]['name']);      
		 $fExt = strtolower(end($node_array));
		 $this->Ext = $fExt;
			  
			  # EXTESION CHECK
			  if(!in_array($fExt, $this->arrEXT)) {
				$this->Msg = "File Extension '".strtoupper($this->Ext)."' Not Allowed!'";
				return $this->Msg;
				exit;
			  }
		
		
		 try {   
		  # NEW FILE NAME
		  if(strlen($this->NewFileName)>0) {
			$UploadedFile = $this->NewFileName;
		  }else {
			$UploadedFile = basename($_FILES[$InstanceName]['name']);
		  }
			
			$process = move_uploaded_file($_FILES[$InstanceName]['tmp_name'], $this->UploadDir.$UploadedFile);
			
			#return $UploadedFile;
			
		 } catch (Exception $e) {
			return 'Error uploading!';
		 }   
	  }      
   }

}
?>
