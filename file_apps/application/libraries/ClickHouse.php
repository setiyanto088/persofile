<?php 
    defined('BASEPATH') or exit('No direct script access allowed');

    class ClickHouse {
        protected $connection;

        public function __construct(){
            $config = [
                'host' => 'dev-db.u.1elf.net',
                'port' => '8123',
                'username' => 'usertprt',
                'password' => 'CLl1EBW69ZFygJwtQGuL'
            ];
            
            $db = new ClickHouseDB\Client($config);
            $db->database('inrate');
            $db->setTimeout(1.5);      // 1500 ms
            $db->setTimeout(1000);       // 10 seconds
            $db->setConnectTimeOut(500); // 5 seconds
            $this->connection = $db;
        }

        public function db(){
            $result = $this->connection;
            return $result;
        }
    }