<?php
//$holiday_list=array('2010-01-01','2010-01-8','2010-02-01','2010-03-10','2010-04-10','2010-05-10','2010-06-10','2010-07-10','2010-08-10','2010-09-10','2010-10-10',
//'2010-11-10','2010-12-10','2010-12-16');
$holiday_list=array('2010-01-01','2010-01-05','2010-02-19');
foreach($holiday_list as $holiday)
{			
	$holidays[$holiday]=$holiday;			
}		

for($i=1;$i<200000;$i++)
{
	//$loan=new Loan($i,$i,2000,0.10,10,'2010-01-01');
	$loan=new Loan($i,$i,2000,0.10,45,'2010-01-01');
	$schedule=$loan->get_schedule($holiday_list);
	$j=0;
	foreach($schedule as $schedule)
	{
		$j++;
		echo $j." Installment Date ". $schedule."\n";
	}
}

class Loan
{
	var $id;
	var $member_id;
	var $loan_amount;
	var $interest_rate;
	var $no_of_installment;
	var $first_pay_date;
	
	function Loan($id,$member_id,$loan_amount,$interest_rate,$no_of_installment,$first_pay_date)
	{
		$this->id=$id;
		$this->member_id=$member_id;
		$this->loan_amount=$loan_amount;
		$this->interest_rate=$interest_rate;
		$this->no_of_installment=$no_of_installment;
		$this->first_pay_date=$first_pay_date;
		echo("[NEW] LoanID=$id, MemberID=$member_id, LoanAmount=$loan_amount, InterestRate=$interest_rate, No.OfInstallment=$no_of_installment\n");
	}
	function get_schedule(&$holidays,$rescheule_date_list=null)
	{
		//echo "Holidays list\n";
		//print_r($holidays);
		$count=0;
		$schedule=array();
		$schedule_date=$this->first_pay_date;		
		while($count < $this->no_of_installment)
		{			
			if(!array_key_exists($schedule_date,$holidays))
			{
				$count++;
				$schedule[$schedule_date]=$schedule_date;					
			}
			//Add 6 days to the $schedule_date;
			$next_schedule_date = strtotime("+7 day", strtotime($schedule_date));	
			$next_schedule_date=date("Y-m-d", $next_schedule_date);
			//Check if holiday; If holiday then add 6 days more..
			//If not a holiday, add that day to the schedule and increase the counter
			$schedule_date=$next_schedule_date;				
			//$schedule[]=
		}		
		//echo "schedule list\n";
		//print_r($schedule);
		return $schedule;		
	}	
}
?>

