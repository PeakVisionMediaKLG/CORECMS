<?php //print_r($ContentBasics);  ?>

<div class="core-container <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" id="<?php echo $ContentBasics['cAttrId']; ?>" <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="<?php if($ContentData['path'][0]) echo"background-image:url('".$ContentData['path'][0]."'); "; ?>">

<?php if($this->USER->SHOW_TO_ADMIN()){ ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<br style="clear:both;">
	</div>  
	
	
<?php } ?>	