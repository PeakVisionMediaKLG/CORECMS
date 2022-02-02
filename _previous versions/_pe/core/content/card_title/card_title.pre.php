<?php   if($this->USER->SHOW_TO_ALL()){    ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>  
	
	
<?php   }  ?>

<<?php echo $ContentData['customselect'][1]; ?> class="card-title core-card-title <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" style="<?php $this->PREPARE("styles",$ContentBasics['cUID']); ?>" <?php echo $ContentBasics['cAttrId']; ?>><?php echo $ContentData['custominput'][0]; ?></<?php echo $ContentData['customselect'][1]; ?>>

<?php   if($ContentData['customselect'][0]!=0){ ?>
<<?php echo $ContentData['customselect'][2]; ?> class="card-subtitle core-card-subtitle <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" style="<?php $this->PREPARE("styles",$ContentBasics['cUID']); ?>"><?php echo $ContentData['custominput'][1]; ?></<?php echo $ContentData['customselect'][2]; ?>>
<?php   }  ?>
<br>
