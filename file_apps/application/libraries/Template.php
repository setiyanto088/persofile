<?php  if (!defined('BASEPATH')){ exit('No direct script access allowed'); }

    class Template {

        function load($template = '', $view = '' , $vars = array(), $return = FALSE)
        {
            $vars['template_contents'] = APPPATH . '/modules/' . $view;
            $this->CI =& get_instance();
            return $this->CI->load->view($template, $vars, $return);
        }
        
    }
    class Template2 {

        function load($template = '', $view = '' , $vars = array(), $return = FALSE)
        {
            $vars['template_contents2'] = APPPATH . '/modules/' . $view;
            $this->CI =& get_instance();
            return $this->CI->load->view($template, $vars, $return);
        }
        
    }

?>
