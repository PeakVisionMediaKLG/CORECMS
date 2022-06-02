<?php	
/*
--------------------------------------------
WebYurt.com - Resource license terms
---------------------------------------------
The Web Yurt TinyMCE Image Manager plugin is free for use in personal website projects.
For use in commercial websites, a donation is required to the PayPal email address: info@webyurt.com

You can modify this resource to your requirements to fit into your own projects, however we do not accept responsibility for any misuse.

We would appreciate a link back to WebYurt.com, in order to help spread the word about us so we can continue our work.

Redistribution, reselling, leasing, licensing, sub-licensing or offering this resource to any third party is strictly prohibited. This includes uploading our resources to another website, marketplace or media-sharing tool, and offering our resources as a separate attachment from any of your work. If you do plan to include this resource on any project that will be sold on a website or marketplace, please contact us first to determine the proper use of our resource.

HOTLINKING is strictly prohibited i.e. you cannot make a direct link to the actual download file for this resource. For any attribution, please link to the page where the resource can be downloaded from on WebYurt.com.

These license terms are subject to change at any time without prior notice.

---------------------------------------------
Regards,
The WebYurt.com Team.
---------------------------------------------
http://www.webyurt.com

*/

Class resize{
  private $image;
  public $width;
  public $height;
  private $imageResized;

  #--------------------------------------
  # OPEN IMAGE	
  #--------------------------------------
  public function OpenImage($fileName){
	  $this->image = $this->OpenImageFile($fileName);
	  $this->width  = imagesx($this->image);
	  $this->height = imagesy($this->image);			
  }
  
  #--------------------------------------
  # OPEN IMAGE FILE
  #--------------------------------------
  private function OpenImageFile($file){
	  $extension = strtolower(strrchr($file, '.'));
	  switch($extension) {
		  case '.jpg':
		  case '.jpeg':
			  $img = @ImageCreateFromJPEG($file);
			  break;
		  case '.gif':
			  $img = @imagecreatefromgif($file);
			  break;
		  case '.png':
			  $img = @imagecreatefrompng($file);
			  break;
		  default:
			  $img = false;
			  break;
	  }
	  return $img;
  }

  #--------------------------------------
  # SAVE IMAGE
  #--------------------------------------
  public function saveImage($savePath, $imageQuality="100"){
	  $extension = strtolower(strrchr($savePath, '.'));
	  switch($extension){
		  case '.jpg':
		  case '.jpeg':
			  if (imagetypes() & IMG_JPG) {
				  imagejpeg($this->imageResized, $savePath, $imageQuality);
			  }
			  break;

		  case '.gif':
			  if (imagetypes() & IMG_GIF) {
				  imagegif($this->imageResized, $savePath);
			  }
			  break;

		  case '.png':
			  // *** Scale quality from 0-100 to 0-9
			  $scaleQuality = round(($imageQuality/100) * 9);

			  // *** Invert quality setting as 0 is best, not 9
			  $invertScaleQuality = 9 - $scaleQuality;

			  if (imagetypes() & IMG_PNG) {
				   imagepng($this->imageResized, $savePath, $invertScaleQuality);
			  }
			  break;

		  // ... etc

		  default:
			  // *** No extension - No save.
			  break;
	  }

	  imagedestroy($this->imageResized);
  }

  #--------------------------------------
  # RESIZE IMAGE
  #--------------------------------------
  public function ResizeImage($newWidth, $newHeight, $option="auto")
  {
	  // *** Get optimal width and height - based on $option
	  $optionArray = $this->getDimensions($newWidth, $newHeight, $option);

	  $optimalWidth  = $optionArray['optimalWidth'];
	  $optimalHeight = $optionArray['optimalHeight'];


	  // *** Resample - create image canvas of x, y size
	  $this->imageResized = ImageCreateTrueColor($optimalWidth, $optimalHeight);
	  ImageCopyReSampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


	  // *** if option is 'crop', then crop too
	  if ($option == 'crop') {
		  $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
	  }
  }

  #--------------------------------------
  # CONVERT TO JPG
  #--------------------------------------
  public function ConvertToJPG($option="auto") {
	  
	  # ORIGINAL SIZE
	  $OriginalWidth = $this->width;
	  $OriginalHeight = $this->height;

	  // *** Resample - create image canvas of x, y size
	  $this->imageResized = ImageCreateTrueColor($OriginalWidth, $OriginalHeight);
	  ImageCopyReSampled($this->imageResized, $this->image, 0, 0, 0, 0, $OriginalWidth, $OriginalHeight, $this->width, $this->height);

  }

  #--------------------------------------
  # GET DIMENSIONS
  #--------------------------------------
  private function getDimensions($newWidth, $newHeight, $option){
	 switch ($option){
		  case 'exact':
			  $optimalWidth = $newWidth;
			  $optimalHeight= $newHeight;
			  break;
		  case 'portrait':
			  $optimalWidth = $this->getSizeByFixedHeight($newHeight);
			  $optimalHeight= $newHeight;
			  break;
		  case 'landscape':
			  $optimalWidth = $newWidth;
			  $optimalHeight= $this->getSizeByFixedWidth($newWidth);
			  break;
		  case 'auto':
			  $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
			  $optimalWidth = $optionArray['optimalWidth'];
			  $optimalHeight = $optionArray['optimalHeight'];
			  break;
		  case 'crop':
			  $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
			  $optimalWidth = $optionArray['optimalWidth'];
			  $optimalHeight = $optionArray['optimalHeight'];
			  break;
	  }
	  return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  #--------------------------------------
  # GET SIZE
  #--------------------------------------
  private function getSizeByFixedHeight($newHeight){
	  $ratio = $this->width / $this->height;
	  $newWidth = $newHeight * $ratio;
	  return $newWidth;
  }
  private function getSizeByFixedWidth($newWidth){
	  $ratio = $this->height / $this->width;
	  $newHeight = $newWidth * $ratio;
	  return $newHeight;
  }
  private function getSizeByAuto($newWidth, $newHeight){
	  if ($this->height < $this->width)
	  // *** Image to be resized is wider (landscape)
	  {
		  $optimalWidth = $newWidth;
		  $optimalHeight= $this->getSizeByFixedWidth($newWidth);
	  }
	  elseif ($this->height > $this->width)
	  // *** Image to be resized is taller (portrait)
	  {
		  $optimalWidth = $this->getSizeByFixedHeight($newHeight);
		  $optimalHeight= $newHeight;
	  }
	  else
	  // *** Image to be resizerd is a square
	  {
		  if ($newHeight < $newWidth) {
			  $optimalWidth = $newWidth;
			  $optimalHeight= $this->getSizeByFixedWidth($newWidth);
		  } else if ($newHeight > $newWidth) {
			  $optimalWidth = $this->getSizeByFixedHeight($newHeight);
			  $optimalHeight= $newHeight;
		  } else {
			  // *** Sqaure being resized to a square
			  $optimalWidth = $newWidth;
			  $optimalHeight= $newHeight;
		  }
	  }

	  return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

  #--------------------------------------
  # GET CROP
  #--------------------------------------
  private function getOptimalCrop($newWidth, $newHeight){

	  $heightRatio = $this->height / $newHeight;
	  $widthRatio  = $this->width /  $newWidth;

	  if ($heightRatio < $widthRatio) {
		  $optimalRatio = $heightRatio;
	  } else {
		  $optimalRatio = $widthRatio;
	  }

	  $optimalHeight = $this->height / $optimalRatio;
	  $optimalWidth  = $this->width  / $optimalRatio;

	  return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }
  #--------------------------------------
  # CROP
  #--------------------------------------
  private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight){
	  // *** Find center - this will be used for the crop
	  $cropStartX = ( $optimalWidth / 2) - ( $newWidth / 2);
	  $cropStartY = ( $optimalHeight/ 2) - ( $newHeight/ 2);

	  $crop = $this->imageResized;
	  //imagedestroy($this->imageResized);

	  // *** Now crop from center to exact requested size
	  $this->imageResized = ImageCreateTrueColor($newWidth , $newHeight);
	  ImageCopyReSampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
  }
  
  
  #--------------------------------------
  # SIZE
  #-------------------------------------- 
  public function GetImageSize($file) {
		$arr = @getimagesize($file); # FALSE IF NOT VALID IMAGE
		return $arr;
   }
  
  
}
?>
