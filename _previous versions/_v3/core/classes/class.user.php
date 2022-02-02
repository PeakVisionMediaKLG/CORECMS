<?php
class USER
{
	public 		$DB;
	
	public 		$AUTH_OK;
    public 		$IS_SYSTEMADMIN;
    public      $IS_ADMIN;
	public		$USER_ROLE;
	
	public		$ID; // (primary)	
	public 		$IDENTIFIER; // (u)
	public		$USERNAME; // (u)
	protected	$PASSWORD;
	public		$PREFERRED_LANGUAGE;
	public		$FIRST_NAME;
	public		$LAST_NAME;
	public		$GENDER;
	public		$EMAIL;
	public 		$AVATAR;
    public		$DATE_CREATED;
	
	public 	    $VALUES;
	
	protected		$SALT;
	
	function INITIALIZE()
	{
        $this->VALUES = $this->DB->RETRIEVE(
            "sys_users",
            array(),
            array("identifier"=>$_SESSION['CORE.SESSIONIDENTIFIER']),
            "LIMIT 1"
        )[0];
        
        if($this->VALUES)
        {
            foreach($this->VALUES as $key => $value)
            {
                $key=strtoupper($key);
                $this->{$key}=$value;
            }
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
                                    'sys_users',
                                    array(),
                                    array('username'=>$user),
                                    " LIMIT 1"
                                );

                    if(count($result)>0)
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
                                        "sys_users",
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

	function PRINT_AVATAR($height=50)
		{
			if($this->GET_VALUE('avatar') !="") $avatar = $this->GET_VALUE('avatar'); 
			else 
			{if($this->GET_VALUE('gender') !="female") $avatar = "img/img_avatar_male.png";}
			echo "<img src='$avatar' class='be-avatar' height='$height'>";
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