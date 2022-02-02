<div class="core-fixed-aspect-image <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="width:100%; height:0; background-image: url('<?php echo $ContentData['path'][0]; ?>'); background-size: cover; background-repeat: no-repeat; background-position:<?php echo $ContentData['customselect'][1]; ?>; padding-bottom:<?php echo $ContentData['customselect'][0]; ?>%; <?php echo $ContentBasics['cAttrStyle']; ?> <?php if($ContentData['custominput'][0] and $ContentData['custominput'][0]!='') { ?> cursor:pointer; <?php } ?>" <?php if($ContentData['custominput'][0] and $ContentData['custominput'][0]!='') { ?> onclick="window.open('<?php echo $ContentData['custominput'][0]; ?>')"<?php   } ?>>
<?php   if($this->USER->SHOW_TO_ALL()){    ?>
	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
	</div>  
<?php   } ?>
</div>


