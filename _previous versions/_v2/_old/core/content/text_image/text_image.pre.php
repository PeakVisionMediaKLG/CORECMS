<div class="<?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="<?php echo $ContentBasics['cAttrStyle'];?>">
<?php
if($this->USER->SHOW_TO_ALL()){?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<br style="clear:both;">
	</div>  
	
	
<?php	
}
?>	