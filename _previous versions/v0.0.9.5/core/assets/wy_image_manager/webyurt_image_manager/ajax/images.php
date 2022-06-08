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

require_once('../../config.php');

require_once('../includes/functions.php');
require_once('../class/class_upload.php');
require_once('../class/class_resize.php');


$Action = $FileName = $Value = '';

#---------------------------
# INPUT DATA
#---------------------------
$Action = Grab('Action');
$File = Grab('File');

$NewFileName = strtolower(Grab('NewFileName'));

$pthIMAGES 		= '../../'.$pthImages.'/';
$pthTHUMB 		= '../../'.$pthImages.'/thumbs/';


#---------------------------
# UPLOAD
#---------------------------
if (! empty($_FILES)) { 
	
	#e("UPLOADING...");
	
    $tempFileName = $_FILES['file']['tmp_name'];
    $FileName	  = $_FILES['file']['name'];
    
	#e($FileName);
		
	$arrFile = pathinfo($FileName);
	$EXT = $arrFile['extension'];
	$FileNoExt = str_replace($EXT, '', $FileName);
		
	$UniqueFileName = GenFileName($FileNoExt);
	
	#e($FileName);
	
	# file exists with the same name
	if (file_exists($pthIMAGES.$UniqueFileName.'.'.$EXT)) {
		# make file name unique
		$UniqueFileName = $UniqueFileName.'_'.time().'_'.mt_rand(100000, 999999);
	}
	
	$FileName = $UniqueFileName.'.'.$EXT;
	
	#e($FileName);
	
	# UPLOAD
	$oUpload = new Upload;
	$oUpload->SetExts($Allowed_Extensions);
	$oUpload->SetMaxSize($Max_File_Upload_Size);

	# Large
	$oUpload->SetUploadDir($pthIMAGES);
	$oUpload->NewFileName($FileName);     
	$oUpload->UploadImage('file');
		
	# RESIZE
	$oResize = new resize();
	$oResize->OpenImage($pthIMAGES.$FileName);
	$oResize->ResizeImage(120, 80, 'crop');
	$oResize->saveImage($pthTHUMB.$FileName, 80);			# 80 = image quality
	
}



#---------------------------
# ACTION
#---------------------------
if (!IsEmpty($File)) {


	#---------------------------
	# DELETE
	#---------------------------
	if ($Action == "Delete"){	
		# DELETE
		DeleteFile($pthIMAGES.$File);
		DeleteFile($pthTHUMB.$File);
	}# Action
	
	
	
	
	#---------------------------
	# RENAME
	#---------------------------
	if ($Action == "Rename"){
		# new filename found
		if ($NewFileName != $File) {
			
			# get EXT from already existing file
			$ExistingLarge = pathinfo($File);
			$ExistingEXT = $ExistingLarge['extension'];
			
			# remove extension from NEW file if any
			$NewLarge = pathinfo($NewFileName);
			
			# if EXT found
			if (isset($NewLarge['extension'])) {
				$NewEXT = $NewLarge['extension'];
				# remove extension before generating filename
				$NewFileName = str_replace($NewEXT, '', $NewFileName);
			}
			
			$NewFileName = GenFileName($NewFileName);
			$NewFileExt = $NewFileName.'.'.$ExistingEXT;
			
			# check if file exists with NEW name
			if (! file_exists($pthIMAGES.$NewFileExt)) {
				
				# CHANGE FILNAME 
				copy($pthIMAGES.$File , $pthIMAGES.$NewFileExt);
				copy($pthTHUMB.$File , $pthTHUMB.$NewFileExt);

				# DELETE OLD FILES
				DeleteFile($pthIMAGES.$File);
				DeleteFile($pthTHUMB.$File);
				
				echo json_encode('success');
				
			} else {
				echo json_encode('Filename already exists!');
			}
		
		}else{
		# filename unchanged
			echo json_encode('cancel');
		}
	}# Action
	

	
}# $FileName

?>