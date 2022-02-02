<?php
//prints out custom user created html code

class HTML extends BE_COMPONENT
	{	//content
		static function PRINTCODE($params=NULL,$data=NULL)
		{
			return (new self)->WRITE_S($params,'content');				
		}
	}

?>