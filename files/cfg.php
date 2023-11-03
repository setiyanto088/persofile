<?php

$config_db_prod = array(
	
	'hostname' => 'master.u.1elf.net',
	'username' => 'root',
	'password' => 'aJxTF5XsTDSQ',
	'database' => 'prod_unics'
);

$config_db_survey = array(
	
	'hostname' => 'dev-datamart.u.1elf.net',
	'username' => 'inrate_user_2',
	'password' => 'GQa0qu6qyoM7lu3Aw3v1',
	'database' => 'survey'
);

$config_db_maria = array(
	
	'hostname' => 'dev-datamart.u.1elf.net',
	'username' => 'inrate_user_2',
	'password' => 'GQa0qu6qyoM7lu3Aw3v1',
	'database' => 'inrate',
);

$config_db_clickhouse = array(
	
	'hostname' => 'dev-db.u.1elf.net',
	'username' => 'inrate_useR_2',
	'password' => 'GQa0qu6qyoM7lu3Aw3v1',
	'database' => 'inrate'
);

	$main_url_v = 'https://inrate.id/app/';
	$donwload_base_v = 'https://inrate.id/';

    
    $con = mysqli_connect($config_db_prod['hostname'], $config_db_prod['username'], $config_db_prod['password']);
    mysqli_select_db($con, $config_db_prod['database']); 
	
		
	$con_maria = mysqli_connect($config_db_maria['hostname'], $config_db_maria['username'], $config_db_maria['password']);
    mysqli_select_db($con_maria, $config_db_maria['database']);
?>
