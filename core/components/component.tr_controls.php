<?php
namespace CORE;
class TR_CONTROLS extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$caption = $attributes['caption'] ?? NULL;
			$attributes = (new self)::REMOVE($attributes, array('caption'));

			//$CODE = "<button".(new self)->WRITE_ATTRIBUTES($attributes).">".$caption.PHP_EOL;
			//return $CODE;
			BTN::PRE(array(
				"class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
				"title"=>$TXT['Edit'],
				'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.edit.php",
				'data-table'=>'app_assets',
				'data-condition'=>$asset_row['id'], 
				'data-bs-toggle'=>'tooltip'     
			));
				echo BI::GET(array('icon'=>'pencil'));
			BTN::POST();  

			BTN::PRE(array(
						"class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
						"title"=>$TXT['Delete'],
						'data-path'=>$EXT_ARRAY['DOM_PATH'].'core/modals/modal.db.dataset.delete/modal.php',
						'data-table'=>'app_assets',
						'data-id'=>$asset_row['id'],
						'data-bs-toggle'=>'tooltip'   
					)
			);
				echo BI::GET(array('icon'=>'trash3'));
			BTN::POST(); 
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</button>".PHP_EOL;
			return $CODE;
		}	
}
?>