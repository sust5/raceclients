<?php defined('BASEPATH') OR exit('No direct script access allowed');
//client = 1 and vender =2
class Adminmodel extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function admin_varify($where){
		$this->db->select("*");
		$this->db->from("e_admin");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function carousel(){
		$sql = "SELECT * from carousel";
    	return $this->db->query($sql)->result();

	}


	public function update_text_data(){
		$sql = "SELECT * from general_data limit 1";
    	return $this->db->query($sql)->result();
	}


public function get_all_data($tablename){
		$sql = "SELECT * from $tablename";
    	return $this->db->query($sql)->result();
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
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
	}




	public function getAllFcm(){
		// SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(*) as total_transaction FROM vendor_payment WHERE user_id =526 GROUP BY YEAR(Date),MONTH(Date)

		$sql = "SELECT * FROM fcm;";

		return $this->db->query($sql)->result();

	}
public function todayTransaction(){
		$sql = "SELECT bill_id FROM `bills_details` WHERE DATE(`date`) = CURDATE();";
		return $this->db->query($sql)->result();
	}


	public function workUpdateList(){
		$sql = "SELECT id,u_id, fullname, w_work_title, u_title as title FROM `work_updates` JOIN e_user ON e_user.id = work_updates.user_id JOIN work ON work.w_user_id =e_user.id GROUP BY u_id";
		return $this->db->query($sql)->result();
	}

	public function galleryList(){
		$sql = "SELECT g_id as id,w_id,g_title as title, g_url as link,g_date as cur_date, w_work_title as work FROM gallery  join work on gallery.g_work_id=work.w_id ;";
		return $this->db->query($sql)->result();
	}

	public function clientPaymentInfo(){
		$sql ="SELECT id,id_id, w_id,fullname as name, id_total_amt AS total_amt, id_paid_amt as paid_installment ,id_total_installment as total_installment,id_paid_installment as paid_installment, w_work_title as workName FROM e_user JOIN installment_details ON installment_details.id_user_id = e_user.id JOIN work ON work.w_user_id = e_user.id where e_user.account_type =1 GROUP BY id_id ;";
					return $this->db->query($sql)->result();
	}

	// public function installment_details(){
	// 	$sql ="SELECT * FROM `installment_details`;";
	// 				return $this->db->query($sql)->result();
	// }

	public function clientTransactionDetais($id){
		$sql = "SELECT * FROM e_user JOIN client_payment_history ON client_payment_history.cph_user_id = e_user.id where e_user.account_type =1 AND e_user.id=$id;";
			return $this->db->query($sql)->result();
	}


	public function workList(){
		$sql = "SELECT  w_id as id, w_work_title as work_title FROM work  ;";
		return $this->db->query($sql)->result();

	}

	public function reportList(){
		$sql = "SELECT report_box.id as id,message,account_type,subject,fullname,date FROM `report_box` join e_user ON e_user.id = report_box.user_id;";
		return $this->db->query($sql)->result();

	}
	public function workListWithClient(){
		$sql = "SELECT w_id as id,wp_percent_complete as 'complete_percent', w_work_title as work_title, w_start_date as start_date, w_dead_line as dead_line, fullname as fullname FROM work JOIN work_progress ON work.w_id =work_progress.wp_work_id JOIN e_user ON e_user.id = work.w_user_id";
			return $this->db->query($sql)->result();
	}

	public function workProgressList(){
		$sql = "SELECT wp_id as id,wp_title as work_des_title,wp_desc,wp_percent_complete as 'complete_percent', w_work_title as work_title, w_start_date as start_date, w_dead_line as dead_line, fullname as fullname FROM work JOIN work_progress ON work.w_id =work_progress.wp_work_id JOIN e_user ON e_user.id = work.w_user_id GROUP BY wp_id;";
					return $this->db->query($sql)->result();
	}
	public function editProgressList($id){
		$sql = "SELECT wp_id ,wp_title as work_des_title,wp_desc,wp_percent_complete as 'complete_percent', w_work_title as work_title, w_start_date as start_date, w_dead_line as dead_line, fullname as fullname FROM work JOIN work_progress ON work.w_id =work_progress.wp_work_id JOIN e_user ON e_user.id = work.w_user_id where wp_id='".$id."';";
					return $this->db->query($sql)->result();
	}

	public function getuserFcm($user_id){
		// SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(*) as total_transaction FROM vendor_payment WHERE user_id =526 GROUP BY YEAR(Date),MONTH(Date)

		$sql = "SELECT * FROM fcm where user_id='$user_id';";

		return $this->db->query($sql)->result();

	}

	/*=====================Course========================*/

	public function course_list(){
		$this->db->select("*");
		$this->db->from("e_course");
		$q = $this->db->get();
		if(!empty($result))
			return true;
		else
		{
			return false;
		}


	}
	/*=====================Sem========================*/

	public function get_installment_details($where){
		$this->db->select("*");
		$this->db->from("client_payment_history");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function get_installment_total_amount($where){
		$this->db->select("*");
		$this->db->from("installment_details");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	/*=====================Category========================*/

		public function category_list(){
			$this->db->select("*");
			$this->db->from("e_category");
			$q = $this->db->get();
			return $q->result();
		}

			public function check_installment(){
				$this->db->select("id_user_id");
				$this->db->from("installment_details");
				$q = $this->db->get();
				return $q->result();
			}
			public function check_work(){
				$this->db->select("w_user_id");
				$this->db->from("work");
				$q = $this->db->get();
				return $q->result();
			}

	public function add_category($data){
		$query = $this->db->insert('e_category',$data);
		return $this->db->insert_id();
	}

	public function addInstallment($data){
		$data[0]=
		$query = $this->db->insert('installment_details',$data);
		return $this->db->insert_id();
	}
	public function add_data($data,$tablename){
		$query = $this->db->insert($tablename,$data);
		return $this->db->insert_id();
	}
	public function add_course($data){
		$query = $this->db->insert('e_course',$data);
		return $this->db->insert_id();
	}

	public function delete_category($id){
		$this->db->delete('e_category', array('cat_id' => $id));
	}
	public function delete_review($id){
		$this->db->delete("review", array('r_id' => $id));
	}
	public function social_media_data($id){
		$this->db->delete('social_media', array('s_id' => $id));
	}
	public function delete_website_gallery($id){
		$this->db->delete('website_gallery', array('wg_id' => $id));
	}
	public function delete_faq($id){
		$this->db->delete('faq', array('f_id' => $id));
	}
	public function delete_offer($id){
		$this->db->delete('offer', array('o_id' => $id));
	}
	public function delete_Carousel($id){
		$this->db->delete('carousel', array('c_id' => $id));
	}
	public function delete_work_updates($id){
		$this->db->delete('work_updates', array('u_id' => $id));
	}

	public function delete_work($id){
		$this->db->delete('work', array('w_id' => $id));
	}

	public function delete_work_progress($id){
		$this->db->delete('work_progress', array('wp_id' => $id));
	}

	public function delete_installment_details($id){
		$this->db->delete('installment_details', array('id_id' => $id));
	}

	public function delete_client_payment_history($id){
		$this->db->delete('client_payment_history', array('cph_id' => $id));
	}

	public function get_category($where){
		$this->db->select("*");
		$this->db->from("e_category");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function get_data($table,$where){
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function get_course($where){
		$this->db->select("*");
		$this->db->from("e_course");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

		public function update_status_category($id,$status){
			$this->db->where('cat_id', $id);
			return $this->db->update('e_category', $status);
		}

			public function update_data($tablename,$key,$value,$data){
				$this->db->where($key, $value);
				return $this->db->update($tablename, $data);
			}


	public function update_status_course($id,$status){
		$this->db->where('course_id', $id);
		return $this->db->update('e_course', $status);
	}

	/*=====================End Category========================*/
	/*=====================Question========================*/

	public function question_list(){
		$this->db->select("*");
		$this->db->from("e_question");
		$q = $this->db->get();
		return $q->result();
	}
	public function add_question($data){
		$query = $this->db->insert('e_question',$data);
		return $this->db->insert_id();
	}
	public function delete_question($id){
		$this->db->delete('e_question', array('q_id' => $id));
	}

	public function get_question($where){
		$this->db->select("*");
		$this->db->from("e_question");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function update_status_question($id,$status){
		$this->db->where('q_id', $id);
		return $this->db->update('e_question', $status);
	}
	/*=====================End Question========================*/

	/*=====================Users===============================*/

	public function add_user($data){
		$query = $this->db->insert('e_user',$data);
		return $this->db->insert_id();
	}

	public function addFaq($data){
		$query = $this->db->insert('faq',$data);
		return $this->db->insert_id();
	}

	public function userlist(){
		$this->db->select("*");
		$this->db->from("e_user");
		//edit here
		$this->db->order_by("c_date", "desc");
		$q = $this->db->get();
		return $q->result();
	}
	public function userlistClient(){
		$sql = "SELECT * FROM e_user WHERE account_type='1'";
		return $this->db->query($sql)->result();
	}
	public function get_work_name($id){
		$sql = "SELECT w_work_title as wrok_title,w_id FROM work WHERE w_id='$id'";
		return $this->db->query($sql)->result();
	}
	public function get_id_amount($id_id){
		$sql = "SELECT * FROM installment_details WHERE id_id='$id_id'";
		return $this->db->query($sql)->result();
	}
	public function get_client_name($id){
		$sql = "SELECT * FROM e_user WHERE id='$id'";
		return $this->db->query($sql)->result();
	}
	public function get_work_data($id){
		$sql = "SELECT w_id as id,w_work_title as work_title,w_start_date as start_date,w_dead_line as dead_line,fullname FROM work JOIN e_user ON e_user.id=work.w_user_id where w_id='".$id."';";
		return $this->db->query($sql)->result();
	}

	public function userlistVendor(){
		$sql = "SELECT * FROM e_user WHERE account_type='2'";
		return $this->db->query($sql)->result();
	}

	public function vendor_payment_list(){
		$sql = "SELECT vp_id as id,date,fullname, currency, amount FROM `vendor_payment` JOIN e_user ON e_user.id =vendor_payment.user_id";

		return $this->db->query($sql)->result();
	}
	public function billsDetailsList(){
		// $this->db->select("bill_id,vendor_id,fullname,bills_details.date,bill_url");
		// $this->db->from("bills_details");
		// $this->db->join('bills_transaction', 'bills_transaction.bill_details_id=bills_details.bill_id');
		// $this->db->join('e_user', 'e_user.id =bills_details.vendor_id');
		// $this->db->join('bill_image', 'bill_image.bill_details_id=bills_details.bill_id');
		// // $this->db->group_by("vendor_id");
		// $this->db->order_by("bill_id","DESC");
		// $q = $this->db->get();
		// return $q->result();

	// $this->db->select("bill_id,vendor_id,fullname,sum(amount) as amount,bills_details.date,bill_url");
	// 	$this->db->from("bills_details");
	// 	$this->db->join('bills_transaction', 'bills_transaction.bill_details_id=bills_details.bill_id');
	// 	$this->db->join('e_user', 'e_user.id =bills_details.vendor_id');
	// 	$this->db->join('bill_image', 'bill_image.bill_details_id=bills_details.bill_id');
	// 	// $this->db->group_by("vendor_id");
	// 	// $this->db->order_by("bill_id","DESC");
	// 	$q = $this->db->get();
	// 	return $q->result();



		// $sql = "SELECT bill_id,vendor_id,fullname,sum(amount) as amount,bills_details.date as date,bill_url
		//  FROM `bills_details` 
		//  JOIN bills_transaction ON bills_transaction.bill_details_id =bills_details.bill_id 
		//  JOIN e_user ON e_user.id=bills_details.vendor_id 
		//  JOIN bill_image ON bill_image.bill_details_id=bills_details.bill_id 
		// GROUP BY vendor_id,bill_url 
		// order by date desc
		//  ";


			$sql = "
			select vendor_id,fullname,bills_details.bill_id, sum(amount) as amount ,bills_details.date ,bill_url FROM `bills_transaction` JOIN bills_details ON bills_details.bill_id=bills_transaction.bill_details_id JOIN e_user ON e_user.id=bills_details.vendor_id JOIN bill_image ON bill_image.bill_details_id=bills_details.bill_id GROUP BY bills_transaction.bill_details_id order by bills_details.date desc


		";
		return $this->db->query($sql)->result();
	}

	public function totalClient($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function userlistbywhere($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}
	public function transactionDetails($where){
		$this->db->select("*");
		$this->db->from("bills_transaction");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function getUserNameList(){
		$this->db->select("*");
		$this->db->from("e_user");
		$q = $this->db->get();
		return $q->result();
	}

	public function find_user($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function totalVendor($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function userlist_by_where($where){
		$this->db->select("*");
		$this->db->from("e_user");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function user_status_change($where,$data){
		$this->db->where('id', $where);
		$this->db->update('e_user', $data);
	}

	public function update_Work($data,$id){
		$this->db->where('w_id', $id);
		return $this->db->update('work', $data);
	}

	public function update_user($data,$where){
		$this->db->where('id', $where);
		return $this->db->update('e_admin', $data);
	}

	/*==================End Users============================*/

	/*=====================Author===============================*/

	public function authorall(){
		$this->db->select("*");
		$this->db->from("e_author");
		$q = $this->db->get();
		if(!empty($result))
			return true;
		else
		{
			return false;
		}
	}

	public function add_author($data){
		$query = $this->db->insert('e_author',$data);
		return $this->db->insert_id();
	}

	public function author_by_id($where){
		$this->db->select("*");
		$this->db->from("e_author");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function update_author($id,$status){
		$this->db->where('a_id', $id);
		return $this->db->update('e_author', $status);
	}

	public function delete_author($id){
		$this->db->delete('e_author', array('a_id' => $id));
	}
	public function delete_course($id){
		$this->db->delete('e_course', array('course_id' => $id));
	}
	public function delete_vendor_payment($id){
		$this->db->delete('vendor_payment', array('vp_id' => $id));
	}
	/*====================End Author============================*/



	public function books_by_id($where){
		$this->db->select("*");
		$this->db->from("e_book");
		$this->db->join('e_category', 'e_category.cat_id = e_book.fcat_id');
		$this->db->join('e_author', 'e_author.a_id = e_book.fa_id');
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function add_book($data){
		$query = $this->db->insert('e_book',$data);
		return $this->db->insert_id();
	}


	public function update_book($data,$where){
		$this->db->where('b_id', $where);
		return $this->db->update('e_book', $data);
	}

	public function update_Installment($data,$where){
		$this->db->where('id_id', $where);
		return $this->db->update('installment_details', $data);
	}



	public function books_view(){
		$this->db->select("SUM(readcnt) AS readcount");
		$this->db->from("e_book");
		$q = $this->db->get();
		return $q->result();
	}

	public function books_transacation(){
		$this->db->select("SUM(t_amount) AS earncount");
		$this->db->from("e_transacation");
		$q = $this->db->get();
		return $q->result();
	}

	public function delete_book($id){
		$this->db->delete('gallery', array('g_id' => $id));
	}

	/*======================End Books================================*/

	public function delete_gallery($id){
		$sql = "SELECT * FROM gallery WHERE g_id=$id";
		$gallery= $this->db->query($sql)->result();
		foreach ($gallery as $key => $value) {
			unlink('../../'.$value->g_url);
		}
		$this->db->delete('gallery', array('g_id' => $id));
	}
	public function settings_data(){
		$this->db->select("*");
		$this->db->from("e_general_setting");
		$q = $this->db->get();
		return $q->result();
	}

	public function update_general_setting($data,$where){
		$this->db->where('key', $where);
		$this->db->update('e_general_setting', $data);
		return true;
	}

}
