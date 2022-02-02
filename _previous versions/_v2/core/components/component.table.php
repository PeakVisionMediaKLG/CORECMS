<?php
//prints out a html/bootstrap table

class TABLE extends BE_COMPONENT
	{
	static function PRECODE ($params=NULL, /*$headers=NULL,*/ $data=NULL)
		{
			/* Params: class, label */
			$CODE = "<table class='table table-responsive ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE_DATA($data).">";
			if(@$params['headers']!=NULL){
				$CODE_headers="";
				foreach($params['headers'] as $key => $value)
				{
					$CODE_headers.="<th scope='col'>$value</th>";		
				}
				$CODE .= "<thead><tr>".$CODE_headers."</tr></thead>";
			}
			$CODE .= "<tbody>";
			return $CODE;
		}
	
	static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</tbody>
				</table>
			";
			return $CODE;
		}
	}
?>