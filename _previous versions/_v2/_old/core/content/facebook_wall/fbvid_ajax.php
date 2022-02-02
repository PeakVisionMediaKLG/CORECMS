<html>
    <head>
    <script src="../../../components/jquery/jquery-3.2.1.min.js"></script>
        <style>
.preloader {
  position: fixed;
  left: 0;
  top: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  overflow: visible;
  background: white url('../../../custom/img/images/basicloader.gif') no-repeat center center;
}
</style>
    </head>
<body style="margin:0;padding:0;">
<div class="preloader"></div>
<div class='fb-video' data-href='<?php echo $_GET['url'];?>' data-show-text='false' data-width='auto' data-show-captions='false'></div>
  
   <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
      </script>
<script>
$(document).ready(function($) { 
    setTimeout(function(){
    $('.preloader').fadeOut('slow',function(){$(this).remove();});
    $('.fb-video').each(function (){ 
            
            var realheight = $(window).height();    
            
            var iframeheight = $(this).find('span').height();
     
            $(this).find('iframe').css({'overflow':'hidden'});
             $('.featherlight',parent.document).find('iframe').height(iframeheight);
             $('.featherlight',parent.document).find('iframe').css({'overflow':'hidden'})  ; 
        });      
    
    
    },3000);
});      
</script>    
</body>
</html>



