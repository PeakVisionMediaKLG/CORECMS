<?php   if($this->USER->SHOW_TO_ALL()){    ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>  
	
	
<?php   }  ?>
 <div class="preloader" <?php echo $ContentBasics['cAttrId']; ?>>