<?php

class DB {
    
    public $SETTINGS;
    
    function __construct($SETTINGS,$SESSIONDATA)
        {
            $this->SETTINGS = $SETTINGS;
            $this->SESSIONDATA = $SESSIONDATA;

            $this->DB = new MySQLi($SETTINGS['mysql_server'],$SETTINGS['mysql_user'],$SETTINGS['mysql_password'],$SETTINGS['mysql_db']);
            //$this->DB->query("SET GLOBAL general_log = 'ON'");
            $additional_settings = $this->MULTI_ROW("SELECT settings.* FROM settings");

            while($settingsrow = $additional_settings->fetch_array())
            {    
                 $this->SETTINGS[$settingsrow['sSetting']] = $settingsrow['sValue'];  
            }
        
            $this->DB->set_charset('utf8');
        
        }	

    function PREP_QUERY($query,$table,$columns,$parameters,$reporting=0)
        {
            $query=trim($query);
        
            if(count($columns)<>count($parameters)){ if($reporting){ echo "ERROR PREP_QUERY: column and parameter counts don't match";} return 0;}
            if($reporting){echo "\r\n///".$query." //Parameters: \r\n"; print_r($parameters);}
            
            $types=array();
            foreach($parameters as $key => $value)
            {
                
                if(is_numeric($value))
                {
                    switch(gettype($value))
                    {
                        case "boolean":
                        case "integer":
                            array_push($types,"i");
                        break;
                        case "double":
                            array_push($types,"d");
                        break;
                        default:
                            array_push($types,"i");
                        break;    
                    }
                }
                else
                {
                    switch(gettype($value))
                    {
                        case "string":
                            array_push($types,"s");
                        break;
                        default:
                            array_push($types,"s");
                        break;    
                    }                    
                }

            }
            /*foreach($columns as $key => $value)
                { 
                        $checktype="SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '".$columns[$key]."'";
                        $thetype=$this->SINGLE_ROW($checktype);

                        switch ($thetype[0]){
                            case "int":
                            case "tinyint":
                            case "smallint":
                            case "mediumint":
                            case "bigint":
                                array_push($types,"i");  
                            break;
                            case "double":
                            case "float":    
                                array_push($types,"d");
                            break;
                            case "blob":
                                array_push($types,"b");
                            break;                                        
                            case "string":
                            case "varchar":    
                            default:
                                array_push($types,"s");
                            break;
                        }
                }*/
            $typestring=implode("",$types);
        
            $query_type=substr($query,0,6);
            
            $statement=$this->DB->prepare($query);
            if(false===$statement) { echo ("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);}
        
            switch($query_type)
            {
                case "SELECT":
                    $bound = @$statement->bind_param($typestring, ...$parameters);
                    if ( false===$bound ) { echo("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);}
                    $statement->execute();
                    $result = $statement->get_result();
                    if($reporting)
                        {   if($result->num_rows === 0) 
                                {
                                    echo 'The following SQL: ///' . $query . '/// generated NO RESULT: ' . $this->DB->errno . ' ' . $this->DB->error;
                                }
                            echo $this->DB->info."\r\n"."-------------------------------------------------------"." \r\n";
                        }                    
                    $statement->close();
                    return $result;
                break;
                case "UPDATE":
                    $bound = @$statement->bind_param($typestring, ...$parameters); 
                    if ( false===$bound ) { echo("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);} 
                    $statement->execute();
                    if($reporting)
                        {   if($statement->affected_rows === 0) 
                                {
                                    echo 'The following SQL: '.$typestring.'///' . $query . '/// generated NO RESULT: ' . $this->DB->errno . ' ' . $this->DB->error;
                                }
                            echo $this->DB->info."\r\n"."-------------------------------------------------------"." \r\n";
                        }
                    if($statement->affected_rows === 0) {$statement->close(); return 0;} else { $statement->close(); return 1;}
                break;
                case "INSERT":
                    $bound = $statement->bind_param($typestring, ...$parameters); 
                    if ( false===$bound ) { echo("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);} 
                    $statement->execute();
                    if($reporting)
                        {   if($statement->affected_rows === 0) 
                                {
                                    echo 'The following SQL: ///' . $query . '/// generated NO RESULT: ' . $this->DB->errno . ' ' . $this->DB->error; 
                                }
                            echo $this->DB->info."\r\n"."-------------------------------------------------------"." \r\n";
                        }
                    if($statement->affected_rows === 0) {$statement->close(); return 0;} else { $statement->close(); return 1;}
                break;
                case "DELETE":
                    $bound = @$statement->bind_param($typestring, ...$parameters); 
                    if ( false===$bound ) { echo("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);} 
                    $statement->execute();
                    if($reporting)
                        {   if($statement->affected_rows === 0) 
                                {
                                    echo 'The following SQL: ///' . $query . '/// generated NO RESULT: ' . $this->DB->errno . ' ' . $this->DB->error; 
                                }
                            echo $this->DB->info."\r\n"."-------------------------------------------------------"." \r\n";
                        }
                    if($statement->affected_rows === 0) {$statement->close(); return 0;} else { $statement->close(); return 1;}
                break;
                default:
                    echo "Statement not recognized";
                break;    
            }
        
        }
  
    function LOCK ($table)
        {
            $sql="LOCK TABLES $table READ;";
            $result=$this->DB->query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
        }

    function UNLOCK ($table)
        {
            $sql="UNLOCK TABLE $table;";
            $result=$this->DB->query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
        }

   function SINGLE_ROW ($xsql)
        {
            $sql = $xsql." LIMIT 1" ;

            $result = $this->DB->query($sql); 
        
            if($result === false) {
                trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else
            {
                $data = $result->fetch_array();
                return $data;
            }
        }
     
    function SINGLEROW_NOLIMIT ($xsql)
        {
            $sql = $xsql;

            $result = $this->DB->query($sql); 
        
            if($result === false) {
                trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else
            {
                $data = $result->fetch_array();
                return $data;
            }
        }

    /*function SINGLEROW_RESULTONLY ($xsql)
        {
            $sql = $xsql." LIMIT 1" ;
                //echo $sql;
            $result = $this->DB->query($sql);
        
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else
            {
            return $result;
            }
        }	*/

    function MULTI_ROW ($sql)
        {
            $result = $this->DB->query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else{
            return $result;}
        }

    function KEYVALASSIGNARRAY ($sql)
        {
                /*erstellt ein array aus allen reihen eines 2-spaltigen tables,
                wobei der inhalt der ersten spalte zum key der jeweiligen array-zeile wird*/

            $stararray = array();
            $result = $this->DB->query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else{        
                while($row = $result->fetch_array())
                {
                    $stararray[$row[0]]= $row[1];
                }
            return $stararray;}
        }

 /*   function QUERY ($sql)
        {
            $result = $this->DB->query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
        }

    function MULTI_QUERY($sql)	
        {
            $result = $this->DB->multi_query($sql);
            if($result === false) {
              trigger_error('The following SQL: ///' . $sql . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }        
        }
*/
    function ESCAPE ($string)
        {
                //echo $string;
            $result = $this->DB->real_escape_string($string);
            if($result === false) {
              trigger_error('The following string could not be real_escaped: ///' . $string . '/// Error: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_ERROR);
            }
            else{
            return $result;}
        }

    function CLEAN ($input)
        {

            $result = htmlentities($this->ESCAPE($input));
            return $result;	
        }

    function CLOSE()	
        {
         $this->DB->close();
        }	

    function __destroy()	
        {
         $this->DB->close();
        }
}

?>