<?php
//writes the HTML code for a bootstrap card

class CARD extends CORE\COMPONENT
	{	//class, style, image, imageclass, title
		static function PRECODE($params=NULL,$data=NULL)
		{
			$image = $params['image'] ?? NULL;
			if($image) $image = "<img src='".$params['image']."' class='card-img-top ".(new self)->WRITE_S($params,'imageclass')."'>";
			
			$title = $params['title'] ?? NULL;
			if($title) $title = "<h5 class='card-title ".(new self)->WRITE_S($params,'titleclass')."'>".$params['title']."</h5>"; 
			
			$CODE = "<div class='card ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style').">
			".$image."
			<div class='card-body'>
			".$title."
			";
			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</div>
			</div>
			";
			return $CODE;
		}
	}
?>