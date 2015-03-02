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
    
class Loan_scheduler extends MY_Model {

	private $branch_id=null;
	private $samity_id=null;
	private $loan_list=array();
	private $branch_holiday_list=array();
	private $samity_holiday_list=array();
	private $samity_list=array();
	private $samity_day_change_list=array();
	private $date_from=null;
	private $date_to=null;
	
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
	
	function get_loan_schedule($loan)
	{
		//$loan=$this->_load_loan($loan_id);
		return $this->_run_scheduler($loan);
	}
	
	function convert($size)
	{
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

	private function _run_scheduler(&$loan)
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
			echo "[$date] holiday, Trying next<br/>";
			$date=date('Y-m-d',strtotime("next $samity_day",strtotime($date)));
			$date=$this->get_valid_schedule_date($date,$samity_id);
		}
		
		$samity_day=$this->get_samity_day($samity_id,$date);
		if(strtoupper(date('D',strtotime($date)))!=$samity_day)
		{
			echo "[$date] Not samity day(Expected: $samity_day , but found: ".strtoupper(date('D',strtotime($date)))."), Trying next<br/>";
			$date=date('Y-m-d',strtotime("next $samity_day",strtotime($date)));
			$date=$this->get_valid_schedule_date($date,$samity_id);
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
		if($loan['interest_calculation_method']=='FLAT')
		{
			if($loan['mode_of_interest']=='YEARLY_PER_HUNDRED')
			{
				$interest_amount=($loan['loan_amount']*$loan['interest_rate']*$loan['loan_period_in_month'])/(12*100);
				echo "interest amount: $interest_amount <br/>";
				$total_payable=$loan['loan_amount']+$interest_amount;
				$installment_amount=round($total_payable/$loan['number_of_installment']);
				for($i=1;$i<=$loan['number_of_installment'];$i++)
				{
					if($i==$loan['number_of_installment']){
						$amounts[]=$total_payable-$installment_amount*($i-1);
					}else{						
						$amounts[]=$installment_amount;
					}
				}		
			}elseif($loan['mode_of_interest']=='DAILY_PER_THOUSAND')
			{
				//to do
			}
		}elseif($loan['interest_calculation_method']=='REDUCING')
		{
			if($loan['mode_of_interest']=='YEARLY_PER_HUNDRED')
			{
				//to do
			}elseif($loan['mode_of_interest']=='DAILY_PER_THOUSAND')
			{
				//to do
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
	
	//Loading Loan list=================================================================================================
	
	public function _load_loan_list()
	{
		$loan_list=array();
		if(empty($this->samity_id))
			$loan_list=$this->_get_loan_list_by_branch($this->branch_id,$this->date_from,$this->date_to);
		else
			$loan_list=$this->_get_loan_list_by_samity($this->samity_id,$this->date_from,$this->date_to);
		$this->loan_list= $loan_list;
	}
	
	private function _load_loan($loan_id)
    {
		$this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
		$this->db->from('loans');
		$this->db->where(array('id'=>$loan_id));
		$query = $this->db->get();
		$loan=$query->row_array();  
		$query->free_result();
        return $loan;
	}
	
	private function _get_loan_list_by_branch($branch_id,$date_from,$date_to)
    {
		$this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
		$this->db->from('loans');
		$this->db->where(array('branch_id'=>$branch_id,'loans.is_deleted' => 0));
		$this->db->where("(loan_closing_date is null or loan_closing_date between $date_from and $date_to)" );
		$query = $this->db->get();
		$result=$query->result_array();  
		$query->free_result();
        return $result;
	}
	
	private function _get_loan_list_by_samity($samity_id,$date_from,$date_to)
    {
		$this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
		$this->db->from('loans');
		$this->db->where(array('samity_id'=>$samity_id,'loans.is_deleted' => 0));
		$this->db->where("(loan_closing_date is null or loan_closing_date between $date_from and $date_to)" );
		$query = $this->db->get();
		$result = $query->result_array();
		$query->free_result();
        return $result;
	}
	
	//dummy data insertion
	function insert_loan_dummy_data()
	{
		$query = $this->db->query('select id,branch_id,samity_id from members where branch_id=2');
		foreach($query->result() as $member )
		{
			$str="INSERT INTO loans (branch_id,samity_id,product_id,member_id,interest_calculation_method,loan_amount,interest_rate,number_of_installment,repayment_frequency,loan_period_in_month,mode_of_interest,purpose_id,first_repayment_date,funding_org_id)
						values ($member->branch_id,$member->samity_id,1,$member->id,'FLAT',10000,12.5,45,'WEEKLY',12,'YEARLY_PER_HUNDRED',1,'2010-01-01',1)";
			$this->db->query($str);
		}
	}
}
