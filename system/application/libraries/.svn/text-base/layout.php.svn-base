<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;
    var $app_layout_path = 'layouts/';
    var $content_var = 'content_for_layout';
    private $_ci_view_path_holder = '';

    function Layout($layout = "default")
    {
        $this->obj =& get_instance();
        $this->_ci_view_path_holder = $this->obj->load->_ci_view_path;
        $this->layout = $layout;
    }

    function setLayout($layout)
    {
      $this->layout = $layout;
    }
    
    function view($view, $data=null, $return=false)
    {
        $loadedData = array();
        $loadedData[$this->content_var] = $this->obj->load->view($view,$data,true);
        
        if($return)
        {
            $output = $this->obj->load->view($this->app_layout_path.$this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->app_layout_path.$this->layout, $loadedData, false);
        }
    }
}
