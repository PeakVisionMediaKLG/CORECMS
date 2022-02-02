<style>
    .core-wall-icon {position:relative;left:15px;top:15px; z-index:3;color: white; mix-blend-mode: difference;}
    .core-wall-icon-symbol {font-size:18pt;}

    .core-facebook-description{width:100%; height: 95%; overflow: hidden; color: white; position:absolute; z-index: 1; font-size:0.8rem; text-overflow: clip; padding-bottom:5%; }
    
    .core-facebook-description > div.core-facebook-message {text-overflow: clip; }
    
    .core-facebook-description a {color:#75D4FC; } 
    .core-facebook-message {text-overflow: clip; }
    .core-video-play-overlay{background-color: rgba(0,0,0,0.3); width:100%; height: 100%; background-image: url('core/content/facebook_wall/play-button.png'); background-position: center; background-size: 40% auto; background-repeat: no-repeat; overflow: hidden; text-overflow: clip; color: white; position:absolute; z-index: 1;}
    .core-facebook-overlay {display:none; background-color: rgba(0,0,0,0.5); width:100%; height: 100%; overflow: hidden; color: white; position:absolute; z-index: 2;}    
    .core-facebook-overlay:hover {cursor:pointer}
    
    .core-clickable-hand:hover {cursor:pointer}
    
    /*.core-facebook-video{width:100%; height: 100%; overflow: hidden;}*/
    
    .fb-video{min-width:570px;min-height:350px;}
    

    /* Small devices (tablets, 576px and up)*/
    @media (min-width: 576px) { 
        .core-facebook-message{font-size:1rem;}
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) {
        .core-facebook-message{font-size:0.9rem;}
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) { 
        .core-facebook-message{font-size:0.7rem;}
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) { 
        .core-facebook-message{font-size:0.75rem;}
    }    
    
    
</style>
<?php include_once('core/includes/lightbox.php'); ?>
