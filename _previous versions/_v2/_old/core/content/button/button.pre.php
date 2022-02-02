<?php   if($this->USER->SHOW_TO_ALL()){    ?>
<div class="" style="display:inline-block;width:100%;">
    <div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
	</div>  
<?php   } ?>
    
<<?php echo $ContentData['customselect'][0]; ?> 
    <?php if($ContentData['customselect'][0]!="a"){?> type="<?php echo $ContentData['customselect'][1]; ?>"<?php } ?> 
    class="btn <?php $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']); ?>" <?php echo $ContentBasics['cAttrId']; ?> style="<?php echo $ContentBasics['cAttrStyle']; ?>" 
    <?php $this->PREPARE("attributes",$ContentBasics['cUID']); ?> 
    <?php if($ContentData['customselect'][0]=="a"){?> href="<?php echo $ContentData['custominput'][1]; ?>" <?php } ?>
    <?php if($ContentData['customselect'][0]=="input"){?> value="<?php echo $ContentData['custominput'][0]; ?>" <?php } ?>  
    <?php if($ContentData['custominput'][1]=="input"){?> onclick="window.open('<?php echo $ContentData['custominput'][1]; ?>')" <?php } ?>
>   

    <?php if($ContentData['customselect'][0]=="a"){ echo "<span id='span-".$ContentBasics['cUID']."'>".$ContentData['custominput'][0];?></span></a><?php } ?>  
    <?php if($ContentData['customselect'][0]=="button"){ echo "<span id='span-".$ContentBasics['cUID']."'>".$ContentData['custominput'][0];?></span></button><?php } ?>  
    
    

<?php   if($this->USER->SHOW_TO_ALL()){    ?>
</div>
<?php } ?>

    
    
