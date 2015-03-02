<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/** 
	* PO Division Controller Class.
	* @pupose		Extends Form_Validation library
	*		
	* @filesource	\app\libraries\MY_Form_validation.php	
	* @package		microfin 
	* @version      $Revision: 1 $
	* @author       $Author: Anisur Rahman Alamgir $	
	* @lastmodified $Date: 2011-01-27 $	 
 	*@source  	http://www.scottnelle.com/41/extending-codeigniters-validation-library/ , http://net.tutsplus.com/tutorials/php/6-codeigniter-hacks-for-the-masters/
*/ 
class MY_Form_validation extends CI_Form_validation {

	function __construct()
	{
	    parent::__construct();
	}
/**
 * unique[$table.$tbl_check_field.$PK_tbl_field.$PK_form_field]
 * customize for edit.
*/
	function unique($value, $params) {

		$CI =& get_instance();
		$CI->load->database();

		$CI->form_validation->set_message('unique','The %s is already being used.');

		list($table, $tbl_check_field, $PK_db_field, $PK_form_field) = explode(".", $params, 4);
		
		if ( isset($_POST[$PK_form_field]) and ! empty($_POST[$PK_form_field]) and isset($PK_db_field) and ! empty($PK_db_field))
		{			
			$FK_value = $_POST[$PK_form_field];
			$query = $CI->db->select($tbl_check_field)->from($table)->where(array($tbl_check_field=>$value,$PK_db_field.' !=' => $FK_value) )->limit(1)->get();			
		} else {
			$query = $CI->db->select($tbl_check_field)->from($table)->where($tbl_check_field, $value)->limit(1)->get();
         // print_r($query->row());
          // die;
		}
		return $query->row()?false:true;
	}
	
	/**
 * Check a valid date	
 * is_date
 * @Auth Anis Alamgir
*/
	function is_date($value) {

		$CI =& get_instance();

		$CI->form_validation->set_message('is_date','The %s is not a valid date. Use yyyy-mm-dd.');

		$date_array = explode('-',$value);
		if( !isset($date_array[2]) && empty($date_array[2])) {
			return false;
		}
		return checkdate($date_array[1],$date_array[2],$date_array[0]);
	}
	
	// todo
	// added Anis
	function unique_multi_field($value, $params) {

		$CI =& get_instance();
		$CI->load->database();

		$CI->form_validation->set_message('unique',
			'The %s is already being used.');

		list($table, $field, $field) = explode(".", $params, 2);

		$query = $CI->db->select($field)->from($table)
			->where($field, $value)->limit(1)->get();

		return $query->row()?false:true;


	}
	
	/**
    * @desc Validates a date format
    * @params format,delimiter
    * e.g. d/m/y,/ or y-m-d,-
    */
    function valid_date($str, $params)
    {
        // setup
        $CI =& get_instance();
        $params = explode(',', $params);
        $delimiter = $params[1];
        $date_parts = explode($delimiter, $params[0]);

        // get the index (0, 1 or 2) for each part
        $di = $this->valid_date_part_index($date_parts, 'd');
        $mi = $this->valid_date_part_index($date_parts, 'm');
        $yi = $this->valid_date_part_index($date_parts, 'y');

        // regex setup
        $dre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)";
        $mre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12)";
        $yre = "([0-9]{4})";
        $red = '\\'.$delimiter; // escape delimiter for regex
        $rex = "^[0]{$red}[1]{$red}[2]$";

        // do replacements at correct positions
        $rex = str_replace("[{$di}]", $dre, $rex);
        $rex = str_replace("[{$mi}]", $mre, $rex);
        $rex = str_replace("[{$yi}]", $yre, $rex);

        if (preg_match("/$rex/", $str, $matches)) {
            // skip 0 as it contains full match, check the date is logically valid
            if (checkdate($matches[$mi + 1], $matches[$di + 1], $matches[$yi + 1])) {
                return true;
            } else {
                // match but logically invalid
                $CI->form_validation->set_message('valid_date', "The date is invalid.");
                return false;
            }
        } 

        // no match
        $CI->form_validation->set_message('valid_date', "The date format is invalid. Use {$params[0]}");
        return false;
    }      

    function valid_date_part_index($parts, $search) {
        for ($i = 0; $i <= count($parts); $i++) {
            if ($parts[$i] == $search) {
                return $i;
            }
        }
    }
}	
