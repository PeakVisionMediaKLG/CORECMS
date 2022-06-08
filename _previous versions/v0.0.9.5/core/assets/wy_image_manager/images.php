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
require_once('config.php');
require_once('webyurt_image_manager/includes/functions.php');
require_once('webyurt_image_manager/class/class_pagination.php');


$page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 1;

#---------------------------------------------------
# GET IMAGES
#---------------------------------------------------
# IMAGES DIRECTORY - // glob('my/path/*.{png,jpg,jpeg,gif}', GLOB_BRACE);
$files = glob($pthImages."/thumbs/*.{". $Allowed_Extensions ."}", GLOB_BRACE);

# sort by date
usort($files, function ($a, $b) {
				return filemtime($b) - filemtime($a);
				});
$TotalImages = count($files);
$offset		= ($page-1)*$PerPage;
$arrFiles	= array_slice($files, $offset, $PerPage);

#p($arrFiles);
# no images found on page=?? - redirect to images page 1
if ($TotalImages > 0) {
	if (!$arrFiles) { Redirect($CurrentPage); }
}
#---------------------------------------------------
# PAGINATION
#---------------------------------------------------
$Pager = new Pagination;
$Pager->Adjacents = 3;							# NUMBER OF ADJACENT PAGES ON EACH SIDE IN PAGING
$Pager->PerPage = $PerPage;						# NUMBER OF RECORDS PER PAGE
$Pager->TotalRecords = $TotalImages;
$Pager->GetStartLimit();
		

#---------------------------------------------------
# ALLOWED EXTENSIONS for JS
#---------------------------------------------------
$AllowedImageExtentions = '.'.$Allowed_Extensions;
$AllowedImageExtentions = str_replace(',', ',.', $AllowedImageExtentions);
		
		

?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<Title>Images</Title>

<!-- Mobile Specific Metas
----------------------------------------------------->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- JS
----------------------------------------------------->
<script type="text/javascript" src="webyurt_image_manager/js/jquery.min.js"></script>
	
<!-- CSS
----------------------------------------------------->
<link rel="stylesheet" href="webyurt_image_manager/css/lightbox.css">
<link rel="stylesheet" href="webyurt_image_manager/css/featherlight.css">
<link rel="stylesheet" href="webyurt_image_manager/css/dropzone.css">
	
<link rel="stylesheet" href="webyurt_image_manager/css/styles.css">
<link rel="stylesheet" href="webyurt_image_manager/css/font-awesome.min.css">

</head>
<body>
<div class="_mt15 _mr15 _ml15">
	
 <!-- BUTTONS -->
 <div class="row">
	<a class="action" id="btnToggleUploader">Upload Images</a>
 </div>

 <!-- UPLOADER -->
 <div class="row">
	<div id="uploader" class="_hide">
		<form action="webyurt_image_manager/ajax/images.php" class="dropzone"></form>
	</div>
 </div>


 <!-- IMAGES -->
 <div class="row">
  <div class="_mb25">
  <div class="_mb10 _mt10">Total <span id="Total"><?php echo $TotalImages ?></span></div>
	<div id="images" class="images">
		<?php
		#---------------------------------------------------
		# IMAGES IN DIR WITH PAGINATION
		#---------------------------------------------------
		$counter 	= 0; 

		
		foreach ($arrFiles as $file) {
			$counter ++; 
			$LargeNotFoundCSS = '';
			$LargeNotFoundTip = 'View';
			$LargeViewIcon = '<i class="fa fa-eye"></i>'; 
			
			$File = str_replace(array('../','thumbs/'),'',$file);
					
			$pthFile = dirname($File).'/';
			
			
			$FileName = basename($File);
			$LargeImageURL = $File;
			
			#e($pthFile);
			#e('<span class="_red">'.$FileName.'</span>');
				
			# check if filename has numbers 
			/*if (HasNumber($FileName)) {
				$LargeNotFoundTip = 'Numbers found in filename: '.$FileName;
				$LargeNotFoundCSS = ' _alert';
			};*/
			
			# check if file exists
			if (! file_exists($pthFile.$FileName)) {
				$LargeNotFoundTip = 'Large image NOT FOUND: '.$FileName;
				$LargeNotFoundCSS = ' _error';
				$LargeViewIcon = '<i class="fa fa-eye-slash"></i>'; 
			} else {
				list($width, $height, $type, $attr) = getimagesize($File);
			}

			
			
			
			echo '<div id="IMG'.$counter.'" class="wrap">';
				echo "<img class='image tooltip' id='btnInsertFile' src='$file' title='$FileName' alt='$FileName' data-url='$LargeImageURL' data-width='$width' data-height='$height'>";
				
				echo '<div class="info">';
					echo '<div class="buttons">';
						# DELETE
						echo '<a id="btnDelete" class="tooltip" title="Delete" data-post="webyurt_image_manager/ajax/images.php" data-id="IMG'.$counter.'" data-file="'.$FileName.'"><span><i class="fa fa-trash-o"></i></span></a>';
						
						# DOWNLOAD
						echo '<a class="tooltip" title="Download" href="'.$LargeImageURL.'" download><span class="'. $LargeNotFoundCSS .'"><i class="fa fa-download"></i></span></a>';
						
						# RENAME
						echo '<a id="btnRename" class="tooltip" title="Rename: '.$FileName.'" data-post="webyurt_image_manager/ajax/images.php" data-file="'.$FileName.'"><span class="'. $LargeNotFoundCSS .'"><i class="fa fa-edit"></i></span></a>';
						
						# VIEW
						echo '<a rel="lightbox" class="tooltip" href="'.$LargeImageURL.'" title="'.$LargeNotFoundTip.'" data-title="'.$LargeImageURL.'"><span class="'. $LargeNotFoundCSS .'">'.$LargeViewIcon.'</span></a>';
					echo '</div>';

					# FILE NAME
					echo "<div class='name tooltip".$LargeNotFoundCSS."' title='$FileName'>".TrimString($FileName,13,'..')."</div>";
				echo '</div>';
				
			echo '</div>';
		}
		?>
	</div>
  </div>
 </div>
  <!-- PAGINATION -->
 <div class="row _mt20">
		<?php echo $Pager->GetPageNumbers() ?>
 </div>




<!-- RENAME FORM -->
<div class="_hide" id="RenameDiv" style="width:250px;">
	<div class="row">
	<h1 class="_notbold">Rename</h1>
			<div id="ResultMSG" class="errorbox _hide">&nbsp;</div>
			<p>

				  <div class="_fleft">
				   <label for="Title" class="">File Name</label>
				  </div>

				<input name="Action" id="Action" type="hidden" value="Rename">
				<input name="AjaxPost" id="AjaxPost" type="hidden" value="">

				<input name="NewFileName" id="NewFileName" type="text" value="">
				<input name="ExistingFileName" id="ExistingFileName" type="hidden" value="">
			</p>
	</div>
	<div class="row _clear _right">
			<input class="_mr10" id="btnCancel" name ="btnCancel" type="submit" value="Cancel">
			<input class="btn2" id="btnRenameFile" name="btnRenameFile" type="submit" value="Save">
	</div>
</div>







</div>

<script type="text/javascript">
<!--


$(document).ready(function() { 
	var fl = null;
	$.featherlight.autoBind = false;				// prevent auto attach
	
	//--------------------------------------
	// CANCEL RENAME
	//--------------------------------------
	$(document).on("click","#btnCancel",function(e){
		$.featherlight.close();
	});
	//--------------------------------------
	// RENAME FORM
	//--------------------------------------
	$(document).on("click","#btnRename",function(e){
			var AjaxPost 	= $(this).data("post");
			var File 		= $(this).data("file");
			
			//$('#ExistingFileName').html(File);
			$('#AjaxPost').val(AjaxPost);
			$('#NewFileName').val(File);
			$('#ExistingFileName').val(File);
			
			 fl = $.featherlight('#RenameDiv');					// ini featherlight
			

	});

	
	//--------------------------------------
	// RENAME
	//--------------------------------------
	$(document).on("click","#btnRenameFile",function(e){
		e.preventDefault();	
		
			var LINK 				= fl.$content.find('#AjaxPost').val();
			var NewFileName 		= fl.$content.find('#NewFileName').val();
			var ExistingFileName 	= fl.$content.find('#ExistingFileName').val();
			
			var STRING = 'Action=Rename&NewFileName='+ NewFileName + '&File=' + ExistingFileName;
			
			$.ajax({
			   type: "POST",
			   url: LINK,
			   data: STRING,
			   cache: false,
			   success: function(html){
				   			var msg =  $.parseJSON(html);
							if (msg == 'success') {
					  			$.featherlight.close();
								location.reload();
							} else if (msg == 'cancel') {
					  			$.featherlight.close();
							} else if (msg != "") {
								fl.$content.find('#ResultMSG').text(msg);
								fl.$content.find('#ResultMSG').removeClass('_hide');
								//console.log(msg);
							}
					  	}			   
			});
	});


	//--------------------------------------
	// DELETE
	//--------------------------------------
	$(document).on("click","#btnDelete",function(e){
		e.preventDefault();			
		
			var LINK 	= $(this).data("post");	
			var DivID 	= $(this).data("id");
			var File 	= $(this).data("file");
			
			var Total 	= $('#Total').text()-1;		// deduct total count
			//console.log(Total);
			
			var CONTAINER = $('#'+DivID);						
			var STRING = 'Action=Delete&File='+ File;
		

				$.ajax({
				   type: "POST",
				   url: LINK,
				   data: STRING,
				   cache: false,
				   success: function(){
				   		   $('#Total').text(Total);
				   
						   CONTAINER.fadeOut('25', function() {$(this).remove();});
						   CONTAINER.animate({ 
								 height: 1,          // Avoiding sliding to 0px (flash on IE) 
								 paddingTop: "hide", 
								 paddingBottom: "hide" 
								 }) 
								  // Then hide 
								 .animate({display:"hide"},{queue:true}); 
						  }			   
				});

	});	 
	

	//--------------------------------------
	// toggle uploader
	//--------------------------------------
	$(document).on("click","#btnToggleUploader",function(e){
		//$('#uploader').toggleClass('_hide');
		$('#uploader').slideToggle('fast');
	 });


	//--------------------------------------
	// send picked img to tinymce editor
	//--------------------------------------
	$(document).on("click","img#btnInsertFile",function(e){
				
		var url = $(this).data("url");
		
		// detect if image dialog opened
		var title = $('.tox-dialog__title', window.parent.document).text();
		var ImageDialog = title.search("Insert/Edit Image");
		
		if (ImageDialog == 0) {						// 0 = image dialog present because insert/edit text found
			window.parent.postMessage({
					mceAction: 'customAction',
					url: url
				}, '*');
		}else{
			// insert image in Editor
			if (typeof(parent.tinymce) !== "undefined") {
				parent.tinymce.activeEditor.insertContent('<img src="'+ url +'">');
				parent.tinymce.activeEditor.windowManager.close();
			}
		}
	});
	
	
	//--------------------------------------
	// DROPZONE - uploader
	//--------------------------------------	
	Dropzone.autoDiscover = false; 								// prevent auto attach
	
	// DropZone Options
	var dropzoneOptions = {
                dictDefaultMessage: '<div><span class="_bold">Drop images here</span> <span class="_notbold">to upload</span><div>  <div class="_small _italic">(or click)</div>',
				acceptedFiles: "<?php echo $AllowedImageExtentions;  # ".jpeg,.jpg,.png,.gif" ?>",
                paramName: "file",
                maxFilesize: <?php echo $Max_File_Upload_Size/1000 ?>, // MB
                addRemoveLinks: false,
                init: function () {
                    this.on("success", function (file) {
                        console.log("success > " + file.name);
                    });
                }
            };
	var myDropzone = new Dropzone(".dropzone", dropzoneOptions);					// manual attach it instead

	// check all files uploaded
	myDropzone.on("queuecomplete", function(file, res) {
		  if (myDropzone.files[0].status == Dropzone.SUCCESS ) {
			  location.reload();
		  }
	});
	
	
});
-->
</script>
<script type="text/javascript" src="webyurt_image_manager/js/lightbox.js"></script>
<script type="text/javascript" src="webyurt_image_manager/js/featherlight.js"></script>
<script type="text/javascript" src="webyurt_image_manager/js/dropzone.js"></script>

</body>
</html>