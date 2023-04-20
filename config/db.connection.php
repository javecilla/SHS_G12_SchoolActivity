<?php
	try {

	    //load private credentials from config.ini->then create dbconnection	    
	    $config = parse_ini_file('db.credential.ini'); 
	    $connection = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

	    //check for connection errors
	    if($connection->connect_error) {
    		throw new Exception("Connection failed: " . $connection->connect_error);
  		}

	} catch(Exception $e) {
	    echo "An error occured: " . $e->getMessage();
	}
