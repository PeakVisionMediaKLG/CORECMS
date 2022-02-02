<script>
$(document).on('mouseenter','.core-facebook-tile', function(e) {
    $('.core-facebook-overlay').slideUp();
    $(this).find('.core-facebook-overlay').slideDown();
});
 
$(document).ready(function() {
    
    setTimeout(function(){
    
        $('.core-facebook-video').each(function (){

            var thisheight = $(this).closest('.core-col-tile').innerHeight();

            var profileheight = $(this).parent().find('.core-facebook-profile-name').height()+15;

            var iframeheight = $(this).find('span').height();
            
            var availableheight = thisheight - profileheight;
            
            var oldwidth = $(this).find('span').width();
            var newwidth = availableheight * $(this).find('span').width() / iframeheight; 
                newwidth = Math.trunc( newwidth ); 

            if((iframeheight + profileheight) > thisheight)
            {
                var oldsrc = $(this).find('span').find('iframe').attr('src');
                var newsrc = oldsrc.substring(0, oldsrc.length -4) + newwidth;
                var reposition = -(oldwidth - newwidth)/2;
                
                $(this).find('span').find('iframe').attr('src',newsrc);
                $(this).find('span').css({marginLeft:'auto',marginRight:'auto'});
                $(this).find('span').css({position:'relative',left:reposition});
            }
        });
    
    },5000);
});    
</script>