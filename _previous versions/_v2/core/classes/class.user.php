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
	public		$USERNAME;
	private		$PASSWORD;
	public		$PREFERRED_LANGUAGE;
	public		$FIRST_NAME;
	public		$LAST_NAME;
	public		$GENDER;
	public		$EMAIL;
	public 		$AVATAR;
    public		$DATE_CREATED;
	
	private 	$VALUES;
	
	private		$SALT;
	
	function INITIALIZE()
	{
		$this->VALUES = $this->DB->EASY_QUERY("SELECT",
											'core_users',
											array('*'),
											array(),
											array('identifier'),
											array($_SESSION['CORE.SESSIONIDENTIFIER'])
											); 
        $this->VALUES = $this->VALUES->fetch_array();
        
		// keys are fetched from key value pair and values are assigned to a variable named UPPERCASE $key
		foreach($this->VALUES as $key => $value)
		{
			$key=strtoupper($key);
			$this->{$key}=$value;	
        }
	}

	
	function VERIFY_LOGIN_DATA($user,$password)        
        {
                if ((isset($user) && isset($password)) and ($user <> "" and $password <> "")) {
                    // if user has sent form with all inputs

                    $user = $this->DB->ESCAPE_STRING($user);
                    $password = $this->DB->ESCAPE_STRING($password);
                    
                    $result=$this->DB->EASY_QUERY('SELECT',
                                                    'core_users',
                                                    array("*"),
                                                    array(),
                                                    array('username'/*,'password'*/),
                                                    array($user/*,password_hash($password,PASSWORD_DEFAULT))*/),
                                                    "LIMIT 1"
                                                    );
                        
                        if (mysqli_num_rows($result) > 0) 
                        { 

                            while($row = $result->fetch_array()){
                                if(password_verify($password, $row['password'])){ // check if password matches hash
                                    // check if user status is active
                                    if($row['is_active']){
                                        //if user is legit
                                        $identifier = md5($this->SALT . md5($user . $this->SALT));
                                        $_SESSION['CORE.SESSIONIDENTIFIER'] = $identifier;
                                        //print_r($_SESSION);

                                        $this->DB->EASY_QUERY("UPDATE", 
                                                                "core_users", 
                                                                array('identifier'), 
                                                                array($identifier), 
                                                                array('username'),
                                                                array($user)
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