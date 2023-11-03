<?php  defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('next_result'))
{
	
	function free_result($conn_id)
	{
 
			while (mysqli_more_results($conn_id) && mysqli_next_result($conn_id)){
			if($l_result = mysqli_store_result($conn_id)){
				  mysqli_free_result($l_result);
				}
			}
		 
	}
}
