<?php
/** 
	* Loan Model Class. 
	* @pupose		Manage Loan schedule
	* 
	* @filesource	\app\model\loan_scheduler.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-02-02 $	 
*/
    
class Loan_schedule extends MY_Model {

	private $branch_id=null;
	private $samity_id=null;
	private $loan_list=array();
	private $branch_holiday_list=array();
	private $samity_holiday_list=array();
	private $samity_list=array();
	private $samity_day_change_list=array();
	private $date_from=null;
	private $date_to=null;
	private $debug = false;
	
    function __construct()
    {
        parent::__construct();
    }
 
    function initialize($branch_id,$samity_id=null)
    {
		$this->branch_id=$branch_id;
		$this->samity_id=$samity_id;
		$this->_load_holiday_list();
		$this->_load_samity_day_list();
		$this->_load_samity_day_change();
		return true;
	}
	
	function get_loan_schedule($loan_id)
	{
		$this->db->from('loan_schedules');
		$this->db->where(array('loan_id' => $loan_id));
		$this->db->order_by("schedule_date", "asc");
		$query = $this->db->get(); 
        return $query->result();   
	}

	function generate_loan_schedule(&$loan)
	{
		$schedules=array();
        
		$schedule_date=$this->get_valid_schedule_date($loan['first_repayment_date'],$loan['samity_id']);

        $last_repayment_date=$schedule_date;
		$installment_amount=0;
		$total_payable=0;
		$schedule_amounts=$this->_get_repayment_installment_amount($loan);
		$schedule_dates[]=$schedule_date;
		$count=2;
		$total_amount=0;
		while($count <= $loan['number_of_installment'])
		{
				$schedule_date=$this->get_next_schedule_date($schedule_date,$loan['samity_id'],$loan['repayment_frequency']);
				$last_repayment_date=$schedule_date;
				$schedule_dates[]=$schedule_date;
				$count+=1;		
		}
		return array('schedule_dates'=>$schedule_dates,'schedule_amounts'=>$schedule_amounts);
	}	
	
	function get_next_schedule_date($date,$samity_id,$repayment_frequency)
	{
		$samity_day=$this->get_samity_day($samity_id,$date);
		$date=strtotime($date);
		switch ($repayment_frequency) {
			case 'DAILY':
				$date=strtotime($date.' + 1 day');
				break;
			case 'WEEKLY':
				$date=strtotime('next '.$samity_day,$date);
				break;
			case 'MONTHLY':
				$date=strtotime($date.' + 1 month');
				break;
			case 'YEARLY':
				$date=strtotime($date.' + 1 year');
				break;
		}
		
		$date=$this->get_valid_schedule_date(date('Y-m-d',$date),$samity_id);
		return $date;
	}
	
	function get_valid_schedule_date($date,$samity_id)
	{
		if(isset($this->branch_holiday_list[$date]) || isset($this->samity_holiday_list[$samity_id][$date]))
		{
			if ($this->debug) echo "[$date] holiday, Trying next<br/>";
			$date=date('Y-m-d',strtotime("next $samity_day",strtotime($date)));
			$date=$this->get_valid_schedule_date($date,$samity_id);
		}
	
		$samity_day=$this->get_samity_day($samity_id,$date);
        
		if(strtoupper(date('D',strtotime($date)))!=strtoupper($samity_day))
		{
		
        	if ($this->debug) echo "[$date] Not samity day(Expected: $samity_day , but found: ".strtoupper(date('D',strtotime($date)))."), Trying next<br/>";
			$date=date('Y-m-d',strtotime("next $samity_day",strtotime($date)));
           // echo $date." $samity_id<br>";die;
			$date=$this->get_valid_schedule_date($date,$samity_id);
            //echo $date." $samity_id<br>";die;
            
		}
		return $date;
	}
	
	function get_samity_day($samity_id,$date)
	{
		$samity=$this->samity_list[$samity_id];
		return $samity->samity_day;
	}
	
	private function _get_repayment_installment_amount(&$loan)
	{
		$amounts=array();
		$principal_amount=$loan['loan_amount'];
		$interest_rate=$loan['interest_rate'];
		$loan_period_in_month=$loan['loan_period_in_month'];
		$number_of_installment=$loan['number_of_installment'];
		if($loan['interest_calculation_method']=='FLAT')
		{
			if($loan['mode_of_interest']=='YEARLY_PER_HUNDRED')
			{
				$interest_amount=($principal_amount*$interest_rate*$loan_period_in_month)/(12*100);
				if ($this->debug) echo "interest amount: $interest_amount <br/>";
				$total_payable=$principal_amount+$interest_amount;
				$installment_amount=number_format($total_payable/$number_of_installment,2);
				$principal_installment_amount=number_format($principal_amount/$number_of_installment,2);
				for($i=1;$i<=$number_of_installment;$i++)
				{
					$interest_installment_amount=$installment_amount-$principal_installment_amount;                                                             
                    $amounts[]=array('installment_amount'=>$installment_amount
                    ,'principal_installment_amount'=>$principal_installment_amount,
                    'interest_installment_amount'=>number_format($interest_installment_amount,2));
				}		
			}elseif($loan['mode_of_interest']=='DAILY_PER_THOUSAND')
			{
				//to do
			}
		}elseif($loan['interest_calculation_method']=='REDUCING')
		{
			if($loan['mode_of_interest']=='YEARLY_PER_HUNDRED')
			{
				$no_of_payment_per_year = ($number_of_installment*12)/$loan_period_in_month;  
				$interest_per_installment=$interest_rate/($no_of_payment_per_year*100);
				$installment_amount = $principal_amount*$interest_per_installment/(1 - pow((1+$interest_per_installment),-$number_of_installment));
			   
				$amounts=array();
				$principal_remaining=$principal_amount;
				$counter = $number_of_installment;
				$principal_paid=0;
				while($counter > 0){
					if ($counter==1){
						$principal_payable=$principal_amount-$principal_paid;
						$interest_payable=$installment_amount-$principal_payable;
						$principal_remaining = $principal_remaining-$principal_payable;
					}else
					{
						$interest_payable=$principal_remaining*$interest_per_installment;
						$principal_payable=$installment_amount-$interest_payable;
						$principal_remaining =$principal_remaining-$principal_payable;
						$principal_paid+=number_format($principal_payable,2);
					}
					$amounts[]=array('installment_amount'=>number_format($installment_amount,2),'principal_installment_amount'=>number_format($principal_payable,2),'interest_installment_amount'=>number_format($installment_amount-number_format($principal_payable,2),2));
					$counter--;
				}
			}
		}
		return $amounts;		
	}
	
	//Loading samity information ================================================================
	
	private function _load_samity_day_list()
	{
		$this->db->select('id,samity_day');
		$this->db->from('samities');
		$query = $this->db->get();	
		$result= $query->result();
		$query->free_result();
		foreach($result as $samity)
		{
			$this->samity_list[$samity->id]=$samity;
		}
		unset($result);
	}
	
    private function _load_samity_day_change()
	{
		$this->db->select('samity_id,effective_date,previous_samity_day,new_samity_day');
		$this->db->from('samity_day_changes');
		$query = $this->db->get();	
		$result= $query->result();
		foreach($result as $row)
		{
			$this->samity_day_change_list[$row->samity_id][]=$row;
		}
		$query->free_result();
		return $result;
	}
	
	
	/*
	function get_loan_details()
	{
		$this->_load_loan_list();
		echo 'Memory Used: '.$this->convert(memory_get_usage(true)).'<br/>';
		for($i=0;$i<count($this->loan_list);$i++){
			$this->_run_scheduler($this->loan_list[$i]);
		}
		echo 'Memory Used: '.$this->convert(memory_get_usage(true)).'<br/>';
		return true;
	}
	**/
	//Loading holiday list=================================================================================================
	
	//Get holiday list - both for banch and samities
	public function _load_holiday_list()
	{
		$branch_holiday_list=$this->_get_holidays_by_branch($this->branch_id,$this->date_to);
		$samity_holiday_list=$this->_get_holidays_by_samity($this->date_to);
		
		foreach($branch_holiday_list as $holiday)
			$this->branch_holiday_list[$holiday->holiday_date]=null;
		foreach($samity_holiday_list as $holiday)
			$this->samity_holiday_list[$holiday->samity_id][$holiday->holiday_date]=null;
	}
	
	private function _get_holidays_by_branch($branch_id,$date_to){
        $this->db->select('holiday_date,');
		$this->db->from('config_holidays');
		$this->db->where("((branch_id is null and samity_id is null) or branch_id=$branch_id )");
		$query = $this->db->get();	
		$result= $query->result();
		$query->free_result();
		return $result;
	}
	
	private function _get_holidays_by_samity($date_to){
        $this->db->select('holiday_date, samity_id');
		$this->db->from('config_holidays');
		$this->db->where('samity_id is not null');
		$query = $this->db->get();	
		$result= $query->result();
		$query->free_result();
		return $result;
	}
	
	private function _is_holiday($samity_id,$date)
	{
		if(isset($this->branch_holiday_list[$date])) return true;
		if(isset($this->samity_holiday_list[$samity_id][$date])) return true;
	}
	
	function convert($size)
	{
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
}
