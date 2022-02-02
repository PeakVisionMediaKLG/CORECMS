<div class="<?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="width:inherit">

<?php   if($this->USER->SHOW_TO_ADMIN()){    ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<!--<br style="clear:both;">-->
	</div>  
	
	
<?php   }  ?>

<?php include('custom/files/'.$ContentData['path'][0]);  ?>    