<?php defined('BASEPATH') OR exit('No direct script access allowed');

class apimodel extends CI_Model{

	public function __construct() {
		$this->load->database();
	}

	public function login_user($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function registration_api($data){
		$query = $this->db->insert('e_user',$data);
		return $this->db->insert_id();
	}
	public function save_bill_details($data){
		$query = $this->db->insert('bills_details',$data);
		return $this->db->insert_id();
	}
	public function save_data($tabe,$data){
		$query = $this->db->insert($tabe,$data);
		return $this->db->insert_id();
	}
	public function save_transaction_data($data){
		$query = $this->db->insert('bills_transaction',$data);
		return $this->db->insert_id();
	}
	public function save_image_data($data){
		$query = $this->db->insert('bill_image',$data);
		return $this->db->insert_id();
	}

	public function send_notification($user_id, $notification,$device_type,$serverKey) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		if($device_type == "Android"){
			if($user_id==0){
				 $sql = "SELECT fcm_key FROM fcm ";
			}else{
				 $sql = "SELECT fcm_key FROM fcm where user_id ='".$user_id."';";
			}
			    $registatoin_ids= $this->db->query($sql)->result();
			$fields = array(
				'to' => $registatoin_ids[$fcm_key],
				'data' => $notification
			);
		} else {
			$fields = array(
				'to' => $registatoin_ids,
				'notification' => $notification
			);
		}
// Firebase API Key
		$headers = array('Authorization:key='.$serverKey.'','Content-Type:application/json');
// Open connection
		$ch = curl_init();
// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed:' . curl_error($ch));
		}
		curl_close($ch);
	}


	public function find_merchant_monthly_payment($where){
		// SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(*) as total_transaction FROM vendor_payment WHERE user_id =526 GROUP BY YEAR(Date),MONTH(Date)

		  $sql = "SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(*) as Total_transaction FROM vendor_payment WHERE ".$where." GROUP BY YEAR(Date),MONTH(Date)";

    return $this->db->query($sql)->result();

	}


public function search_data($sql){
		// SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(*) as total_transaction FROM vendor_payment WHERE user_id =526 GROUP BY YEAR(Date),MONTH(Date)


    return $this->db->query($sql)->result();

	}


	public function get_bill_details_data_all($where,$limits){
		// SELECT * FROM `bills_details` ORDER BY date asc LIMIT 5,10
		$this->db->select("*");
		$this->db->from("bills_details");
		$this->db->join('e_user', 'e_user.id = bills_details.client_id');
		$this->db->where($where);
		$this->db->order_by("bill_id","DESC");
		if($limits==="true")
			$this->db->limit(10,0);
		$q = $this->db->get();
		return $q->result();
	}
		public function find_merchant_transaction_details($where,$limits){
		// SELECT * FROM `bills_details` ORDER BY date asc LIMIT 5,10
		$this->db->select("*");
		$this->db->from("vendor_payment");
		$this->db->join('e_user', 'e_user.id = vendor_payment.user_id');
		$this->db->where($where);
		$this->db->order_by("vp_id","DESC");
		if($limits==="true")
			$this->db->limit(10,0);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_total_bill_details_all($where,$limits){
		// SELECT * FROM `bills_details` ORDER BY date asc LIMIT 5,10
		$this->db->select("sum(amount) as amount,bill_details_id");
		$this->db->from("bills_details");
		$this->db->join('bills_transaction', 'bills_transaction.bill_details_id=bills_details.bill_id');
		$this->db->where($where);
		$this->db->group_by("bill_details_id");
		$this->db->order_by("bill_id","DESC");
		if($limits==="true")
			$this->db->limit(10,0);
		$q = $this->db->get();
		return $q->result();
	}
	public function get_client_name($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function find_user_info($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function get_notification($where){
		$this->db->select("*");
		$this->db->from("notification");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_work_info($where){
		$this->db->select("*");
		$this->db->from("work");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function genaral_setting(){
		$this->db->select("*");
		$this->db->from("e_general_setting");
		$q = $this->db->get();
		return $q->result_array();
	}
	public function get_all_bill_transaction($where){
		$this->db->select("*");
		$this->db->from("bills_transaction");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function find_work_update_info($where){
		$this->db->select("*");
		$this->db->from("work_updates");
		$this->db->where($where);
		$this->db->order_by("u_id","desc");
		$q = $this->db->get();
		return $q->result();
	}


	public function find_client_payment_info($where){
		$this->db->select("*");
		$this->db->from("client_payment_history");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_gallery_info($where){
		$this->db->select("*");
		$this->db->from("gallery");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_work_progress_info($where){
		$this->db->select("*");
		$this->db->from("work_progress");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_installment_info($where){
		$this->db->select("*");
		$this->db->from("installment_details");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function find_installment_paid($where){
		$this->db->select("COUNT(cph_id) as total_paid");
		$this->db->from("client_payment_history");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	


	public function find_installment_paid_percent($where){
		$sql = "SELECT id_total_amt as total_amt, COUNT(cph_id) as total_paid,sum(cph_paid_amt) as total_paid FROM `client_payment_history` JOIN installment_details ON client_payment_history.cph_user_id=installment_details.id_user_id WHERE ".$where;
		return $this->db->query($sql)->result();


		$this->db->select("id_total_amt as total_amt, COUNT(cph_id) as total_paid,sum(cph_paid_amt) as total_paid");
		$this->db->from("client_payment_history");

		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function update_questions($where,$data){
		$this->db->where($where);
		return $this->db->update('e_question',$data);

	}
	public function delete_questions($where){
		$this->db->where($where);
		$this->db->delete("e_question");
		return "1";
	}
	//Questions ends
	public function delete_answers($where){
		$this->db->where($where);
		$this->db->delete("e_answers");
		return "1";
	}

	public function add_answer_api($data){
		$query = $this->db->insert('e_answers',$data);
		return $this->db->insert_id();
	}
	public function all_answer($where){
		$this->db->select("*");
		$this->db->from("e_answers");
		$this->db->join('e_user', 'e_user.id = e_answers.user_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function update_answers($where,$data){
		$this->db->where($where);
		return $this->db->update('e_answers',$data);
	}

	public function profile($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}


	public function check_fcm($where){
		$this->db->select("*");
		$this->db->from("fcm");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}


	public function update_profile($where,$data){
		$this->db->where($where);
		return $this->db->update('e_user',$data);
	}
	public function update_seen($where,$data){
		$this->db->where($where);
		return $this->db->update('notification',$data);
	}
	public function update_tokken($data){
		return $this->db->insert('fcm',$data);
	}

	public function category(){
		$this->db->select("*");
		$this->db->from("e_category");
		$q = $this->db->get();
		return $q->result();
	}

	public function booklist_by_category($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}


	public function author($where){
		$this->db->select("*");
		$this->db->from("e_author");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function semester(){
		$this->db->select("*");
		$this->db->from("e_sem");
		$q = $this->db->get();
		return $q->result();
	}

	public function booklist_by_author($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function get_book_semester($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function get_course_id($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function readcnt_by_author($where){
		$this->db->select("sum(readcnt) as readcount, sum(download) as download");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->group_by('a_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function booklist(){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$q = $this->db->get();
		return $q->result();
	}
	public function bookSearch($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function booklist_by_semester($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function bookdetails($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		    // $this->db->join('e_transacation', 'e_transacation.t_fb_id = e_book.b_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function popularbooklist($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->where($where);
		$this->db->order_by("readcnt","DESC");
		$q = $this->db->get();
		return $q->result();
	}

	public function booklist_free_paid($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$this->db->order_by("readcnt","DESC");
		$q = $this->db->get();
		return $q->result();
	}

	public function allbook(){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		    // $this->db->join('e_transacation', 'e_transacation.t_fb_id = e_book.b_id');
		     // $this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function transacation($where){
		$this->db->select("*");
		$this->db->from("e_transacation");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function related_item($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function newarrival($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->order_by("b_date","DESC");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function featureitem($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function view_cnt($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function update_view($where,$add_point){
		$this->db->set('readcnt', $add_point, FALSE);
		$this->db->where($where);
		$this->db->update('e_book');
		return true;
	}

	public function update_download($where,$add_point){
		$this->db->set('download', $add_point, FALSE);
		$this->db->where($where);
		$this->db->update('e_book');
		return true;
	}

	public function add_comment($data){
		$query = $this->db->insert('e_comment',$data);
		return $this->db->insert_id();
	}
	public function add_vote($data){
		$query = $this->db->insert('e_vote',$data);
		return $this->db->insert_id();
	}
	public function remove_vote($where){
		$this->db->where($where);
		$this->db->delete("e_vote");
		return "1";
	}

	public function remove_one_notification($where){
		$this->db->where($where);
		$this->db->delete("notification");
		return "1";
	}
	public function remove_bill_details_data($bill_id){
		//delete form bill details table
		$where='bill_id="'.$bill_id.'"';
		$this->db->where($where);
		$this->db->delete("bills_details");
		// delete form bill related transaction
		$where='bill_details_id="'.$bill_id.'"';
		$this->db->where($where);
		$this->db->delete("bill_image");
		// delete bill image
		$where='bill_details_id="'.$bill_id.'"';
		$this->db->where($where);
		$this->db->delete("bills_transaction");
		return "1";
	}


	public function view_comment($where){
		$this->db->select("*");
		$this->db->from("e_comment");
		$this->db->join('e_user', 'e_user.id = e_comment.user_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function purchase($data){
		$query = $this->db->insert('e_transacation',$data);
		return $this->db->insert_id();
	}

	public function add_continue_read($data){
		$query = $this->db->insert('e_continue_read',$data);
		return $this->db->insert_id();
	}

	public function continue_read($where){
		$this->db->select("*");
		$this->db->from("e_continue_read");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function get_total_vote($where){
		$this->db->select("*");
		$this->db->from("e_vote");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function add_bookmark($data){
		$query = $this->db->insert('e_bookmark',$data);
		return $this->db->insert_id();
	}



}
