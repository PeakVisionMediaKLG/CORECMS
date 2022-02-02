           
            </div>
 
        <video class="fillWidth" <?php $this->PREPARE("attributes",$ContentBasics['cUID']);?>>
            <?php if($ContentData['path'][1]!=""){ ?>
			<source src="<?php echo $ContentData['path'][1];?>" type="video/webm">
			<?php } ?>
			<?php if($ContentData['path'][2]!=""){ ?>
				<source src="<?php echo $ContentData['path'][2];?>" type="video/mp4">
			<?php } ?>			
			Your browser does not support the video tag. I suggest you upgrade your browser.</video>
        <?php if($ContentData['path'][0]!=""){ ?> 
        <div class="poster hidden">
            <img src="<?php echo $ContentData['path'][0];?>" alt="">
        </div>
        <?php } ?>
    </div>

<script>
/** Document Ready Functions **/
/********************************************************************/

	
$( document ).ready(function() {

    <?php if($ContentData['customselect'][1]!=""){ ?>
    
    var thiswidth<?php echo $ContentBasics['cUID'];?> = $('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>').width(); //console.log(thiswidth<?php echo $ContentBasics['cUID'];?>);
    var aspect<?php echo $ContentBasics['cUID'];?> = <?php echo $ContentData['customselect'][1]/100; ?>;
    var finalheight<?php echo $ContentBasics['cUID'];?> = thiswidth<?php echo $ContentBasics['cUID'];?>*aspect<?php echo $ContentBasics['cUID'];?>;
    
    $('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>').css({maxHeight:finalheight<?php echo $ContentBasics['cUID'];?>});
    
    $('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>').height(finalheight<?php echo $ContentBasics['cUID'];?>);
    
    <?php } else { ?> var finalheight<?php echo $ContentBasics['cUID'];?> = $(window).height(); <?php } ?>
    // Resive video
    //scaleVideoContainer();

    initBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster img','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
    initBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .filter','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
    initBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> video','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
        
    $(window).on('resize', function() {
        //scaleVideoContainer();
        scaleBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster img','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
        scaleBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .filter','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
        scaleBannerVideoSize('.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> video','.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>');
    });
	
});

/** Reusable Functions **/
/********************************************************************/

function scaleVideoContainer() {

    var height = finalheight<?php echo $ContentBasics['cUID'];?> //$(window).height();
    var unitHeight = parseInt(height) + 'px';
    //$('.homepage-hero-module').css('height',unitHeight);

}

function initBannerVideoSize(element, parentel){
    
    $(element).each(function(){
        $(this).data('height', $(this).height());
        $(this).data('width', $(this).width());
    });

    scaleBannerVideoSize(element, parentel);

}

function scaleBannerVideoSize(element, parentel){

    var windowWidth = $(parentel).width(),
        windowHeight = $(parentel).height(),
        videoWidth,
        videoHeight;
    
    //console.log(windowWidth);

    $(element).each(function(){
        var videoAspectRatio = $(this).data('height')/$(this).data('width'), 
            windowAspectRatio = windowHeight/windowWidth; 
		
		//console.log('vid: '+videoAspectRatio+' cont: '+windowAspectRatio);

        if (videoAspectRatio > windowAspectRatio) { 
            videoWidth = windowWidth ;
            videoHeight = videoWidth * videoAspectRatio+150;
            $(this).css({'top' : -(videoHeight - windowHeight) / 2 + 'px', 'margin-left' : 0});
        } else {
			videoHeight = windowHeight +150; 
			videoWidth = videoHeight / videoAspectRatio;   //console.log(element + " " +videoWidth + " " + videoHeight);
            $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'}); //
        }

        $(this).width(videoWidth).height(videoHeight);

;
        

    });
}

	
</script>