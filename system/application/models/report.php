<?php
/** 
	*  REPORT Model Class.
	* @pupose		REPORT information
	*		
	* @filesource	./system/application/models/report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.report
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Report extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    } 
    //Year Generation
	function get_year_range()
	{
			$year_info[''] = '--Select--';
			$current_year = date('Y');
			for ($i = 1993; $i <= $current_year; $i++)
			{
					$year_info[$i] = $i;
			}
		return $year_info;
	}  
	//Month Generation
	function get_months()
	{
		$months = array('' => '--Select--', '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');		
		return $months;
	}
	//Samity Day Generation
	function get_samity_days()
	{
		$samity_days = array('Sat'=>'Satuday','Sun'=>'Sunday','Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday');
		return $samity_days;
	}
	//Projects
	function get_projects()
	{		
		$this->db->select('id AS project_id, name AS project_name');		
		$this->db->order_by('project_name','ASC');		
		$query = $this->db->get('projects');  
		return $query->result();	
	}
	// Calculate first date of a month
	function get_first_date_of_month($year,$month)
	{
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));		
		return 	$current_month_first;
	}
	// Calculate last date of a month
	function get_last_date_of_month($year,$month)
	{
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));
		return 	$current_month_last;
	}
	// Calculate previous month
	function get_previous_month($year,$month)
	{
		$previous_month=date("Y-m-d", strtotime("-1 month", strtotime($year.'-'.$month.'-'.'1')));	
		return 	$current_month_last;
	}	
	
	//Calculate the last date of a month
	function calculate_last_date($year,$month)
	 {
	  //$n=(int)($year/4);
	  //$m=$year-$n*4;
	  if($month=='04'|| $month=='06'||$month=='09'||$month=='11')
		{
		  $last_date=30;
		}
	  elseif($month=='02')
		{
		 if($year%4==0)
		   $last_date=29;
		 else
		   $last_date=28; 			 
		} 
	  else
		  $last_date=31;
		  
	  return $last_date;			  
	 }
	 
	 
	
/**
 * @return regular working day list (without holiday calculation)
 */
	function get_monthly_regular_working_day_list($year,$month,$day_name,$only_first_day = false){
		//echo "$year $month $day_name";
		$samity_day_of_the_month = array();
		if($month=='04'|| $month=='06'||$month=='09'||$month=='11')
		{
		  $last_date=30;
		}
	  	elseif($month=='02')
		{
		 	if($year%4==0)
		   		$last_date=29;
		 	else
		   		$last_date=28; 			 
		} 
	  	else
		{	
			$last_date=31;
		}
		for($day = 1; $day <=$last_date; $day++)
		{
		    $timestamp = mktime(1,1,1,$month,$day,$year);
		    if(date('D', $timestamp) == ucfirst(strtolower($day_name)))
		    {
		      $samity_day_of_the_month[] = date('Y-m-d', $timestamp);
		      
		      if($only_first_day) break;
		    }
		}
		//   print_r($samity_day_of_the_month);
		return $samity_day_of_the_month;  
	} 
	/**
 * @return samity day name like: Saturday 
 */
	function get_samity_day($year,$month,$day_name){
		$samity_day_of_the_month = "";
		  for($day = 1; $day <=31; $day++)
		  {
		    $timestamp = mktime(1,1,1,$month,$day,$year);
		    if(date('D', $timestamp) == ucfirst(strtolower($day_name)))
		    {
		      $samity_day_of_the_month = date('F', $timestamp);
		      break;
		    }
		}
		 //   print_r($samity_day_of_the_month);
		return $samity_day_of_the_month;  
	}
	//Samity Day Generation
	function get_samity_day_info($samity_day)
	{
		$samity_days = array('Sat'=>'Satuday','Sun'=>'Sunday','Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday');
        $samity_day = ucfirst(strtolower($samity_day));
		if (array_key_exists($samity_day, $samity_days))
		{
			return $samity_day=$samity_days[$samity_day];
		}		
	} 
	//Active member name and code Generation
	function get_active_member_name_code($member_list)
	{
		$query=$this->db->query("SELECT id,name as member_name,code as member_code FROM members WHERE id IN($member_list)");			
		return $query->result();			
	} 
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	function get_cancel_member_list_by_samity_id_csv($date,$samity_id,$primary_product_id=null) { 		
 		$primary_product_cond = ( !empty($primary_product_id) && is_numeric($primary_product_id) ) ? " AND member_primary_product_id = $primary_product_id ":"";
 		if( isset($samity_id) && is_numeric($samity_id) ) {
			$cancel_members = $this->db->query("SELECT member_id FROM member_closing WHERE samity_id = $samity_id 
					AND closing_date<'$date' $primary_product_cond;");			
			$cancel_members = $cancel_members->result();			
			$cancel_member_list=array();
			foreach($cancel_members as $cancel_member){
				$cancel_member_list[] = $cancel_member->member_id;
			}			
			$cancel_member_list = join(',',$cancel_member_list);			
			return $cancel_member_list;
		}
		return false;
	}
	function get_first_last_date_of_a_month($year=null,$month=null){		
	  	if($month=='04'|| $month=='06'||$month=='09'||$month=='11')
		{
			$last_date=30;
		}
	  	elseif($month=='02')
		{
		 	if($year%4==0)
		   		$last_date=29;
		 	else
		   		$last_date=28; 			 
		} 
	  	else
		{	
			$last_date=31;
		}
		$data['first_date']=$year.'-'.$month.'-1';
		$data['last_date']=$year.'-'.$month.'-'.$last_date;	
		return $data;
	}
	function get_month_working_day_list($holiday_list,$year,$month){
		$day_of_the_month = array();
		if($month=='04'|| $month=='06'||$month=='09'||$month=='11')
		{
		  	$last_date=30;
		}
	  	elseif($month=='02')
		{
		 	if($year%4==0)
		   		$last_date=29;
		 	else
		   		$last_date=28; 			 
		} 
	  	else
		{	
			$last_date=31;
		}
		for($day = 1; $day <=$last_date; $day++)
		{
			$timestamp = mktime(1,1,1,$month,$day,$year);		   
		    	$day_of_the_month[] = date('Y-m-d', $timestamp);	      	
		   
		}
		//print_r($holiday_list);
		$week_of_the_month=array();
		$i=0;$j=0;
		foreach($day_of_the_month as $row){			
			$i++;
			if($i==1){				
				if(array_key_exists($row,$holiday_list)){						
					$i=0;
				}
				else{
					$week_start=$row;	
				}			
			}
			else
			{				
				if(array_key_exists($row,$holiday_list)){					
					$week_of_the_month[]=$week_start.' to '.$week_end;
					$week_start="";					
					$week_end="";
					$i=0;
				}
												
			}
			$week_end=$row;									
		}	
		if(!empty($week_end) && !empty($week_start)){		
			$week_of_the_month[]=$week_start.' to '.$week_end;
		}
		//print('<br>');		
		//print_r($week_of_the_month);die;		
		return $week_of_the_month;  
	} 
}
