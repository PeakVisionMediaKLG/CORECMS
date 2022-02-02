<style>

.no-video .core-bgvideo-container<?php echo $ContentBasics['cUID'];?> video,
.touch .core-bgvideo-container<?php echo $ContentBasics['cUID'];?> video {
  display: none;
}
	
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster .hidden {
  display: none;
}
	
.no-video .core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster,
.touch .core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster {
  display: block !important;
}
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> {
  position: relative;
  bottom: 0%;
  left: 0%;
  height: 100%;
  width: 100%;
  overflow: hidden;
  background: #000;
    <?php if($ContentData['custominput'][0]!=""){ echo"min-height:".$ContentData['custominput'][0].";"; } ?>    
    
}
    
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?>:hover {    
 <?php if($ContentData['custominput'][0]!=""){ echo"min-height:".$ContentData['custominput'][0].";"; } ?>	
    }
    
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .poster img {
  min-width: 100%;
  bottom: 0;
}
	
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .filter {
  z-index: 100;
  position: absolute;
  background: rgba(0, 0, 0, <?php echo $ContentData['customselect'][0]; ?>);
  width: 100%;
}
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .core-bgvideo-overlay-container {
	z-index: 101;


}
	
/*.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> .core-bgvideo-overlay-container div {
	z-index: 102;

}	*/
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> video {
  position: absolute;
  z-index: 0;
  bottom: 0;
}
/*.video-container<?php echo $ContentBasics['cUID'];?> video.fillWidth {
  min-width: 100%;
}*/
    
.core-bgvideo-overlay-container > div {position:relative; z-index:105;}    

<?php 
    
if($ContentData['custominput'][0]!="" and $ContentData['customselect'][1]=="") $myheight='max-height:'.$ContentData['custominput'][0].'px;'; 
elseif($ContentData['customselect'][1]!="") $myheight="";
else  $myheight="max-height:450px;";

?>    
    
.core-bgvideo-container<?php echo $ContentBasics['cUID'];?> {<?php echo $myheight; ?>}   
    
</style>
    <div class="core-bgvideo-container<?php echo $ContentBasics['cUID']; $this->PREPARE("classes",$ContentBasics['cUID'],$ContentBasics['cAttrClass']);?>" <?php echo $ContentBasics['cAttrId'];?>>
                       <div class="filter"></div>
        
            <div class="core-bgvideo-overlay-container">
            <?php   if($this->USER->SHOW_TO_ALL()){    ?>
            <div class="row"><div class="col">
                <div class="core-content-controls">
                    <?php $this->CONTENT_CONTROLS($ContentBasics); ?>
                    <!--<br style="clear:both;">-->
                </div>
            </div></div>    
            <?php   } ?>    


