<?php   if($this->USER->SHOW_TO_ALL()){    ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>  
	
	
<?php   }  ?>

<img src="<?php echo $ContentData['path'][0]; ?>" class="card-img-top core-card-image <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="<?php $this->PREPARE("styles",$ContentBasics['cUID']); ?>" alt="<?php echo $ContentData['custominput'][0]; ?>">