<?php
namespace CORE;
class TR_CONTROLS extends COMPONENT
{		
		static function PRECODE($attributes=NULL)
		{
			$base_path = $attributes['base-path'] ?? NULL;
			$edit_modal = $attributes['edit-modal'] ?? NULL;
			$delete_modal = $attributes['delete-modal'] ?? $base_path.'core/modals/modal.db.dataset.delete.backup/modal.php' ?? NULL;
			$delete_disabled = $attributes['delete-disabled'] ?? NULL;
			if($delete_disabled) $del_disabled = "disabled"; else $del_disabled = "";		
			$restore_modal = $attributes['delete-modal'] ?? $base_path.'core/modals/modal.db.dataset.restore/modal.php' ?? NULL;
			$dataset = $attributes['dataset'] ?? NULL;
			$backup_data = $attributes['backup-data'] ?? NULL;
			$TXT = $attributes['txt'] ?? NULL;
			$data_table = $attributes['data-table'] ?? NULL;
			$data_unique_id = $attributes['data-unique-id'] ?? NULL;
			$movable = $attributes['movable'] ?? NULL;

			BTN::PRE(array(
				"class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
				"title"=>$TXT['Edit'],
				'data-path'=>$edit_modal,
				'data-table'=>$data_table,
				'data-condition'=>$data_unique_id, 
				'data-bs-toggle'=>'tooltip'     
			));
				echo BI::GET(array('icon'=>'pencil'));
			BTN::POST();  

			BTN::PRE(array(
						"class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
						"title"=>$TXT['Delete'],
						'data-path'=>$delete_modal,
						'data-table'=>$data_table,
						'data-unique_id'=>$data_unique_id,
						'data-bs-toggle'=>'tooltip', 
						''=>$del_disabled  
					)
			);
				echo BI::GET(array('icon'=>'trash3'));
			BTN::POST(); 

			if($backup_data)
			{
				BTN::PRE(array(
							"class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
							"title"=>$TXT['Restore previous version']."<br>".$TXT['Author: '].$backup_data[0]['edited_by']."<br>".$TXT['Last edit: '].date("F j, Y, g:i a",$backup_data[0]['edited_date']),
							'data-path'=>$restore_modal,
							'data-table'=>$data_table,
							'data-unique_id'=>$data_unique_id,
							'data-bs-toggle'=>'tooltip',
							'data-bs-html'=>'true'  
						)
				);
					echo BI::GET(array('icon'=>'arrow-counterclockwise'));
				BTN::POST();   
			}
			else
			{
				BTN::PRE(array(
							"class"=>"btn btn-sm btn-outline-secondary",
							"title"=>$TXT['Author: '].$dataset['created_by']."<br>".$TXT['Date: '].date("F j, Y, g:i a",(int)$dataset['created_date']),
							'data-bs-toggle'=>'tooltip',
							'data-bs-html'=>'true', 
						)
				);
					echo BI::GET(array('icon'=>'info-circle'));
				BTN::POST();                                         
			}
			if($movable)
			{
				
				A::PRE(array("class"=>"js-sortable-handle btn btn-sm btn-outline-primary",'style'=>'margin-left:15px;'));
				echo BI::GET(array('icon'=>'arrow-down-up','size'=>'20',"style"=>"position:relative;top:2px;"));
				A::POST();
			}
		}

		static function POSTCODE($attributes=NULL)
		{
			$CODE = "</button>".PHP_EOL;
			return $CODE;
		}	
}
?>