<?php //class.db.php

class DB {
    
    private $dbConfig;
    public  $dbPrefix;

    private $dbPrintMessages;
    private $dbLogMessages;

    private $dbEncryptionKey;
    private $dbEncryptionSalt;

    public  $SETTINGS;

    private $preparedQuery;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
	public $preparedQueryCount = 0;

    function __construct()
        {
            require_once(ROOT."config/config.php");
			$this->dbConfig = $CONFIG;
            
            $this->DB = new MySQLi($this->dbConfig['mysqlServer'],$this->dbConfig['mysqlUser'],$this->dbConfig['mysqlPassword'],$this->dbConfig['mysqlDB']);
            $this->DB->set_charset('utf8mb4');

            $this->dbPrefix = $this->dbConfig['mysqlTablePrefix']."_"; 
            if($this->dbPrefix=="_") $this->dbPrefix="";

            $this->dbEncryptionKey = $this->dbConfig['mysqlEncryptionKey'];
            $this->dbEncryptionSalt = $this->dbConfig['mysqlEncryptionSalt'];           
            
            /* //for debugging in case of unexpected errors  
            $this->DB->query("SET GLOBAL general_log = 'ON'");  
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            */

            $this->LOAD_SETTINGS();
            //var_dump($this);
        }


    function EASY_QUERY($queryType,
                          $table,
                          $columns,
                          $columnValues,
                          $conditions,
                          $conditionValues,
                          $extended="",
                          $logAction=1
                         )
        {   
            //make each db access unique
            $actionIdentifier = $queryType.time();
            $queryType=trim($queryType);
            $table=$this->dbPrefix.$table;

            //prepare log variables
            $queryResult="SUCCESS";
            $attemptDate=time();
            $errorMessage="";

            //Check the initial data for correct number of arguments.
            $initialCheckMessage="";
            $initialFatalError=0;
            if($queryType=="") {$initialCheckMessage .= "\r\n"."ERROR (Easy Query) - No query type provided."; $initialFatalError=1;}
            if($table=="") {$initialCheckMessage .= "\r\n"."ERROR (Easy Query) - No table provided."; $initialFatalError=1;}

            switch($queryType)
            {
                case "SELECT":
                    if(count($conditions)<>count($conditionValues)){ $errorMessage .= "\r\n"."ERROR (Easy Query) SELECT - Conditions & argument counts do not match."; $initialFatalError=1;}
                    if(count($columns)<1) {$errorMessage .= "\r\n"."ERROR (Easy Query) - No columns provided."; $initialFatalError=1; }
                break;
                case "UPDATE":
                    if(count($columns)<1) {$errorMessage .= "\r\n"."ERROR (Easy Query) UPDATE - No columns provided."; $initialFatalError=1;}
                    if(count($columns)<>count($columnValues)) {$errorMessage .= "\r\n"."ERROR (Easy Query) UPDATE - Column & value counts do not match."; $initialFatalError=1;}
                    if(count($conditions)<>count($conditionValues)) {$errorMessage .= "\r\n"."ERROR (Easy Query) UPDATE - Conditions & argument counts do not match."; $initialFatalError=1;}
                break;  
                case "INSERT":
                    if(count($columns)<1) {$errorMessage .= "\r\n"."ERROR (Easy Query) INSERT - No columns provided."; $initialFatalError=1;}
                    if(count($columns)<>count($columnValues)) {$errorMessage .= "\r\n"."ERROR (Easy Query) INSERT - Column & argument numbers do not match."; $initialFatalError=1;}
                break; 
                case "DELETE":
                    if(count($conditions)<1) {$errorMessage .= "\r\n"."ERROR (Easy Query) DELETE - No conditions provided."; $initialFatalError=1;}
                    if(count($conditions)<>count($conditionValues)) {$errorMessage .= "\r\n"."ERROR (Easy Query) DELETE - Conditions & argument numbers do not match."; $initialFatalError=1;}
                break; 
                default:
                    $errorMessage .= "\r\n"."ERROR (Easy Query) Incorrect query type."; $initialFatalError=1;
                break;    
            }
        
            if($initialFatalError and $this->dbPrintMessages) 
            {
                echo "INITIAL FATAL ERROR ".$errorMessage; 
                exit;
            }

            $allColumns="";
            $noConditions=0;  
        
            //Catch special cases, prepare and clean parameters array.
            switch($queryType)
            {
                case "SELECT":
                    if(count($columns)==1 and $columns[0]=="*") 
                    {
                        $allColumns="*"; unset($columnValues); $columnValues=array();unset($columns); $columns=array();  // For the SELECT * FROM ... statement.
                    }
                    if(count($conditions)<1) 
                    {
                        $noConditions=1; //SELECT statement without conditions, getting all datasets.
                        unset($conditionValues); $conditionValues=array();
                    }                    
                break;
                case "UPDATE":
                    if(count($conditions)<1) 
                    {
                        $noConditions=1; //UPDATE statement without conditions, affecting all datasets.
                        unset($conditionValues); $conditionValues=array();
                    }
                break;
                case "INSERT":
                    unset($conditionValues); $conditionValues=array();
                break;
                case "DELETE":
                    unset($columnValues); $columnValues=array();
                break;    
            }
            $parameters = array_merge($columnValues,$conditionValues);

        
            //Prepare the query string
            $columnString="";
			$extended=" ".$extended;
            switch($queryType)
            {
                case "SELECT":
                    foreach($columns as $value){
                        $columnString .= $value.", ";
                    }
                    $query="SELECT ".$allColumns.substr($columnString,0,-2)." FROM ".$table;
                    if(count($conditions)>0)
                    {
                        $conditionString=" WHERE ";
                        foreach($conditions as $value){
                            $conditionString .= $value."=? AND ";
                        }
                        $query.=substr($conditionString,0,-4); 
                    }
					$query.=$extended;
                break;    
                case "UPDATE":
                    $query="UPDATE ".$table." SET ";
                    foreach($columns as $value){
                        $columnString .= $value."=?, ";
                    }
                    $query.=substr($columnString,0,-2);
                    
                    if($noConditions<>1)
                    {
                        $conditionString=" WHERE ";
                        foreach($conditions as $value){
                            $conditionString .= $value."=? AND ";
                        }
                        $query.=substr($conditionString,0,-4);     
                    }
                    $query.=$extended;
                break;
                case "INSERT":
                    $query="INSERT INTO ".$table." (";
                    foreach($columns as $value){
                        $columnString .= $value.", ";
                    }
                    $query.=substr($columnString,0,-2).") VALUES (";
                    foreach($columnValues as $value)
                    {
                        $query.="?,";    
                    }
                    $query=substr($query,0,-1).")".$extended;
				break;
                case "DELETE":
                    $parameters = $conditionValues;                   
                    $query="DELETE FROM ".$table;
                    if(count($conditions)>0)
                    {
                        $conditionString=" WHERE ";
                        foreach($conditions as $value){
                            $conditionString .= $value."=? AND ";
                        }
                        $query.=substr($conditionString,0,-4);    
                    }
					$query.=$extended;
                break;
            } 
        
            //Generate type string for prepared statement
            $types=array();
            foreach($parameters as $key => $value)
            {
                array_push($types,$this->_gettype($value));
            }
            $typeString=implode("",$types);
              
            $statement=$this->DB->prepare($query);
            $statementError="";

            if(false===$statement) 
            { 
                if($this->dbPrintMessages) echo ("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error);
                $errorMessage .= "\r\n".'The following SQL: ///' . $query . '/// generated an ERROR: ' . $this->DB->errno . ' ' . $this->DB->error;
            }

        
            //Bind parameters, execute the statement
            //print_r($parameters);
            if(count($parameters)>0){
			$bound = $statement->bind_param($typeString, ...$parameters);
				if($this->dbLogMessages)
				{
                    if ( false===$bound ) 
                    { 
                        if($this->dbPrintMessages) echo("\r\n".'The following SQL: ///' . $query . '/// generated an ERROR when binding parameters: ' . $this->DB->errno . ' ' . $this->DB->error);
                        $errorMessage .= "\r\n".'The following SQL: ///' . $query . '/// generated an ERROR when binding parameters: ' . $this->DB->errno . ' ' . $this->DB->error;
                    }
				}
			}
            
            $statement->execute(); 
            
            $executeWarning="";

            switch($queryType)
            {
                case "SELECT":
                    $result = $statement->get_result();
                    if($this->dbLogMessages)
                        {   if($result->num_rows === 0) 
                                {
                                    if($this->dbPrintMessages) echo 'The following SQL: ///' . $query . '/// generated NO RESULT with SELECT - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                    $errorMessage .= 'The following SQL: ///' . $query . '/// generated NO RESULT with SELECT - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                }
                        }                    
                    $statement->close();
                    $RETURN_VALUE = $result;
                break;
                case "UPDATE":
                    if($this->dbLogMessages)
                        {   if($statement->affected_rows === 0) 
                                {
                                    if($this->dbPrintMessages) echo 'The following SQL: /// ' . $query . ' /// generated NO RESULT with UPDATE - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                    $errorMessage .= 'The following SQL: /// ' . $query . ' /// generated NO RESULT with UPDATE - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                }
                        }
                    if($statement->affected_rows === 0) {$statement->close(); $RETURN_VALUE =  0;} else { $statement->close(); $RETURN_VALUE =  1;}
                break;
                case "INSERT":
                    if($this->dbLogMessages)
                        {   if($statement->affected_rows === 0) 
                                {
                                    if($this->dbPrintMessages) echo 'The following SQL: ///' . $query . '/// generated NO RESULT with INSERT - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                    $errorMessage .= 'The following SQL: ///' . $query . '/// generated NO RESULT with INSERT - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                }

                        }
                    if($statement->affected_rows === 0) {$statement->close(); $RETURN_VALUE =  0;} else { $statement->close(); $RETURN_VALUE =  1;}
                break;
                case "DELETE":
                    if($this->dbLogMessages)
                        {   if($statement->affected_rows === 0) 
                                {
                                    if($this->dbPrintMessages) echo 'The following SQL: ///' . $query . '/// generated NO RESULT with DELETE - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error; 
                                    $errorMessage .= 'The following SQL: ///' . $query . '/// generated NO RESULT with DELETE - ERRORCODE:' . $this->DB->errno . ' ' . $this->DB->error;
                                }
                        }
                    if($statement->affected_rows === 0) {$statement->close(); $RETURN_VALUE =  0;} else { $statement->close(); $RETURN_VALUE =  1;}
                break;
            }

            // Add action to table db_log
           // echo "a:".$this->dbLogMessages." b:".$logAction;

            if($this->dbLogMessages and $logAction) 
            {   
                $this->LOG_ACTION($actionIdentifier,$queryType,$table,$columns,$columnValues,$conditions,$conditionValues,$extended,$parameters,$typeString,$errorMessage);
            }

            return $RETURN_VALUE;
        }

        function LOG_ACTION($actionIdentifier,
                            $queryType,
                            $table,
                            $columnKeys,
                            $columnValues,
                            $conditionKeys,
                            $conditionValues,
                            $extended,
                            $parameters,
                            $typeString,
                            $errorMessage = NULL,
                            $querySuccess = 1
                            )
        {
            $encodedColumns=json_encode($columnKeys);
            $encodedColumnValues=json_encode($columnValues);
            $encodedCondition=json_encode($conditionKeys);
            $encodedConditionValues=json_encode($conditionValues);
            $encodedParameters=json_encode($parameters);

            $errorMessage = $errorMessage ?? '';
            if($errorMessage!="") $querySuccess = 0;

            $this->EASY_QUERY("INSERT",
                            "core_dblog",
                            array('identifier','query_type','affected_table','column_keys','column_values','condition_keys','condition_values','extended','parameters','type_string',
                            'attempt_date','error_message','query_success'),
                            array($actionIdentifier,$queryType,$table,$encodedColumns,$encodedColumnValues,$encodedCondition,$encodedConditionValues,$extended,$encodedParameters,$typeString,
                            time(),$errorMessage,$querySuccess),
                            array(),
                            array(),
                            "",
                            0
                           );
        }

        function LOAD_SETTINGS ()
        {
            $dbSettings = $this->EASY_QUERY("SELECT",
                                            "core_settings",
                                            array('*'),
                                            array(),
                                            array(),
                                            array(),
                                            " ORDER BY id ASC",
                                            0
                                            );
            if($dbSettings){
                while($settingsRow = $dbSettings->fetch_array())
                {    
                     $this->{$settingsRow['name']} = $settingsRow['value'];  
                }
            }
        }


        function REMAP_MULTIDIM_ARRAY ($mysqliResult,$newKey)
		{
			$newArray=array();
			
			while($row=$mysqliResult->fetch_array())
			{
				foreach($row as $key => $value) 
				{
					if($key == $newKey) $rowKey=$value;
				}
				
				if(isset($rowKey)){
					foreach($row as $key => $value) 
					{
						$newArray[$rowKey][$key]=$value;
					}
				}
					
			}
			return $newArray;
		}
    
        
	function REMAP_UNIDIM_ARRAY ($mysqliResult,$newKey,$newValue)
		{
			$newArray=array();
			
			while($row=$mysqliResult->fetch_array())
			{
						$newArray[$row[$newKey]]=$row[$newValue];
			}
			return $newArray;
		}	
  
        
    function ESCAPE_STRING ($string)
        {
            $result = $this->DB->real_escape_string($string);
            if($result === false) 
            {
              trigger_error('The following string could not be real_escaped: ///' . $string . '/// Error: ' . $this->DB->errno . ' ' . $this->DB->error, E_USER_NOTICE);
            }
            else
            {
            return $result;
            }
        }

    
    function CLEAN_STRING ($input)
        {
            $result = htmlentities($this->ESCAPE_STRING($input));
            return $result;	
        }    


    function CLOSE_DB()	
        {
            $this->DB->close();
        }	

    
    function __destroy()	
        {
            $this->DB->close();
        }
    
        
    function DB_DUMP($selectedTables = '*',$userCreated=0)
    {
        //get the table name(s)

        $tables = array();
        $allTables = $this->DB->query('SHOW TABLES');

        while($row = $allTables->fetch_row())
        {
            $tables[] = $this->dbPrefix.$row[0];
        }

        if($selectedTables != '*')
        {
            if(is_array($selectedTables)){
                foreach($selectedTables as $key => $selectedTable )
                {
                    if(!in_array($selectedTable,$tables)) die('A database table could not be found.');
                }
            }
            $tables = is_array($selectedTables) ? $tables : explode(',',$selectedTables);
            //echo "Predefined tables"; print_r($tables);            
        }
        //print_r($tables);
        //echo "<br><br>";
        
        //cycle through all tables
        $returnValue ="";
        foreach($tables as $table)
        {
            $result = $this->DB->query('SELECT * FROM '.$table);
            
            $num_fields = $result->field_count;

            //echo "<br><br>"; echo $table." has fields:".$num_fields;echo "<br><br>";
                
            $returnValue .= 'DROP TABLE IF EXISTS '.$table.';';

            $tableName = $this->DB->query('SHOW CREATE TABLE '.$table);
            $tableNameRow = $tableName->fetch_row();
            $returnValue .= "\n\n".$tableNameRow[1].";\n\n";
            
            for ($i=0; $i<$num_fields; $i++) 
            {
                while($row = $result->fetch_row())
                {
                    $returnValue .= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++) 
                    {
                        //$row[$j] = addslashes($row[$j]);

                        //TODO WHAT IS THAT?

                        //echo $row[$j]."vor";
                        //$row[$j] =preg_replace("\n","\\n",$row[$j]);
                        //echo $row[$j]."nach";
                        if (isset($row[$j])) { $returnValue .= '"'.$row[$j].'"' ; } else { $returnValue .= '""'; }
                        if ($j < ($num_fields-1)) { $returnValue .= ','; }
                    }
                    $returnValue .= ");\n";
                }
            }
            $returnValue.="\n\n\n";
            
            
        }
        //echo $returnValue;
        //save file
            if($userCreated) $filenamePrefix="user-"; else $filenamePrefix="core-";
            $filename = $filenamePrefix.'db-backup-'.time().'.log';
            $handle = fopen(ROOT."/backups/".$filename,'w+');
            $this->backupFile = ROOT."/backups/".$filename;
            //echo $this->backupFile;
        fwrite($handle,$this->DUMP_ENCRYPT($returnValue));
        fclose($handle); 
        return $this->backupFile;
    }
        
    function DUMP_TIMESTAMP($filename)
    {
        //converts timestamp in filename of dump into date and time string
        //echo explode("-",$filename)[3]; 
        return date('d/M/Y H:i:s',intval(explode("-",$filename)[3]));    
    }

    function DUMP_ENCRYPT($file)
    {
        /*//Encrypts file , used for dump files
        $handle = fopen($file,'r+') or die();
        $simple_string=fread($handle,filesize($file));
        fclose($handle); */
        $simple_string = $file;

        // Store the cipher method 
        $ciphering = "AES-128-CTR"; 
        $ciphers = openssl_get_cipher_methods();
        foreach ($ciphers as $key => $val){
        //echo $key." => ".$val."<br>";
        }
        
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        
        // Non-NULL Initialization Vector for encryption 
        $encryption_iv = $this->dbEncryptionSalt; //'1234567891011121'; 
        
        // Store the encryption key 
        $encryption_key = $this->dbEncryptionKey; //"core-cms"; 
        
        // Use openssl_encrypt() function to encrypt the data 
        $encryption = openssl_encrypt($simple_string, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
        
        // Display the encrypted string 
        //echo "Encrypted String: " . $encryption ."\n". strlen($encryption) ."\n"; 
        return $encryption;
    }
    
    
    function DUMP_DECRYPT($file)
    {/*Decrypts the file $file, $ciphering must be identical to DUMP_ENCRYPT $ciphering as well as 
        $decryption_key = $encryption_key and $decryption_iv identical to $encryption_iv* and
        $options*/  
        
        //take the same arguments as in DUMP_ENCRYPT
        $ciphering = "AES-128-CTR";
        $decryption_iv = $this->dbEncryptionSalt; 
        $decryption_key = $this->dbEncryptionKey;
        $options=0; 

        //open $file , read encryted DUMP into $encryption
        $handle = fopen($file,'r+') or die();
        $encryption = fread($handle,filesize($file));
        fclose($handle);
        // decrypt £encryption
        $decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, 0, $decryption_iv);  
        //echo '<br><br>'.$decryption ; 
        return $decryption;
    }

    public function PREPARED_QUERY($query) {
        
		if ($this->preparedQuery = $this->DB->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
				$types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
							$types .= $this->_gettype($args[$k][$j]);
							$args_ref[] = &$a;
						}
					} else {
	                	$types .= $this->_gettype($args[$k]);
	                    $args_ref[] = &$arg;
					}
                }
				array_unshift($args_ref, $types);
                call_user_func_array(array($this->preparedQuery, 'bind_param'), $args_ref);
            }
            $this->preparedQuery->execute();
           	if ($this->preparedQuery->errno) {
				$this->error('Unable to process MySQL query (check your params) - ' . $this->preparedQuery->error);
           	}
			$this->preparedQueryCount++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->DB->error);
        }
		return $this;
    }

    public function FETCH_ALL($callback = null) {
	    $params = array();
        $row = array();
	    $meta = $this->preparedQuery->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array(array($this->preparedQuery, 'bind_result'), $params);
        $result = array();
        while ($this->preparedQuery->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            if ($callback != null && is_callable($callback)) {
                $value = call_user_func($callback, $r);
                if ($value == 'break') break;
            } else {
                $result[] = $r;
            }
        }
        $this->preparedQuery->close();
        $this->query_closed = TRUE;
		return $result;
	}

	public function FETCH_ARRAY() {
	    $params = array();
        $row = array();
	    $meta = $this->preparedQuery->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
		while ($this->preparedQuery->fetch()) {
			foreach ($row as $key => $val) {
				$result[$key] = $val;
			}
		}
        $this->preparedQuery->close();
        $this->query_closed = TRUE;
		return $result;
	}


    public function NUM_ROWS() {
		$this->preparedQuery->store_result();
        //return $this->query->num_rows;
        return $this->preparedQuery->num_rows;
	}

	public function AFFECTED_ROWS() {
		return $this->preparedQuery->affected_rows;
	}

    public function LAST_INSERT_ID() {
    	return $this->DB->insert_id;
    }

    public function error($error) {
        if ($this->show_errors) {
            exit($error);
        }
    }

	private function _gettype($var) {
	    if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';
	}

}