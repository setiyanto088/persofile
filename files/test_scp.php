<?php
 
	
	include '/var/www/file/dh/vendor/autoload.php';

	$config = [
		'host' => 'localhost',
		'port' => '8123',
		'username' => 'inrusert',
		'password' => 'YJx7PUsLxBLS7tBCyujf'
	];
	$db = new ClickHouseDB\Client($config);
	$db->database('inrate');
//	$db->setTimeout(1.5);      // 1500 ms
	$db->setTimeout(30000);       // 10 seconds
	$db->setConnectTimeOut(30000); // 5 seconds
		
	//------------------------------------------------------------------------
	



		$statement = $db->select("SELECT * FROM MASTER_P_CHANNEL ");
			$result = $statement->rows();
			
			PRINT_R($result);DIE;
			

	
	
	


?> 