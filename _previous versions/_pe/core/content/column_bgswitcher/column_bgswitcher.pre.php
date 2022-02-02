<div class="core-column-bgswitcher core-bgswitcher-<?php echo $ContentBasics['cUID']; ?> <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="<?php echo $ContentBasics['cAttrStyle']; ?> background-size:cover; background-position:center center;">

<?php   if($this->USER->SHOW_TO_ALL()){    ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>  
	
	
<?php   }  ?>
