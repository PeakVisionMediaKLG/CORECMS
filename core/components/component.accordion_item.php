<?php
//displays a bootstrap accordion sub-item

class ACCORDION_ITEM extends CORE\COMPONENT
{		//id,buttonclass,parentid,heading,show,singlecollapse
		static function PRECODE($params=NULL,$data=NULL)
		{	
			if(@$params['show']=="show") $area_expanded="true"; else $area_expanded="false";
			if(@$params['id']=="") $params['id']= time();
			if(isset($params['data-bs-parent'])) $dataparent="data-bs-parent='#".(new self)->WRITE_S($params,'parentid')."'"; else $dataparent=""; 
			$CODE = "
			  <div class='card'>
				<div class='card-header' id='heading_".(new self)->WRITE_S($params,'id')."'>
				  <h2 class='mb-0'>
					<button class='btn btn-link core-acc-link btn-block ".(new self)->WRITE_S($params,'buttonclass')."' type='button' data-bs-toggle='collapse' data-bs-target='#".(new self)->WRITE_S($params,'id')."' aria-expanded='$area_expanded' aria-controls='".(new self)->WRITE_S($params,'id')."' ".(new self)->WRITE_DATA($data).">
					  ".(new self)->WRITE_S($params,'heading')."
					</button>
				  </h2>
				</div>

				<div id='".(new self)->WRITE_S($params,'id')."' class='collapse ".(new self)->WRITE_S($params,'show')."' aria-labelledby='".(new self)->WRITE_S($params,'id')."' $dataparent>
				  <div class='card-body'>
			";

			return $CODE;
		}

		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</div>
				</div>
			  </div>
			";
			return $CODE;
		}	

}
?>