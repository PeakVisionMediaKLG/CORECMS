<div class="carousel-item core-slide<?php echo $ContentBasics['cParent']; ?>" style="background-image: url('<?php echo $ContentData['path'][0]; ?>'); background-size: cover; background-repeat: no-repeat; background-position:<?php echo $ContentData['customselect'][0]; ?>;" <?php echo $ContentBasics['cAttrId']; ?>>
<img src="" alt="...">
  <div class="carousel-caption d-none d-md-block">
  <?php if($this->USER->SHOW_TO_ALL()){ ?>

	<div class="core-content-controls">
		<?php $this->CONTENT_CONTROLS($ContentBasics); ?>
		<br style="clear:both;">
	</div>  
	
	
    <?php } ?>      
    <h5>...</h5>
    <p>...</p>

