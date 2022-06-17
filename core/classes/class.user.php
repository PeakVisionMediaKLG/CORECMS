<?php

namespace CORE;
class USER
{
	public 		$DB;
	
	public 		$AUTH_OK;

	public		$ID; // (primary)	
	protected	$UNIQUE_ID; // (u)
	public		$USERNAME; // (u)
	protected	$PASSWORD;
	protected	$SALT;

	public		$ALLOWED_EXTENSIONS;
	public		$DISALLOWED_EXTENSIONS;
    public      $IS_ACTIVE;
    public      $IS_ADMIN;    

	public		$PREFERRED_LANGUAGE;
	public		$FIRST_NAME;
	public		$LAST_NAME;
	public		$GENDER;
	public		$EMAIL;

    public      $CREATED_BY;
    public		$CREATED_DATE;
	
	public 	    $VALUES;
	
	function INITIALIZE()
	{
        $this->VALUES = $this->DB->RETRIEVE(
            "core_users",
            array(),
            array("unique_id"=>$_SESSION['CORE.SESSIONIDENTIFIER']),
            "LIMIT 1"
        )[0];
        
        if($this->VALUES)
        {
            $sessionValues=array();

            foreach($this->VALUES as $key => $value)
            {
                $key=strtoupper($key);
                $this->{$key}=$value;
                if($key != "PASSWORD") $sessionValues[$key] = $value;
            }

            if($this->ALLOWED_EXTENSIONS != "") $this->ALLOWED_EXTENSIONS = \json_encode($this->ALLOWED_EXTENSIONS); else $this->ALLOWED_EXTENSIONS = array();
            if($this->DISALLOWED_EXTENSIONS != "") $this->DISALLOWED_EXTENSIONS = \json_encode($this->DISALLOWED_EXTENSIONS); else $this->DISALLOWED_EXTENSIONS = array();
            
            $_SESSION['CORE.USER'] = $sessionValues;
        }
        else
        {
            session_destroy();
            die('User identification failed due to incorrect/missing unique_id token. No user data retrieved.');
        } 
	}

	
	function VERIFY_LOGIN_DATA($user,$password)        
        {
                if ((isset($user) && isset($password)) and ($user <> "" and $password <> "")) 
                {
                    $result =   $this->DB->RETRIEVE(
                                    'core_users',
                                    array(),
                                    array('username'=>$user),
                                    "LIMIT 1"
                                );

                    if($result and count($result)>0)
                    {             
                        foreach($result as $id => $row)
                        {
                            if(password_verify($password, $row['password'])) // check if password matches hash
                            { 
                                
                                if($row['is_active']) // check if user status is active
                                {
                                    $unique_id = md5($this->SALT . md5($user . $this->SALT));
                                    $_SESSION['CORE.SESSIONIDENTIFIER'] = $unique_id;
                                    //print_r($_SESSION);

                                    $this->DB->UPDATE(
                                        "core_users",
                                        array("unique_id"=>$unique_id),
                                        array("username"=>$user)
                                    );

                                    $this->AUTH_OK=1;
                                    $this->INITIALIZE();

                                    if($this->DB->dbAutoDumpOnLogin) $this->DB->DB_DUMP();

                                    return 1;
                                }
                            }
                            else $this->ERROR_RESPONSE=1;
                        }
                        
                    }
                    else //no user found for input data
                    { 
                        $this->AUTH_OK=0; $this->ERROR_RESPONSE=1;
                    }

                }
                else //not all inputs provided
                {
                    $this->AUTH_OK=0; $this->ERROR_RESPONSE=2;
                }
        }
	

    function AUTHENTICATE()
        {
            if (isset($_SESSION['CORE.SESSIONIDENTIFIER'])){

                $this->THE_USER = $_SESSION['CORE.SESSIONIDENTIFIER'];
                $this->AUTH_OK = 1;	

                $this->INITIALIZE();

                //if (!isset($_SESSION['interface']["show_toolbar"])) $_SESSION['interface']["show_toolbar"]=1;
                return 1;
            }
            else 
            {	
                if(!@isset($_POST['signin']))
                {
                    $this->SIGN_OUT();
                }
                $this->AUTH_OK=0;
                return 0;
            }
        }


	function GET_AVATAR()
		{
            switch($this->GENDER)
            {
                case "female":
                    $avatar = "img/img_avatar_female.png";    
                break;
                case "male":
                    $avatar = "img/img_avatar_male.png";
                break;
                case "diverse":
                default:
                    $avatar = "img/img_avatar_diverse.png";
                break;
            }
			return $avatar;
		}
	

	function SIGN_OUT()
        {
            session_unset();
            @session_destroy();

            $this->AUTH_OK=0;
        }
    

    function DENIED()
        {
            die('Access denied.');
        }	
}
?>