<?php
/** 
	* Transaction Model Class.
	* @pupose		Loan / Savings transaction information
	*		
	* @filesource	./system/application/models/transaction.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.transaction
	* @version      $Revision: 1 $
	* @author       $Author: Anisur Rahman Alamgir $	
	* @lastmodified $Date: 2011-01-11 $	 
*/ 
class Transaction extends Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    //This function is for listing of samities 
	function get_samity_info($data=null)
	{	
		$q = "SELECT id as samity_id,concat(code,' (',name,')') as samity_name 
										FROM samities 
										WHERE samity_day='".$data['dayname']."'
										AND branch_id='".$data['branch_id']."'
										AND id 
										NOT IN(SELECT samity_id 
										FROM loan_transactions 
										WHERE branch_id='2'
										AND transaction_date='".$data['current_date']."'
										AND is_auto_process='1' 
										)
										AND id 
										NOT IN(SELECT samity_id 
										FROM saving_deposits 
										WHERE branch_id='2'
										AND transaction_date='".$data['current_date']."')
										ORDER BY code ASC";
		
		$samity_info = $this->db->query($q);																							

		return $samity_info->result();  
	}
	
/*
	function get_samity_info_autoprocess_done($data=null)
	{		
		$samity_info = $this->db->query("SELECT id,samity_id
										FROM loan_transactions 
										WHERE transaction_date='".$data['current_date']."'
										AND branch_id='".$data['branch_id']."'
										ORDER BY id ASC");													

		return $samity_info->result();  
	}
*/
	/**
	 * This function is for listing of samity wise active member 
	 * @param samity_id   
	 */
	function get_samity_wise_member_info($samity_id)
	{	
/*
		 $query="SELECT 
				saving_products_id,
				product_id,
				branch_id,
				samity_id,
				samity_code,
				member_id,
				primary_product_id,
				member_name,
				SUM(savings_id) AS savings_id,
				SUM(weekly_savings) AS weekly_savings ,
				loan_id,
				SUM(installment_amount) AS installment_amount,
				skt_amount
		FROM (SELECT 
				s.id AS samity_id,
				s.code AS samity_code,				
				m.id AS member_id,
				m.branch_id,
				m.primary_product_id,
				m.name AS member_name, 
				0 AS savings_id, 
				0 AS saving_products_id,
				0 AS weekly_savings,
				l.id AS loan_id, 
				l.installment_amount,
				l.product_id,
				s.skt_amount
		FROM samities AS s
		LEFT JOIN members AS m ON (m.samity_id = s.id AND m.member_status = 'Active')
		RIGHT JOIN loans AS l ON (l.member_id = m.id) 
		WHERE s.id = $samity_id
		UNION ALL 
		SELECT 
			s.id AS samity_id,
			s.code AS samity_code,
			m.id AS member_id,
			m.branch_id,
			m.primary_product_id,
			m.name AS member_name, 
			sv.id AS savings_id,
			sv.saving_products_id,
			sv.weekly_savings AS weekly_savings,
			0 AS loan_id , 
			0 AS installment_amount,
			0 AS product_id,
			s.skt_amount
	  FROM samities AS s
	  LEFT JOIN members AS m ON (m.samity_id = s.id AND m.member_status = 'Active')
	  RIGHT JOIN savings AS sv ON (sv.member_id = m.id)  
	  WHERE s.id = $samity_id
	) t GROUP BY member_id ";	
*/
		$query="SELECT                
					saving_products_id,
					product_id,
					branch_id,
					samity_id,
					samity_code,
					member_id,
					primary_product_id,
					member_name,
					savings_id,
					savings_acc,
					SUM(weekly_savings) AS weekly_savings ,
					customized_loan_no,
					loan_id,
					SUM(installment_amount) AS installment_amount,
					skt_amount
				FROM (SELECT 
					s.id AS samity_id,
					s.code AS samity_code,                
					m.id AS member_id,
					m.branch_id,
					m.primary_product_id,
					m.name AS member_name, 
					0 AS savings_id, 
					0 AS savings_acc,
					0 AS saving_products_id,
					0 AS weekly_savings,
					l.customized_loan_no,
					l.id AS loan_id, 
					l.installment_amount,
					l.product_id,
					s.skt_amount
				FROM samities AS s
				LEFT JOIN members AS m ON (m.samity_id = s.id AND m.member_status = 'Active')
				RIGHT JOIN loans AS l ON (l.member_id = m.id) 
				WHERE s.id = $samity_id
				UNION ALL 
				SELECT 
					s.id AS samity_id,
					s.code AS samity_code,
					m.id AS member_id,
					m.branch_id,
					m.primary_product_id,
					m.name AS member_name, 
					sv.id AS savings_id,
					sv.code AS savings_acc,
					sv.saving_products_id,
					sv.weekly_savings AS weekly_savings,
					0 AS customized_loan_no,
					0 AS loan_id , 
					0 AS installment_amount,
					0 AS product_id,
					s.skt_amount
				FROM samities AS s
				LEFT JOIN members AS m ON (m.samity_id = s.id AND m.member_status = 'Active')
				RIGHT JOIN savings AS sv ON (sv.member_id = m.id)  
				WHERE s.id = $samity_id
				) t GROUP BY member_id ,savings_id,loan_id
				ORDER BY member_id
				";
		
		$auto_process_info = $this->db->query($query);		
		return $auto_process_info->result();  
	}
	
    function loan_transaction_add($data)
    {
        return $this->db->insert('loan_transactions', $data);
    }
    function loan_due_add($data)
    {
        return $this->db->insert('loan_due_collection_register', $data);
    }
    function loan_advance_add($data)
    {
        return $this->db->insert('loan_advance_collection_register', $data);
    }
    function member_attendence_add($data)
    {
        return $this->db->insert('member_attendance', $data);
    }
    function member_skt_add($data)
    {
        return $this->db->insert('skt_collections', $data);
    }
    
    function saving_transaction_add($data)
    {
        return $this->db->insert('saving_deposits', $data);
    }
    function samity_read($samity_id)
    {
        $query=$this->db->getwhere('samities', array('id' => $samity_id));
		return $query->result();
    }
	function get_samity_wise_loan_unauthorizationprocess($samity_id)
	{		
		$loan_info = $this->db->query("SELECT lt.id AS loan_transaction_id, lt.amount AS laon_amount, lt.installment_number 
		, lt.transaction_date, l.id AS loan_id, l.customized_loan_no AS laon_no
		, m.id AS member_id, m.name AS member_name, m.code AS member_code, s.id AS samity_id
		FROM 
		samities AS s
		LEFT JOIN members AS m ON (m.samity_id = s.id)
		LEFT JOIN loans AS l ON (l.member_id = m.id  )
		LEFT JOIN loan_transactions AS lt ON (lt.loan_id = l.id )
		WHERE lt.authorization_status = 0 AND s.id = $samity_id AND lt.is_deleted = 0 AND l.is_deleted = 0 ORDER BY m.id;");			
		return $loan_info->result();  
	}
	function get_samity_wise_saving_unauthorizationprocess($samity_id)
	{		
		$saving_info = $this->db->query("SELECT st.id AS saving_transaction_id, st.amount AS saving_amount
		,st.transaction_date AS transaction_date, sv.id AS saving_id, sv.code AS saving_code
		,m.id AS member_id, m.name AS member_name, m.code AS member_code, s.id AS samity_id
		FROM 
		samities AS s
		LEFT JOIN members AS m ON (m.samity_id = s.id)
		LEFT JOIN savings AS sv ON (sv.member_id = m.id)
		LEFT JOIN saving_transactions AS st ON (st.savings_id = sv.id)
		WHERE st.authorization_status = 0 AND s.id = $samity_id AND st.is_deleted = 0 AND sv.is_deleted = 0
		ORDER BY m.id;");			
		return $saving_info->result();  
	}
}
