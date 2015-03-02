<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule
{
	var $CI='';
	
	var $branch_id='';
	
	var $samity_id='';
	
	var $first_repayment_date='';
	
	var $number_of_installment='';
	
	var $repayment_frequency='';
	
	var $samity_day='';
	
		
	var $holidays=array();
	
	function Schedule($loan_id=8,$branch_id=null,$samity_id=null)
	{
		$this->CI =& get_instance();
		
		$this->CI->load->model('Config_holiday','',TRUE);
		$this->CI->load->model('Loan','',TRUE);
		$this->CI->load->model('Member','',TRUE);
		$this->CI->load->model('Samity','',TRUE);
		
		$loan=$this->CI->Loan->read($loan_id);
		$loan=(array)$loan[0];
		
		$member=$this->CI->Member->read($loan['member_id']);
		$member=(array)$member[0];
		
		$samity=$this->CI->Samity->read($member['samity_id']);
		$samity=(array)$samity[0];
	
		$this->branch_id=$member['branch_id'];
		$this->samity_id=$member['samity_id'];
		$this->first_repayment_date=$loan['first_repayment_date'];
		$this->no_of_installment=$loan['number_of_installment'];
		$this->repayment_frequency=$loan['repayment_frequency'];
		$this->samity_day=$samity['samity_day'];
		$this->holidays=$this->CI->Config_holiday->get_holidays_by_branch_samity($this->branch_id,$this->samity_id);
		
		foreach($this->holidays as $key=>$val){
			$this->holidays[$key]=$this->holidays[$key]['holiday_date'];
		}
	}
	function get_schedule($rescheule_date_list=array() /*array(array('start'=>'2011-01-01','end'=>'2012-02-08'))*/)
	{
		//echo "Holidays list\n";
		//print_r($holidays);
		
		
		$count=0;
		$schedule=array();
		$schedule_date=$this->first_repayment_date;	
		$week_days=array('SUN'=>'Sunday','MON'=>'Monday','TUE'=>'Tuesday','WED'=>'Wednesday','THU'=>'Thursday','FRI'=>'Friday','SAT'=>'Saturday');
		$repayment_freq=array('WEEKLY'=>'week','MONTHLY'=>'month','YEARLY'=>'year');
		
		//print_r($week_days);
		//print_r($repayment_freq);
		//print_r($this->holidays);
		//die;
		while($count < $this->no_of_installment)
		{			
			foreach($rescheule_date_list as $rescheule_date){
				
				$reschedule_start=strtotime($rescheule_date['start']);
				$reschedule_end=strtotime($rescheule_date['end']);
				
				if(strtotime($schedule_date)>=$reschedule_start && strtotime($schedule_date)<=$reschedule_end){
					$schedule_date=strtotime("+1 day", $reschedule_end);
					$schedule_date=date("Y-m-d", $reschedule_end);
					break;
				}
			}
			//$schedule_date=$this->loan['first_repayment_date'];
			$year=substr($schedule_date,0,strpos($schedule_date,'-'));
			$month=substr($schedule_date,strpos($schedule_date,'-')+1,strrpos($schedule_date,'-')-strpos($schedule_date,'-')-1);
			$day=substr($schedule_date,strrpos($schedule_date,'-')+1);
			
			$next_date=date("D", mktime(0, 0, 0, $month, $day, $year));
			
			if(strcasecmp($next_date,$this->samity_day)!=0){
				
				$schedule_date=strtotime("next ".$week_days[$this->samity_day], strtotime($schedule_date));
				$schedule_date=date("Y-m-d", $schedule_date);
			}
			
			
			
			if(!in_array($schedule_date,$this->holidays))
			{
				$count++;
				//$schedule[$schedule_date]=$schedule_date;
				$tmp_schedule_date=date("Y-m-d", strtotime($schedule_date));
				array_push($schedule,$tmp_schedule_date);					
			}
			//Add 6 days to the $schedule_date;
			$next_schedule_date = strtotime("next ".$repayment_freq[$this->repayment_frequency], strtotime($schedule_date));	
			$next_schedule_date=date("Y-m-d", $next_schedule_date);
			
			
			//Check if holiday; If holiday then add 6 days more..
			//If not a holiday, add that day to the schedule and increase the counter
			$schedule_date=$next_schedule_date;	
			//array_push($schedule,$schedule_date);			
			//$schedule[]=
		}	
		//echo "schedule list\n";
		
		return $schedule;		
	}
	
	function get_schedule_details($rescheule_date_list=array(array('start'=>'2011-01-01','end'=>'2012-02-08')))
	{
		//echo "Holidays list\n";
		//print_r($holidays);
		
		
		$count=0;
		$schedule=array();
		$schedule_date=$this->first_repayment_date;	
		$week_days=array('SUN'=>'Sunday','MON'=>'Monday','TUE'=>'Tuesday','WED'=>'Wednesday','THU'=>'Thursday','FRI'=>'Friday','SAT'=>'Saturday');
		$repayment_freq=array('WEEKLY'=>'week','MONTHLY'=>'month','YEARLY'=>'year');
		
		//print_r($week_days);
		//print_r($repayment_freq);
		//print_r($this->holidays);
		//die;
		while($count < $this->no_of_installment)
		{			
			
			//$schedule_date=$this->loan['first_repayment_date'];
			$year=substr($schedule_date,0,strpos($schedule_date,'-'));
			$month=substr($schedule_date,strpos($schedule_date,'-')+1,strrpos($schedule_date,'-')-strpos($schedule_date,'-')-1);
			$day=substr($schedule_date,strrpos($schedule_date,'-')+1);
			
			$next_date=date("D", mktime(0, 0, 0, $month, $day, $year));
			
			if(strcasecmp($next_date,$this->samity_day)!=0){
				
				$schedule_date=strtotime("next ".$week_days[$this->samity_day], strtotime($schedule_date));
				$schedule_date=date("Y-m-d", $schedule_date);
			}
			
			foreach($rescheule_date_list as $rescheule_date){
				
				$reschedule_start=strtotime($rescheule_date['start']);
				$reschedule_end=strtotime($rescheule_date['end']);
				
				while(strtotime($schedule_date)>=$reschedule_start && strtotime($schedule_date)<=$reschedule_end){
					$tmp_schedule_date=date("Y-m-d-D", strtotime($schedule_date));
					array_push($schedule,array('rescheduled'=>$tmp_schedule_date));
					$schedule_date=strtotime("next ".$week_days[$this->samity_day], strtotime($schedule_date));
					$schedule_date=date("Y-m-d", $schedule_date);
				}
			}
			
			
			
			if(!in_array($schedule_date,$this->holidays))
			{
				$count++;
				//$schedule[$schedule_date]=$schedule_date;
				$tmp_schedule_date=date("Y-m-d-D", strtotime($schedule_date));
				array_push($schedule,array('scheduled'=>$tmp_schedule_date));					
			}
			else{
				$tmp_schedule_date=date("Y-m-d-D", strtotime($schedule_date));
				array_push($schedule,array('holiday'=>$tmp_schedule_date));
			}
			//Add 6 days to the $schedule_date;
			$next_schedule_date = strtotime("next ".$repayment_freq[$this->repayment_frequency], strtotime($schedule_date));	
			$next_schedule_date=date("Y-m-d", $next_schedule_date);
			
			
			//Check if holiday; If holiday then add 6 days more..
			//If not a holiday, add that day to the schedule and increase the counter
			$schedule_date=$next_schedule_date;	
			//array_push($schedule,$schedule_date);			
			//$schedule[]=
		}	
		//echo "schedule list\n";
		
		return $schedule;		
	}
}
?>

