<?php
namespace CORE;
class CARD extends COMPONENT
	{	
		static function PRECODE($attributes=NULL)
		{
			$image = $attributes['image'] ?? NULL;
			$image_class = $attributes['image-class'] ?? NULL;
			$title = $attributes['title'] ?? NULL;
			$title_class = $attributes['title-class'] ?? NULL;

			$attributes = (new self)::REMOVE($attributes, array('image','image-class','title','title-class'));

			if($image){ $image = "<img src='".$image."' class='card-img-top ".$image_class."'>";}

			if($title) $title = "<h5 class='card-title ".$title_class."'>".$title."</h5>"; 
			
			$attributes = (new self)::FORCE($attributes, array('class'=>'card'));

			$CODE = "<div".(new self)->WRITE_ATTRIBUTES($attributes).">
			".$image."		
			<div class='card-body'>
			".$title;
			return $CODE;
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</div>
			</div>".PHP_EOL;
			return $CODE;
		}
	}
?>