
    <div class="row">
        <div class="col-12">
            <a class="carousel-control-prev text-dark" href="#myCarousel" role="button" data-slide="prev">
                <span class="fa fa-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next text-dark" href="#myCarousel" role="button" data-slide="next">
                <span class="fa fa-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<script>
$('#myCarousel').carousel({
  interval: false
})
</script>


<?php /*  </div>
<?php if($ContentData['customselect'][0]){ ?>
    <a class="carousel-control-prev" href="#carousel<?php echo $ContentBasics['cUID']; ?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel<?php echo $ContentBasics['cUID']; ?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
<?php } ?>
</div>
<?php if($this->USER->SHOW_TO_ADMIN()){ ?>
<div class="clearfix"></div>
<?php } ?>
<script>
 $("div.core-slide<?php echo $ContentBasics['cUID']; ?>").first().addClass("active");
</script>
 <?php if($this->USER->SHOW_TO_ADMIN()){ ?>
<script>
 	$(document).ready(function() {      
	   	$('#<?php echo "carousel".$ContentBasics['cUID']; ?>').carousel({
		pause: true,
    	interval: false   
		});
	});
</script>
 

 <?php

 } else {?>
 
 <script>
  $(document).ready(function(){
    $('.<?php echo "carousel".$ContentBasics['cUID']; ?>').carousel({
      	interval: <?php echo $ContentData['customselect'][2]; ?>,
		keyboard: <?php echo $ContentData['customselect'][6]; ?>,	
		pause: <?php echo $ContentData['customselect'][3]; ?>,
        wrap: <?php echo $ContentData['customselect'][5]; ?>,
        ride: <?php echo $ContentData['customselect'][4]; ?>
    })
  });    
</script>



<?php } */ ?>
	