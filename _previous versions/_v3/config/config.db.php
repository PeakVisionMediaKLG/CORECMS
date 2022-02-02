<?php
	$CONFIG_DB = array(

		"dbHost"          		=>  "localhost",			// mysql host
		"dbName"              	=>  "newcore",				// mysql database
		"dbUser"            	=>  "root",					// mysql user
		"dbPassword"        	=>  "",						// mysql password

		"dbTablePrefix"			=>	"",						// mysql database table prefix, in case your db contains other projects as well 
		"dbCharset"				=>	"utf8mb4",				// mysql database standard character set, default: utf8mb4
		"dbCollation"			=>	"utf8mb4_general_ci",	// mysql database collation for all tables, default: utf8mb4
		"dbStrictMode"			=>	1,						// mysql database, operate in strict mode, default: 1
		"dbGeneralLog"			=>	1,						// mysql database, log everything to the mysql log file, default: 1		

		"dbSessionSalt"			=> 	"core-salt",			// Add-in for md5 encrypted user authentication variables, back-up in safe place		
		"dbEncryptionKey"    	=>  "core-key",				// Encryption key for two-way MySQL dump encryption, back-up in safe place		
		"dbEncryptionSalt"   	=>  "1234567891011121",		// Encryption SALT for two-way MySQL dump encryption, back-up in safe place	
		
		"coreProtocol"			=>	"http://",				// the connection protocol: http or https	
		"coreDomain"			=>	"localhost/",			// the domain name, example: www.google.com

		"dbInternalLog"			=>	0, 		// log all database actions to log file, default: 0    // !!! To be implemented !!!
		"dbShowErrors"			=>	1, 		// print database errors to the DOM, default: 1
		"dbShowMessages"		=>	0,   	// print database warnings and messages to the DOM, default: 0
		"dbAutoDumpOnLogin"		=>	0, 		// make a dump of the entire database on login
		
		"jQueryDebugToConsole"	=>	1,		// log javascript errors in the browser console, default: 1
		"jQueryDebugToDocument"	=>	0,		// print javascript errors to the DOM, default: 0

	);
?>