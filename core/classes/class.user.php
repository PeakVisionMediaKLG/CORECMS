<?php
namespace CORE;
class USER
{
	public 		$DB;
	
	public 		$AUTH_OK;

	public		$ID; // (primary)	
	protected	$IDENTIFIER; // (u)
	public		$USERNAME; // (u)
	protected	$PASSWORD;
	protected	$SALT;

	public		$ALLOWED_WORKSPACES;
	public		$DISALLOWED_WORKSPACES;
    public      $IS_ACTIVE;
    public      $IS_ADMIN;    

	public		$PREFERRED_LANGUAGE;
	public		$FIRST_NAME;
	public		$LAST_NAME;
	public		$GENDER;
	public		$EMAIL;

    public		$DATE_CREATED;
	
	public 	    $VALUES;
	
	function INITIALIZE()
	{
        $this->VALUES = $this->DB->RETRIEVE(
            "core_users",
            array(),
            array("identifier"=>$_SESSION['CORE.SESSIONIDENTIFIER']),
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

            if($this->ALLOWED_WORKSPACES != "") $this->ALLOWED_WORKSPACES = \json_encode($this->ALLOWED_WORKSPACES); else $this->ALLOWED_WORKSPACES = array();
            if($this->DISALLOWED_WORKSPACES != "") $this->DISALLOWED_WORKSPACES = \json_encode($this->DISALLOWED_WORKSPACES); else $this->DISALLOWED_WORKSPACES = array();
            
            $_SESSION['CORE.USER'] = $sessionValues;
        }
        else
        {
            session_destroy();
            die('User identification failed due to incorrect/missing identifier token. No user data retrieved.');
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
                                    " LIMIT 1"
                                );

                    if($result and count($result)>0)
                    {             
                        foreach($result as $id => $row)
                        {
                            if(password_verify($password, $row['password'])) // check if password matches hash
                            { 
                                
                                
                                if($row['is_active']) // check if user status is active
                                {
                                    $identifier = md5($this->SALT . md5($user . $this->SALT));
                                    $_SESSION['CORE.SESSIONIDENTIFIER'] = $identifier;
                                    //print_r($_SESSION);

                                    $this->DB->UPDATE(
                                        "core_users",
                                        array("identifier"=>$identifier),
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
	
    function CHECK_SESSION_STATE()
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