<?php
namespace CORE;
class DB
{
    
protected $CONNECTION;

protected $dbHost;
protected $dbName;
protected $dbUser;
protected $dbPassword;

public $dbTablePrefix;
public $dbCharset;
public $dbCollation;

protected $dbSessionSalt;
protected $dbEncryptionKey;
protected $dbEncryptionSalt;

protected $dbGeneralLog;
protected $dbInternalLog;
protected $dbStrictMode;
protected $dbShowErrors;
protected $dbShowMessages;

public $currentStatement;
public $currentStatementVars;
public $statementID;
public $currentResult;

public $dbAutoDumpOnLogin;


    public function __construct()
    {
        require_once(ROOT."config/config.core.php");
        foreach ($CONFIG as $argumentKey => $value)
        {
            $this->{$argumentKey} = $value;
        }

        $this->CONNECTION = new \mysqli($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
        if ($this->CONNECTION->connect_error) {
			$this->ERROR('Failed to connect to MySQL - ' . $this->CONNECTION->connect_error);
		}

        $this->CONNECTION->set_charset($this->dbCharset);
        if($this->dbTablePrefix=="_") $this->dbTablePrefix="";

        if($this->dbGeneralLog) $this->EXEC("SET GLOBAL general_log = 'ON'");
        if($this->dbStrictMode) mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        //var_dump($this);

        $this->statementID = 0;
    }   

    public function EXEC($query)
    {
        $queryResult = $this->GET_OBJECT($query);
        return $queryResult;
    }

    public function MULTI_EXEC($query)
    {
        $queryResult = $this->CONNECTION->multi_query($query);
        if($this->CONNECTION->errno) die($this->CONNECTION->error);
        return $queryResult;
    }    

    public function EXEC_TBL($preTable,$table,$postTable)
    {
        $transaction = $this->GET_OBJECT($preTable.$this->dbTablePrefix.$table.$postTable);
        return $transaction;
    }

    public function DELETE($table,$conditions,$extended=null)
    {
        $params=array();
        
        $query="DELETE FROM ".$this->dbTablePrefix.$table;

        if(is_array($conditions) and count($conditions)>0)
        {   
            $query.=" WHERE ";
            foreach($conditions as $key => $value)
                {
                    $query .= $key."=? AND";
                    array_push($params,$value);
                }
            $query = substr($query,0,-4);
        }

        if(isset($params))
        {
            $transaction=$this->GET_OBJECT($query,...$params);
            //var_dump($this->currentResult[$transaction]);
            if($this->currentStatementVars[$transaction]['affected_rows']>0)
            {
                return $this->MAP_RESULT($transaction);
            }
            else $this->MESSAGE("No data sets were deleted: ".$query);
        } 
        else $this->MESSAGE("No parameters set for: ".$query);    
    }

    public function INSERT($table,$columns,$extended=null)
    {
        $params=array();
        
        $queryColumns = "";
        if(is_array($columns) and count($columns)>0)
        {
            $queryColumns = "";
            $queryColumnValueString="";
            foreach($columns as $key => $value)
            {
                $queryColumns .= $key.",";
                $queryColumnValueString .= "?,";
                array_push($params,$value);
            }
            $queryColumns = substr($queryColumns,0,-1);
            $queryColumnValueString = substr($queryColumnValueString,0,-1);
        }
        else $queryColumns = "";

        $query="INSERT INTO ".$this->dbTablePrefix.$table." (".$queryColumns.") VALUES (".$queryColumnValueString.")";

        if(isset($params))
        {
            $transaction=$this->GET_OBJECT($query,...$params);
            //var_dump($this->currentResult[$transaction]);
            if($this->currentStatementVars[$transaction]['affected_rows']>0)
            {
                return $this->MAP_RESULT($transaction);
            }
            else $this->MESSAGE("No data sets were inserted: ".$query);
        } 
        else $this->ERROR("No parameters set for: ".$query);
    }

    public function UPDATE($table,$columns,$conditions,$extended=null)
    {
        $params=array();

        $queryColumns = "";
        if(is_array($columns) and count($columns)>0)
        {
            $queryColumns = "";
            foreach($columns as $key => $value)
            {
                $queryColumns .=  $key."=?, ";
                array_push($params,$value);   
            }
            $queryColumns = substr($queryColumns,0,-2);
        }
        else $queryColumns = "";

        $queryConditions = " ";
        if(is_array($conditions) and count($conditions)>0)
        {
            $conditionParams=array();
            foreach($conditions as $key => $value)
            {
                $queryConditions .=  $key."=? AND ";
                array_push($params,$value);
            }
            $queryConditions = " WHERE ".substr($queryConditions,0,-4);
        }       

        $query="UPDATE ".$this->dbTablePrefix.$table." SET ".$queryColumns.$queryConditions.$extended;

        if(isset($params))
        {
            $transaction=$this->GET_OBJECT($query,...$params);
            //var_dump($this->currentResult[$transaction]);
            if($this->currentStatementVars[$transaction]['affected_rows']>0)
            {
                return $this->MAP_RESULT($transaction);
            }
            else $this->MESSAGE("No data sets were altered: ".$query);
        } 
        else $this->ERROR("No parameters set for: ".$query);

    }

    public function RETRIEVE($table,$columns,$conditions,$extended=null)
    {
        $queryColumns = "";
        if(is_array($columns) and count($columns)>0)
        {
            foreach($columns as $key => $value)
            {
                $queryColumns .=  $value.", ";   
            }
            $queryColumns = substr($queryColumns,0,-2);
        }
        else $queryColumns = "*";

        $queryConditions = " ";
        if(is_array($conditions) and count($conditions)>0)
        {
            $conditionParams=array();
            foreach($conditions as $key => $value)
            {
                $queryConditions .=  $key."=? AND ";
                array_push($conditionParams,$value);
            }
            $queryConditions = " WHERE ".substr($queryConditions,0,-4);
        }       


        $query="SELECT ".$queryColumns." FROM ".$this->dbTablePrefix.$table.$queryConditions.$extended;

        if(isset($conditionParams))
        {
            $transaction=$this->GET_OBJECT($query,...$conditionParams);
            //var_dump($this->currentResult[$transaction]);
            return $this->MAP_RESULT($transaction);
        } 
        else
        {
            $transaction=$this->GET_OBJECT($query);
            //var_dump($this->currentResult[$transaction]);
            return $this->MAP_RESULT($transaction);
        }

    }

    public function MAP_RESULT($statementID)
    {
        $result = array();
        $errorMessage="";
        if(isset($this->currentResult[$statementID]->num_rows))
        {
            if ($this->currentResult[$statementID]->num_rows > 0)
            {   $i=0;
                while ($row = $this->currentResult[$statementID]->fetch_array(MYSQLI_ASSOC)) {
                    foreach ($row as $key => $val) {
                        $result[$i][$key] = $val;
                    }
                    $i++;
                }
                $this->currentStatement[$statementID]->close();
                return $result;
            }
            else $errorMessage="No result found for: ".$this->currentStatementVars[$statementID]['query'];
        }
        if(isset($this->currentStatement[$statementID]->affected_rows))
        {
            if ($this->currentStatement[$statementID]->affected_rows == 0)  
            {
                $errorMessage="No result rows affected for: ".$this->currentStatementVars[$statementID]['query'];
            }    
        }
        $this->MESSAGE($errorMessage);
        $this->currentStatement[$statementID]->close();   
    }

    public function GET_OBJECT($query) //$preTable,$table,$postTable
    {
        $this->statementID++;
        $this->MESSAGE("<br>\n  <br>\n".$query."<br>\n  <br>\n");

        $this->currentStatement[$this->statementID] = $this->CONNECTION->prepare($query);

        if(func_num_args() > 1)
        {
            $arguments = array_slice(func_get_args(), 1);
				$argumentTypes = '';
                $argumentReferences = array();
                foreach ($arguments as $argumentKey => &$arg) {
					if (is_array($arguments[$argumentKey])) {
						foreach ($arguments[$argumentKey] as $j => &$a) {
							$argumentTypes .= $this->GET_TYPE($arguments[$argumentKey][$j]);
							$argumentReferences[] = &$a;
						}
					} else {
	                	$argumentTypes .= $this->GET_TYPE($arguments[$argumentKey]);
	                    $argumentReferences[] = &$arg;
					}
                }
            if ($this->dbShowMessages) {print_r($arguments);}   
            array_unshift($argumentReferences, $argumentTypes);
            call_user_func_array(array($this->currentStatement[$this->statementID], 'bind_param'), $argumentReferences);
        }
        elseif(func_num_args() < 1 and $this->dbShowMessages) 
        {
            $this->MESSAGE("DB: no arguments submitted - ".$query);
        }

        $this->currentStatement[$this->statementID]->execute();
        if ($this->currentStatement[$this->statementID]->errno) 
        {
            $this->ERROR('DB: Unable to process MySQL query (check your params) - ' . $this->currentStatement[$this->statementID]->error);
        }

        $this->currentStatementVars[$this->statementID]['query'] = $query;
        $this->currentStatementVars[$this->statementID]['num_rows'] = $this->currentStatement[$this->statementID]->num_rows ?? null;
        $this->currentStatementVars[$this->statementID]['affected_rows'] = $this->currentStatement[$this->statementID]->affected_rows ?? null;
        $this->currentStatementVars[$this->statementID]['field_count'] = $this->currentStatement[$this->statementID]->field_count ?? null;
        $this->currentStatementVars[$this->statementID]['param_count'] = $this->currentStatement[$this->statementID]->param_count ?? null;
        $this->currentStatementVars[$this->statementID]['errno'] = $this->currentStatement[$this->statementID]->errno ?? null;
        $this->currentStatementVars[$this->statementID]['error'] = $this->currentStatement[$this->statementID]->error ?? null;
        $this->currentStatementVars[$this->statementID]['error_list'] = $this->currentStatement[$this->statementID]->error_list ?? null;

        $this->currentStatementVars[$this->statementID]['sqlstate'] = $this->currentStatement[$this->statementID]->sqlstate ?? null;

        $this->currentResult[$this->statementID] = $this->currentStatement[$this->statementID]->get_result(); 

        $this->currentStatementNumRows[$this->statementID] = $this->currentStatement[$this->statementID]->num_rows ?? null;
        $this->currentStatementAffectedRows[$this->statementID] = $this->currentStatement[$this->statementID]->affected_rows ?? null;

        //$this->currentStatement[$this->statementID]->free_result();
        //$this->currentStatement[$this->statementID]->close();

        return $this->statementID;
    }

    public function MESSAGE($message) {
        if ($this->dbShowMessages) {
            echo $message;
        }
    }

    public function ERROR($error) {
        if ($this->dbShowErrors) {
            exit($error);
        }
    }

    protected function GET_TYPE($var)
    {
	    if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';        
    } 
}
?>
