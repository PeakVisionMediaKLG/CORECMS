<?php 

namespace CORE;
class COMPONENT
{
	public $DB;
	public $PARAMS;
	public $PRINT = 1;
	public $CHILDREN;	
	

		static function PRE($params=NULL,$data=NULL)
		{
			$CODE = STATIC::PRECODE($params,$data);
			echo $CODE;
		}
	

		static function POST($params=NULL,$data=NULL)
		{
			$CODE = STATIC::POSTCODE($params,$data);
			echo $CODE;
		}	


		static function PRINT($params=NULL,$data=NULL)
		{
			$print = STATIC::PRINTCODE($params,$data);
			echo $print;
		}	
	

		static function PRE_R($params=NULL,$data=NULL)
		{
			$CODE = STATIC::PRECODE($params,$data);
			return $CODE;
		}
	

		static function POST_R($params=NULL,$data=NULL)
		{
			$CODE = STATIC::POSTCODE($params,$data);
			return $CODE;
		}	


		static function PRINT_R($params=NULL,$data=NULL)
		{
			$print = STATIC::PRINTCODE($params,$data);
			return $print;
		}		
	
	
	function WRITE($params,$what)
		{	
			if(isset($params) and count($params)>0){
				foreach($params as $key => $value)
					{
						if($key == $what)
						{
							return " ".$key.'="'.trim($value).'"';
						}

					}
				}
		}

		
	function WRITE_S($params,$what)
		{	
			if(isset($params) and count($params)>0){
				foreach($params as $key => $value)
					{
						if($key == $what)
						{
							return trim($value);
						}

					}
				}
		}
	

	function WRITE_DATA($data)
	{	
		if($data!=NULL and count($data)>0){
			$data_collection="";
			foreach($data as $key => $value)
				{
					if(is_array($value))
					{
						foreach($value as $subkey => $subvalue)
						{
							$data_collection.=" ".$subkey.'="'.trim($subvalue).'" ';
						}
					}
					else
					{
						$data_collection.=" ".$key.'="'.trim($value).'" ';
					}
				}
			return $data_collection;
			}
	}		

}

$dir = new \DirectoryIterator(ROOT."core/components/");
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        require_once(ROOT."core/components/".$fileinfo->getFilename());
    }
}


/* //example of a child class

class CONTAINER extends BE_COMPONENT
	{	//class, style
		
		static function PRECODE($params=NULL,$data=NULL)
		{
			$CODE = "<div ".(new self)->WRITE($params,'class')." ".(new self)->WRITE($params,'style').">
			";
			return $CODE;
		}
	
		static function POSTCODE($params=NULL,$data=NULL)
		{
			$CODE = "</div>
			";
			return $CODE;
		}		

	}
*/
?>