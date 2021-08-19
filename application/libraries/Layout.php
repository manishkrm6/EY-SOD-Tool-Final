<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout Class
 */

class Layout {

  private $CI;

  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function render($part, $data = array())
  {
    $data['part_name'] = $part;
    $this->CI->load->view('layout', $data);

  } // End Function

  public function render_password_reset($part, $data = array())
  {
    $data['part_name'] = $part;
    $this->CI->load->view('layout_password_reset', $data);

  } // End Function

  
} 

/* End of file layout.php */
/* Location: ./application/libraries/layout.php */