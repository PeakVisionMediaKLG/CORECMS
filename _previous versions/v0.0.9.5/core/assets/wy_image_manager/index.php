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

?>

<!DOCTYPE HTML>
<head>
<meta charset="utf-8">
<Title>Editor</Title>


<!-- Mobile Specific Metas
––––––––––––––––––––––––––––––––––––––––––––––––––--->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- JS
––––––––––––––––––––––––––––––––––––––––––––––––––--->
<script type="text/javascript" src="webyurt_image_manager/js/jquery.min.js"></script>

<script type="text/javascript" src="webyurt_image_manager/js/tinymce5/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="webyurt_image_manager/js/tinymce5/js/tinymce/jquery.tinymce.min.js"></script>

<!-- CSS
----------------------------------------------------->
<link rel="stylesheet" href="webyurt_image_manager/css/styles.css">
	

<script type="text/javascript">
<!--

//--------------------------------------------
// TINYMCE Web Yurt open manager
//--------------------------------------------
function OpenWYImageManager(callback, value, meta) {
	var width = window.innerWidth-20;
	var height = window.innerHeight-20;
	if (width > 1800)  { width = 1800; }
	if (height > 1200) { height = 1200; }

	//tinyMCE.activeEditor.focus(true);

	var fileUrl = tinyMCE.activeEditor.settings.pthManager+'images.php?';

	// VERSION 5
	tinyMCE.activeEditor.windowManager.openUrl({
		title: "Media Manager",
		url: fileUrl,
		width: width,
		height: height,

		inline: 1,
		resizable: true,
		maximizable: true,
		onMessage: function (api, data) {
			if (data.mceAction === 'customAction') {
				callback(data.url);
				api.close();
			}
		}

	});

}
	
//--------------------------------------------
// TINYMCE
//--------------------------------------------
tinymce.init({
	selector: 'textarea#Editor',
	element_format: 'html',
		pthManager:"",
	height: 500,
	menubar: true,
	branding: false,
	convert_urls: false,
	relative_urls: false,
	image_caption:true,
	image_advtab: true,
	toolbar_drawer: 'sliding',
	min_height: 200,
	max_height: 650,
	 
	plugins: [
		'autoresize advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table paste code codesample help wordcount preview hr',
	],
	external_plugins: {
		'WYImageManager': '/wy_image_manager/webyurt_image_manager/js/tinymce5/external_plugins/wyimagemanager/plugin.js'
	},

	toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | image WYImageManager | preview fullscreen | forecolor backcolor |  wordcount | hr codesample',

	
	file_picker_callback: function (callback, value, meta) {
		OpenWYImageManager(callback, value, meta);
	},
			
});

-->
</script>

</head>
<body>

<div class="_mt15 _mr15 _ml15">
	<a class="action" href="http://www.webyurt.com/tinymce-image-uploader-plugin">&laquo; Back to the download page</a>
	
	<h1>Web Yurt TinyMCE Image Uploader and Manager Plugin</h1>
	<form action="index.php" name="frm" id="frm" method="post">
		<textarea name="Editor" id="Editor" rows="20"></textarea>
		<input class="btn2 _mt10" id="btnSubmit" name="btnSubmit" type="submit" value="Submit">
	</form>
</div>   
 
</body>
</html>