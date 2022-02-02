<!--<div class="core-image" " id="<?php echo $ContentBasics['cAttrId']; ?>" <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?>>-->
<?php   if($this->USER->SHOW_TO_ALL()){    ?>
	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
	</div>  
<?php   } ?>

<?php if($ContentData['custominput'][0] and $ContentData['custominput'][0]!='use link (optional)') { ?><a href="<?php echo $ContentData['custominput'][0]; ?>"><?php   } ?>
    <img src="<?php if($ContentData['path'][0]) echo $ContentData['path'][0];?>" class="<?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> style="<?php echo $ContentBasics['cAttrStyle']; ?>" alt="<?php echo @$ContentData['custominput'][1]; ?>">
<?php if($ContentData['custominput'][0] and $ContentData['custominput'][0]!='use link (optional)') { ?>
</a> 
<?php   } ?>
    
    
