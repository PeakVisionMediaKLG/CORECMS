
    <?php if($this->USER->SHOW_TO_ALL()){ ?>

        <div class="core-content-controls">
            <?php $this->CONTENT_CONTROLS($ContentBasics); ?>
            <br style="clear:both;">
        </div>  


    <?php } /*?>  
<?php if($ContentData['customselect'][8]){ ?>
    <style>
        .carousel<?php echo $ContentBasics['cUID']; ?> img {content:url(data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D) !important; }
        .core-slide<?php echo $ContentBasics['cUID']; ?> {height:<?php echo $ContentData['custominput'][0]; ?> !important;
    </style>
<?php } ?>
<div <?php echo $ContentBasics['cAttrId']; ?> class="carousel<?php echo $ContentBasics['cUID']; ?> carousel slide carousel<?php echo $ContentBasics['cUID']; ?> <?php echo $ContentData['customselect'][7]; ?>" data-ride="carousel">
	 
    <?php if($ContentData['customselect'][1]){ ?>   
    <ol class="carousel-indicators">
        <?php 
              if($ContentData['customselect'][1]){		  
              $carouselsql = "SELECT cUID FROM content WHERE cParent='".$ContentBasics['cParent']."' and cDeleted=0 ORDER BY cPosition ASC";
              $carouselresult = $this->DB->MULTI_ROW($carouselsql);
              $carouselitemnumber = 0;

              while($carouselrow=$carouselresult->fetch_array()){

                  if($carouselitemnumber==0){ $activeslide="class='active'"; } else $activeslide="";
                  
                  echo"<li data-target='#"."carousel".$ContentBasics['cUID']."' data-slide-to='$carouselitemnumber' ".$activeslide."></li>";  

                  $carouselitemnumber++;
                  }
                  $carouselitemnumber=0;
              }
          ?>      
    </ol>
    <?php } ?>    
  <div class="carousel-inner"> */ ?>
<div class="container text-center my-3" >
    <div class="row mx-auto my-auto">
        <div id="myCarousel" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner" role="listbox" >

      


    

    