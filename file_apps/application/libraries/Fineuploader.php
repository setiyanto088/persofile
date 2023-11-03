<?php

class Fineuploader {
    function __construct() {
        $CI = & get_instance();
        log_message('Debug', 'Fineuploader class is loaded.');
    }
    
    function load() {
        include_once APPPATH.'/third_party/fineuploader/handler.php';
        
        return new UploadHandler();
    }
}
