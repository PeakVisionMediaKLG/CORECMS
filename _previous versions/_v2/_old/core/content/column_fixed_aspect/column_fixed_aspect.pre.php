<div class="core-column <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> style="
<?php if($ContentData['path'][0]!=""){ ?>
background-image: url('<?php echo $ContentData['path'][0]; ?>'); background-size: cover; background-repeat: no-repeat; background-position:<?php echo $ContentData['customselect'][2]; ?>; 
<?php } ?>

<?php echo $ContentBasics['cAttrStyle']; ?>">

<?php   if($this->USER->SHOW_TO_ALL()){    ?>
	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
	</div>  
<?php   }  ?>    
    
<div class="core-column-overlay <?php echo $ContentBasics['cAttrClass']; ?>" style="height:0 !important; width:100%; height:inherit; background: rgba(0, 0, 0, <?php echo $ContentData['customselect'][1]; ?>); z-index:1; position:relative; padding-bottom:<?php echo $ContentData['customselect'][0]; ?>%; overflow-y:hidden; text-overflow:clip;">
    

    
