	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class api extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->model('Apimodel');
			$this->load->helper('url');
			$this->load->helper('form');
		}

		public function index(){
			$this->load->view('welcome_message');
		}

		public function login(){
			$fire_uid=$_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'" ';
			$resultr=$this->Apimodel->login_user($where);

			if(sizeof($resultr)>0){
				$account_type= $resultr[0]->account_type;
				$status=$resultr[0]->status;
				if($status =="enable")
				{
					$response=array('status'=>200,'message'=>'Login Success','account_type'=>"".$account_type);
				}else{
					$response=array('status'=>250,'message'=>'Not Activated','account_type'=>"".$account_type);
				}
			}
			else{
				$r=array();
				$response=array('status'=>400,'message'=>'Something went wrong','User_id'=>'');
			}
			echo json_encode($response);
		}

		public function do_upload()
		{
			$config['upload_path']          =  APPPATH .'../assets/images/bills/';
			$config['allowed_types']        = 'gif|jpg|png';
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('userfile'))
			{
				$error = array('error' => $this->upload->display_errors());
				echo json_encode($error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				echo json_encode($data);
			}
			echo $basename = $_FILES['userfile']['name'];

			move_uploaded_file($_FILES['userfile']['tmp_name'],$config['upload_path'].$basename);

		}



		public function upload_file(){
			$config['upload_path'] =  APPPATH .'../assets/images/bills/';
			$config['overwrite'] = 'false';
			$config["allowed_types"] = 'jpg|jpeg|png|gif';
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('userfile'))
			{
				$this->data['error'] = $this->upload->display_errors();
				echo json_encode(array('status'=>400,'message'=>'Something went wrong',"result"=>$this->data['error']));
				exit;
			}
			else
			{
			  $data = array('upload_data' => $this->upload->data());
			  
			 $title= $this->upload->data('file_name'); 
			$bill_details_id= $_REQUEST['bill_details_id'];
			$url='assets/images/bills/'.$title;
			$data = array(
				'bill_details_id'=>$bill_details_id,
				'image_title'=>$title,
				'bill_url'=>$url
			);
			$check_success=$this->Apimodel->save_image_data($data);
			if($check_success>1){
			  	echo json_encode(array('status'=>200,'message'=>'Upload Success',"result"=>$check_success));

			}else{
			  	echo json_encode(array('status'=>400,'message'=>'failed',"result"=>$check_success));

			}
				exit;
			}




			// $response=array('status'=>400,'message'=>'Required Field Missing','Result'=>'initial');
			// try {
			// 	$target_dir= APPPATH .'../assets/images/';
			// 	if (isset($_FILES["file"]))
			// 	{
			// 		$target_file_name = $target_dir .basename($_FILES["file"]["name"]);

			// 		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name))
			// 		{
			// 			$response=array('status'=>200,'message'=>'Successfully Uploaded','Result'=>'success');
			// 		}
			// 		else
			// 		{
			// 			$response=array('status'=>400,'message'=>'Error while uploading2','Result'=>'not success');
			// 		}
			// 	}
			// 	else
			// 	{
			// 		$response=array('status'=>400,'message'=>'Required Field Missing1','Result'=>'not success');
			// 	}
			// } catch (Exception $e) {
			// 	// echo 'Caught exception: ',  $e->getMessage(), "\n";
			// 	$response=array('status'=>400,'message'=>$e->getMessage(),'Result'=>'not success');
			// }
			// echo json_encode($response);
		}


		public function login_fb(){
			$email=$_REQUEST['email'];

			$where='email="'.$email.'" ';
			$resultr=$this->Apimodel->login_user($where);

			if(sizeof($resultr)>0){
				$uid= $resultr[0]->id;
				$status=$resultr[0]->status;
				if($status=='enable')
					$response=array('status'=>200,'message'=>'Login Success','User_id'=>"".$uid);
				else
					$response=array('status'=>400,'message'=>'User is deactivated. please contact to support team.','User_id'=>"".$uid);
			}else{
				$r=array();
				$response=array('status'=>400,'message'=>'Please enter valid Email OR Password','User_id'=>'');
			}
			echo json_encode($response);
		}

		public function registration(){
			$fullname= $_REQUEST['fullname'];
			$email= $_REQUEST['email'];
			$password= $_REQUEST['password'];
			$password = password_hash($password, PASSWORD_DEFAULT);
			$account_type= $_REQUEST['account_type'];
			$fire_Uid= $_REQUEST['fire_Uid'];

			$where='email="'.$email.'"';
			$r = $this->Apimodel->login_user($where);
			if(sizeof($r)>0){
				$response=array('status'=>400,'message'=>'Email address already exists.' ,'User_id'=>'');
				echo json_encode($response);
			}else{
				$data = array(
					'fullname'=>$fullname,
					'email'=>$email,
					'password'=>$password,
					'fire_uid'=>$fire_Uid,
					'account_type'=>$account_type
				);

				$user_id=$this->Apimodel->registration_api($data);


				$response=array('status'=>200,'message'=>'User registration sucessfuly','account_type'=>$account_type);
				echo json_encode($response);

			}
		}
		public function send_bill_details(){
			$client_id= $_REQUEST['client_id'];
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);
			$data = array(
				'vendor_id'=>$user_id[0]->id,
				'client_id'=>$client_id
			);

			$bill_details_id=$this->Apimodel->save_bill_details($data);
			$response=array('status'=>200,'message'=>'bill saved successfully','bill_details_id'=>$bill_details_id);
			echo json_encode($response);
		}
		public function send_report_message(){
			$fire_uid= $_REQUEST['fire_uid'];
			$subject= $_REQUEST['subject'];
			$message= $_REQUEST['message'];

			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);
			$response=array('status'=>200,'message'=>'Sorry Could not save data');
			if(sizeof($user_id)>0){
				$data = array(
					'user_id'=>$user_id[0]->id,
					'subject'=>$subject,
					'message'=>$message
				);

				$bill_details_id=$this->Apimodel->save_data("report_box",$data);
				$response=array('status'=>200,'message'=>'Reported successfully','bill_details_id'=>$bill_details_id);
			}

			echo json_encode($response);
		}
		public function send_transaction(){
			$particular= $_REQUEST['particular'];
			$rate= $_REQUEST['rate'];
			$bill_details_id= $_REQUEST['bill_details_id'];
			$amt= $_REQUEST['amt'];
			$type= $_REQUEST['type'];
			$no_of_items= $_REQUEST['no_of_items'];

			$data = array(
				'bill_details_id'=>$bill_details_id,
				'type'=>$type,
				'amount'=>$amt,
				'particulars'=>$particular,
				'rate'=>$rate,
				'no_of_items'=>$no_of_items
			);

			$bill_details_id=$this->Apimodel->save_transaction_data($data);
			$response=array('status'=>200,'message'=>'bill saved successfully','Result'=>$response);
			echo json_encode($response);

		}
		
				public function save_image_data(){
			$bill_details_id= $_REQUEST['bill_details_id'];
			$title= $_REQUEST['title'];
			$path= APPPATH .'../assets/images/'.$title.'.jpg';
			$url='assets/images/'.$title;
			$data = array(
				'bill_details_id'=>$bill_details_id,
				'image_title'=>$title,
				'bill_url'=>$url
			);
			$bill_details_id=$this->Apimodel->save_image_data($data);
			$encodedData = str_replace(' ','+',$bill_image_data);
			file_put_contents($path, base64_decode($encodedData));

			$response=array('status'=>200,'message'=>'bill saved successfully');
			echo json_encode($response);
		}
	

		public function fcm_tokken(){
// $notification = array();
// $arrNotification= array();
// $arrData = array();
// $arrNotification["body"] ="Test by Futurelens.";
// $arrNotification["title"] = "PHP Notification";
// $arrNotification["sound"] = "default";
// $arrNotification["type"] = 1;
// $a = $this->Apimodel->send_notification("dP2m0k8TRlmlE6Y8yISftp:APA91bH3r066Sl6trRiJtmg_B7iNSjtpxAnhZgjfuHP_4mVb8SUTFisUl9rItA-M6GZuqCsGNscCedfFTrvTA2utmjx88CVYU1hGtJGWefnwMgMH9sa1bgGymhEe13SCqXEzma91JAnA", $arrNotification,"Android");

			$tokken= $_REQUEST['tokken'];
			$fire_Uid= $_REQUEST['fire_uid'];
			$where='fcm_key="'.$tokken.'"';

			$r = $this->Apimodel->check_fcm($where);

			if(sizeof($r)>0){

				$response=array('status'=>400,'message'=>'Token already exits already exists.' ,'Result'=>'not success');
				echo json_encode($response);
			}else{
				$where='fire_uid="'.$fire_Uid.'"';
				$info = $this->Apimodel->find_user_info($where);
				$data = array(
					'user_id'=>$info[0]->id,
					'fcm_key'=>$tokken
				);
				$user_id=$this->Apimodel->update_tokken($data);

				// this->firebase->send_notification();
				$response=array('status'=>200,'message'=>'Token updated sucessfuly','Result'=>"success");
				echo json_encode($response);
			}

		}

		public function update_password(){
			$old_password= $_REQUEST['old_password'];
			$new_password= $_REQUEST['new_password'];

			$fire_Uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			if(sizeof($r)>0){
				if (password_verify($old_password, $r[0]->password)) {
					$password = password_hash($new_password, PASSWORD_DEFAULT);

					$data = array(
						'password'=>$password
					);
					$user_id=$this->Apimodel->update_profile($where,$data);

					$response=array('status'=>200,'message'=>'Password updated sucessfuly');
				} else {
					$response=array('status'=>400,'message'=>'Password is not correct');
				}
			}else{
				$response=array('status'=>400,'message'=>'something went wrong');
			}
			echo json_encode($response);
		}
		public function login_info(){
			$email= $_REQUEST['email'];
			$password= $_REQUEST['password'];


			$where='email="'.$email.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'Database Error');
			if(sizeof($r)>0){
				if (password_verify($password, $r[0]->password))
					$response=array('status'=>200,'message'=>'Login Successful','Result'=>$r);
				else
					$response=array('status'=>400,'message'=>'username or password do not match');

			}else
			$response=array('status'=>400,'message'=>'username or password do not match');

			echo json_encode($response);
		}

		public function make_notification_seen(){
			$notification_id= $_REQUEST['notification_id'];
			$response=array('status'=>400,'message'=>'function called');
			$data = array(
				'seen'=>1
			);
			$where='id="'.$notification_id.'"';
			$user_id=$this->Apimodel->update_seen($where,$data);
			if($user_id>0){
				$response=array('status'=>200,'message'=>'successfull');
			}else{
				$response=array('status'=>400,'message'=>'something went wrong');
			}
			echo json_encode($response);
		}

		public function delete_single_notification(){
			$notification_id= $_REQUEST['notification_id'];
			$response=array('status'=>400,'message'=>'function called');
			$where='id="'.$notification_id.'"';
			$user_id=$this->Apimodel->remove_one_notification($where);
			if($user_id>0){
				$response=array('status'=>200,'message'=>'successfull');
			}else{
				$response=array('status'=>400,'message'=>'something went wrong');
			}
			echo json_encode($response);
		}


		public function delete_bill_details_data(){
			$bill_id= $_REQUEST['bill_details_id'];
			$response=array('status'=>400,'message'=>'function called');
			$user_id=$this->Apimodel->remove_bill_details_data($bill_id);
			if($user_id>0){
				$response=array('status'=>200,'message'=>'successfull');
			}else{
				$response=array('status'=>400,'message'=>'something went wrong');
			}
			echo json_encode($response);
		}


		public function get_bill_details(){
			$fire_Uid= $_REQUEST['fire_uid'];
			$month= $_REQUEST['month'];
			$year= $_REQUEST['year'];
			$limit= $_REQUEST['limit'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'wrong Session');
			if(sizeof($r)>0){
				$where='vendor_id="'.$r[0]->id.'" and MONTH(date)=('.$month.') AND YEAR(date)=('.$year.')';
				if($limit==="false"){
					$resultr=$this->Apimodel->get_bill_details_data_all($where,"false");
					$total=$this->Apimodel->find_total_bill_details_all($where,"false");

				}
				else{
					$resultr=$this->Apimodel->get_bill_details_data_all($where,"true");
					$total=$this->Apimodel->find_total_bill_details_all($where,"true");
				}
				$response=array('status'=>400,'message'=>'no data found');
				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','total'=>$total,'Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
				}
			}
			echo json_encode($response);
		}
		public function get_bill_details_total(){

			$fire_Uid= $_REQUEST['fire_uid'];
			$month= $_REQUEST['month'];
			$year= $_REQUEST['year'];
			$limit= $_REQUEST['limit'];
			$where='fire_uid="'.$fire_Uid.'"';
			// $where='fire_uid="'.$fire_Uid.'"and MONTH(date)=('.$month.') AND YEAR(date)=('.$year.')';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'wrong Session');
			$where='vendor_id="'.$r[0]->id.'" and MONTH(date)=('.$month.') AND YEAR(date)=('.$year.')';
			if(sizeof($r)>0){
				if($limit==="false")
					$resultr=$this->Apimodel->find_total_bill_details($where,"false");
				else
					$resultr=$this->Apimodel->find_total_bill_details($where,"true");
				$response=array('status'=>400,'message'=>'no data found');
				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','total'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches. Please try again.','Result'=>$resultr);
				}
			}
			echo json_encode($response);
		}
		public function get_merchant_monthly_payment(){
			$fire_Uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'wrong Session');

			if(sizeof($r)>0){
				$where='user_id ="'.$r[0]->id.'"';
				$resultr=$this->Apimodel->find_merchant_monthly_payment($where);
				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches. Please try again.');
				}
			}
			echo json_encode($response);
		}
		public function get_merchant_monthly_recieved(){
			$fire_Uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'wrong Session');

			if(sizeof($r)>0){
				$where='vendor_id ="'.$r[0]->id.'"';

				$sql = "SELECT YEAR(Date) AS Year,MONTH(Date) AS Month,SUM(amount) AS Total_amount, COUNT(DISTINCT bill_id) as Total_transaction FROM bills_details Right join bills_transaction on bills_details.bill_id=bills_transaction.bill_details_id WHERE ".$where." GROUP BY YEAR(Date),MONTH(Date)";

				$resultr=$this->Apimodel->search_data($sql);
				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches. Please try again.');
				}
			}
			echo json_encode($response);
		}
		public function get_vendor_transaction_details(){
			$fire_Uid= $_REQUEST['fire_uid'];
			$month= $_REQUEST['month'];
			$year= $_REQUEST['year'];
			$limit= $_REQUEST['limit'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'wrong Session');
			if(sizeof($r)>0){
				$where='user_id="'.$r[0]->id.'"';
				if($limit==="false")
					$resultr=$this->Apimodel->find_merchant_transaction_details($where,"false");
				else
					$resultr=$this->Apimodel->find_merchant_transaction_details($where,"true");
				$response=array('status'=>400,'message'=>'id is'.$r[0]->id);
				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.Please try again.','Result'=>$resultr);
				}
			}
			echo json_encode($response);
		}

		public function get_transaction_data(){
			$bill_id= $_REQUEST['bill_id'];
			$where='bill_details_id="'.$bill_id.'"';
			$r = $this->Apimodel->get_all_bill_transaction($where);
			$response=array('status'=>400,'message'=>'wrong Session');
			if(sizeof($r)>0){
				$response=array('status'=>200,'message'=>'data found','Result'=>$r);
			}
			echo json_encode($response);
		}

		public function get_carousel(){
			$r = $this->Apimodel->carousel();
			$response=array('status'=>400,'message'=>'something went wrong');
			if(sizeof($r)>0){
				$response=array('status'=>200,'Result'=>$r);
			}
			echo json_encode($response);
		}

		public function get_website_gallery(){
			$r = $this->Apimodel->get_website_gallery();
			$response=array('status'=>400,'message'=>'something went wrong');
			if(sizeof($r)>0){
				$response=array('status'=>200,'message'=>'data found','Result'=>$r);
			}
			echo json_encode($response);
		}

		public function get_general_data(){
			$r = $this->Apimodel->get_general_data();
			$response=array('status'=>400,'message'=>'something went wrong');
			if(sizeof($r)>0){
				$response=array('status'=>200,'message'=>'data found','Result'=>$r);
			}
			echo json_encode($response);
		}

		public function get_offer(){
			$r = $this->Apimodel->get_offer();
			$response=array('status'=>400,'message'=>'something went wrong');
			if(sizeof($r)>0){
				$response=array('status'=>200,'message'=>'data found','Result'=>$r);
			}
			echo json_encode($response);
		}

			public function get_social_media(){
			$r = $this->Apimodel->get_social_media();
			$response=array('status'=>400,'message'=>'something went wrong');
			if(sizeof($r)>0){
				$response=array('status'=>200,'message'=>'data found','Result'=>$r);
			}
			echo json_encode($response);
		}

		public function notificationList(){

			$fire_Uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_Uid.'"';
			$r = $this->Apimodel->find_user_info($where);
			$response=array('status'=>400,'message'=>'Something went wrong');
			if(sizeof($r)>0){
				$where='client_id IN ("'.$r[0]->id.'","0")';
				$resultr=$this->Apimodel->get_notification($where);
				$response=array('status'=>200,'message'=>'found','Result'=>$resultr);
			}
			else{
				$response=array('status'=>400,'message'=>'No date Found');
			}
			echo json_encode($response);
		}

		public function all_question(){
			$resultr=$this->Apimodel->all_question();

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}


		public function user_info(){
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$resultr=$this->Apimodel->find_user_info($where);
			$response=array('status'=>200,'message'=>'user info recived.','Result'=>$resultr);
			echo json_encode($response);
		}

		public function all_client_info(){
			$where='account_type="1"';
			$resultr=$this->Apimodel->find_user_info($where);


			$response=array('status'=>200,'message'=>'user info recived.','Result'=>$resultr);
			echo json_encode($response);
		}
		public function work_info(){
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);
			$where='w_user_id="'.$user_id[0]->id.'"';
			$resultr=$this->Apimodel->find_work_info($where);
			$response=array('status'=>200,'message'=> "successfull",'Result'=>$resultr);
			echo json_encode($response);
		}


		public function get_work_update(){
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);
			$where='user_id="'.$user_id[0]->id.'"';
			$resultr=$this->Apimodel->find_work_update_info($where);
			$response=array('status'=>200,'message'=> "successfull",'Result'=>$resultr);
			echo json_encode($response);
		}

		public function client_payment_info(){

			$fire_uid= $_REQUEST['fire_uid'];

			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);

			$where='cph_user_id="'.$user_id[0]->id.'"';
			$resultr=$this->Apimodel->find_client_payment_info($where);
			$response=array('status'=>200,'message'=> "successful ",'Result'=>$resultr);

			echo json_encode($response);
		}
		public function client_payment_history(){

			$fire_uid= $_REQUEST['fire_uid'];

			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);

			$where='cph_user_id="'.$user_id[0]->id.'"';
			$resultr=$this->Apimodel->find_client_payment_info($where);
			$response=array('status'=>200,'message'=> "successful ",'Result'=>$resultr);

			echo json_encode($response);
		}
		public function gallery_info(){

			$fire_uid= $_REQUEST['fire_uid'];

			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);

			$where='w_user_id="'.$user_id[0]->id.'"';
			$workInfo=$this->Apimodel->find_work_info($where);

			$where='g_work_id="'.$workInfo[0]->w_id.'"';
			$resultr=$this->Apimodel->find_gallery_info($where);
			$response=array('status'=>200,'message'=> "successfull " ,'Result'=>$resultr);

			echo json_encode($response);
		}

		public function get_work_progress(){
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);
			$where='w_user_id="'.$user_id[0]->id.'"';
			$workInfo=$this->Apimodel->find_work_info($where);

			$where='wp_work_id="'.$workInfo[0]->w_id.'"';
			$resultr=$this->Apimodel->find_work_progress_info($where);
			$response=array('status'=>200,'message'=> "successfull " ,'Result'=>$resultr);

			echo json_encode($response);
		}
		//updated api all in a single called
		public function get_client_home(){
			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);

			$where='id_user_id="'.$user_id[0]->id.'"';
			$installInfo=$this->Apimodel->find_installment_info($where);

			$where='cph_user_id="'.$user_id[0]->id.'"';
			$paid=$this->Apimodel->find_installment_paid($where);

		    $where='cph_user_id="'.$user_id[0]->id.'"';
			$paid_percent=$this->Apimodel->find_installment_paid_percent($where);

			$where='user_id="'.$user_id[0]->id.'"';
			$result_work_update=$this->Apimodel->find_work_update_info($where);

			$where='w_user_id="'.$user_id[0]->id.'"';
			$find_work_info_result=$this->Apimodel->find_work_info($where);

			$where='wp_work_id="'.$find_work_info_result[0]->w_id.'"';
			$ResultWorkProgressInfo=$this->Apimodel->find_work_progress_info($where);

			$response=array('status'=>200,
			'message'=> "successfull",
			'user_name'=>  $user_id[0]->fullname,
			'mentor_name'=>$find_work_info_result[0]->w_mentor_name,
			'mentor_phone'=>$find_work_info_result[0]->w_mentor_phone_num,
			'work_name'=>$find_work_info_result[0]->w_work_title,
			'work_percent_complete'=>$ResultWorkProgressInfo[0]->wp_percent_complete,
			'work_percent_complete'=>$ResultWorkProgressInfo[0]->wp_percent_complete,
			'total_paid'=>$paid[0]->total_paid,
			'total_paid_percent'=>round(($paid_percent[0]->total_paid/$paid_percent[0]->total_amt)*100,2),
			'total_installment'=>$installInfo[0]->id_total_installment,
			'ResultWorkUpdate'=>$result_work_update

		);
			echo json_encode($response);
		}

		public function get_installment_details(){

			$fire_uid= $_REQUEST['fire_uid'];

			$where='fire_uid="'.$fire_uid.'"';
			$user_id=$this->Apimodel->find_user_info($where);

			$where='id_user_id="'.$user_id[0]->id.'"';
			$installInfo=$this->Apimodel->find_installment_info($where);

			$where='cph_user_id="'.$user_id[0]->id.'"';
			$paid=$this->Apimodel->find_installment_paid($where);

			$response=array('status'=>200,'message'=> "successfull " ,'Result'=>$installInfo,'total_paid'=>$paid);

			echo json_encode($response);
		}



		public function update_profile(){


			$fire_uid= $_REQUEST['fire_uid'];
			$where='fire_uid="'.$fire_uid.'"';
			$resultr=$this->Apimodel->find_user_info($where);

			if(sizeof($resultr)>0){
				$user_id=$resultr[0]->id;
			}
			else{
				$response=array('status'=>400,'message'=>'User profile fail');
			}

			$fullname=$_REQUEST['fullname'];
			$email=$_REQUEST['email'];

			$data = array(
				'fullname'=>$fullname,
				'email'=>$email,
			);

			$where='id="'.$user_id.'" ';
			$user_id=$this->Apimodel->update_profile($where,$data);

			if($user_id > 0){
				$response=array('status'=>200,'message'=>'User profile update sucessfuly','User_id'=>(string)$user_id);
				echo json_encode($response);
			}else{
				$response=array('status'=>400,'message'=>'User profile fail');
				echo json_encode($response);
			}
		}



		public function bookSearch(){

			$query=$_REQUEST['query'];
			$where="e_book.b_title like '%$query%' or e_book.b_description like '%$query%' or e_author.a_title like '%$query%' or cat_name like '%$query%'";
			$resultr=$this->Apimodel->bookSearch($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function bookdetails(){

			$b_id=$_REQUEST['b_id'];
			$user_id=$_REQUEST['user_id'];
			if($user_id!=0){
				$where='b_id="'.$b_id.'"';
				$where_tra='t_fb_id="'.$b_id.'" AND t_user_id='.$user_id.' ';

				$resultr=$this->Apimodel->bookdetails($where);

				$resultr_tra=$this->Apimodel->transacation($where_tra);

				$rk=array();
				foreach($resultr as $ra){
					$avg=$this->Apimodel->avg_book_rating($ra->b_id);
					$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
					$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
					$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
					$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
					if($avg->average>0){
						$ra->avg_rating = $avg->average;
					}else{
						$ra->avg_rating = "0";
					}
					$rk[]= $ra;

					if(sizeof($resultr_tra)>0){
						$ra->is_paid="0";
					}
				}

				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
				}
				echo json_encode($response);
			}else{

				$where='b_id="'.$b_id.'"';

				$resultr=$this->Apimodel->bookdetails($where);

				foreach($resultr as $ra){
					$avg=$this->Apimodel->avg_book_rating($ra->b_id);
					$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
					$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
					if($avg->average>0){
						$ra->avg_rating = $avg->average;
					}else{
						$ra->avg_rating = "0";
					}
				}

				if(sizeof($resultr)>0){
					$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
				}else{
					$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
				}
				echo json_encode($response);
			}
		}

		public function popularbooklist(){
			$u_id=$_REQUEST['u_id'];
			$course_id = $this->get_courseId($u_id);
			$where='fc_id="'.$course_id.'"';

			$resultr=$this->Apimodel->popularbooklist($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function free_paid_booklist(){

			$where='is_paid="'.$_REQUEST['is_paid'].'" ';
			$resultr=$this->Apimodel->booklist_free_paid($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function related_item(){

			$b_id=$_REQUEST['fcat_id'];
			$where='fcat_id="'.$b_id.'" ';

			$resultr=$this->Apimodel->related_item($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function newarriaval(){
			$u_id=$_REQUEST['u_id'];
			$course_id = $this->get_courseId($u_id);
			$where='e_book.fc_id="'.$course_id.'"';

			$resultr=$this->Apimodel->newarrival($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function feature_item(){

			$u_id=$_REQUEST['u_id'];
			$course_id = $this->get_courseId($u_id);
			$where='e_book.is_feature="yes" and e_book.fc_id="'.$course_id.'"';
			$resultr=$this->Apimodel->featureitem($where);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}
				$rk[]= $ra;
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function add_view(){

			$user_id=$_REQUEST['b_id'];
			$add_point=1;

			$where='b_id="'.$user_id.'" ';

			$result_total=$this->Apimodel->view_cnt($where);

			if(!empty($result_total)){
				$points= $result_total[0]->readcnt;
				$a=$points+$add_point;

				$resultr=$this->Apimodel->update_view($where,$a);
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function add_download(){

			$b_id=$_REQUEST['b_id'];
			$user_id=$_REQUEST['user_id'];

			$add_point=1;

			$where='b_id="'.$b_id.'" ';

			$result_total=$this->Apimodel->view_cnt($where);

			if(!empty($result_total)){
				$points= $result_total[0]->download;
				$a=$points+$add_point;

				$resultr=$this->Apimodel->update_download($where,$a);
			}

			$where_down='bd_user_id='.$user_id.' and bd_b_id="'.$b_id.'"';

			$resultr_down=$this->Apimodel->bookdownload($where_down);

			$data = array(
				'bd_user_id'=>$user_id,
				'bd_b_id'=>$b_id,
				'bd_datetime'=>date('Y-m-d H:i:s')
			);

			if(sizeof($resultr_down)>0){
				$response=array('status'=>201,'message'=>'Already download');
			}else{
				$user_id=$this->Apimodel->add_download($data);
				$response=array('status'=>200,'message'=>'Download Success');
			}

			echo json_encode($response);
		}

		public function alldownload(){

			$user_id=$_REQUEST['user_id'];

			$where_tra='bd_user_id='.$user_id.' ';

			$resultr=$this->Apimodel->allbook();

			$resultr_con=$this->Apimodel->downloads($where_tra);

			$rk=array();
			foreach($resultr as $ra){
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;

				foreach($resultr_con as $racon){
					if($racon->bd_b_id == $ra->b_id){
						$rk[]= $ra;
					}
				}
			}

			if(sizeof($rk)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$rk);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>'');
			}
			echo json_encode($response);
		}

		public function add_comment(){

			$b_id=$_REQUEST['b_id'];
			$user_id=$_REQUEST['user_id'];
			$comment=$_REQUEST['comment'];

			$data = array(
				'b_id'=>$b_id,
				'comment'=>$comment,
				'user_id'=>$user_id,
				'c_status'=>'yes',
				'c_date'=>date('Y-m-d H:i:s')
			);

			$user_id=$this->Apimodel->add_comment($data);

			$response=array('status'=>200,'message'=>'Add comment sucessfuly','User_id'=>(string)$user_id);
			echo json_encode($response);
		}

		public function view_comment(){

			$b_id=$_REQUEST['b_id'];

			$where='b_id="'.$b_id.'"';

			$resultr=$this->Apimodel->view_comment($where);

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function add_purchase(){

			$b_id=$_REQUEST['fb_id'];
			$user_id=$_REQUEST['user_id'];
			$amount=$_REQUEST['amount'];
			$currency_code=$_REQUEST['currency_code'];
			$short_description=$_REQUEST['short_description'];
			$payment_id=$_REQUEST['payment_id'];
			$state=$_REQUEST['state'];
			$create_time=$_REQUEST['create_time'];

			$data = array(
				't_user_id'=>$user_id,
				't_fb_id'=>$b_id,
				't_currency_code'=>$currency_code,
				't_description'=>$short_description,
				't_payment_id'=>$payment_id,
				't_state'=>$state,
				't_amount'=>$amount,
				't_datetime'=>$create_time
			);

			$user_id=$this->Apimodel->purchase($data);

			$response=array('status'=>200,'message'=>'purchase sucessfuly','User_id'=>(string)$user_id);
			echo json_encode($response);
		}

		public function purchaselist(){

			$user_id=$_REQUEST['user_id'];

			$where_tra='t_user_id='.$user_id.' ';

			$resultr=$this->Apimodel->allbook();

			$resultr_con=$this->Apimodel->transacation($where_tra);

			$rk=array();
			foreach($resultr as $ra){
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
			// $rk[]= $ra;

				foreach($resultr_con as $racon){
					if($racon->t_fb_id == $ra->b_id){
						$rk[]= $ra;
					}
				}
			}

			if(sizeof($rk)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$rk);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$rk);
			}
			echo json_encode($response);
		}

		public function add_continue_read(){

			$user_id=$_REQUEST['user_id'];
			$b_id=$_REQUEST['b_id'];

			$data = array(
				'co_user_id'=>$user_id,
				'co_b_id'=>$b_id,
				'co_datetime'=>date('Y-m-d H:i:s')
			);

			$user_id=$this->Apimodel->add_continue_read($data);

			$response=array('status'=>200,'message'=>'Add sucessfuly','User_id'=>(string)$user_id);
			echo json_encode($response);
		}

		public function continue_read(){

			$user_id=$_REQUEST['user_id'];

			$where_tra='co_user_id='.$user_id.' ';

			$resultr=$this->Apimodel->allbook();

			$resultr_con=$this->Apimodel->continue_read($where_tra);

			$rk=array();
			foreach($resultr as $ra){
				$avg=$this->Apimodel->avg_book_rating($ra->b_id);
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;
				if($avg->average>0){
					$ra->avg_rating = $avg->average;
				}else{
					$ra->avg_rating = "0";
				}

				foreach($resultr_con as $racon){
					if($racon->co_b_id == $ra->b_id){
						$rk[]= $ra;
					}
				}
			}

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$rk);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr_tra);
			}
			echo json_encode($response);
		}

		public function add_bookmark(){

			$user_id=$_REQUEST['user_id'];
			$b_id=$_REQUEST['b_id'];

			$where_dele='bo_user_id='.$user_id.' and bo_b_id="'.$b_id.'"';

			$resultr_con=$this->Apimodel->bookmarks($where_dele);

			$data = array(
				'bo_user_id'=>$user_id,
				'bo_b_id'=>$b_id,
				'bo_datetime'=>date('Y-m-d H:i:s')
			);

			if(sizeof($resultr_con)>0){
				$user_id=$this->Apimodel->delete_bookmark($where_dele);
				$response=array('status'=>201,'message'=>'Bookmark Remove','User_id'=>(string)$user_id);
				echo json_encode($response);
			}else{
				$user_id=$this->Apimodel->add_bookmark($data);
				$response=array('status'=>200,'message'=>'Bookmark Success','User_id'=>(string)$user_id);
				echo json_encode($response);
			}
		}

		public function checkbookmark(){

			$user_id=$_REQUEST['user_id'];
			$b_id=$_REQUEST['b_id'];

			$where_check='bo_user_id='.$user_id.' and bo_b_id="'.$b_id.'"';

			$resultr_con=$this->Apimodel->bookmarks($where_check);

			if(sizeof($resultr_con)>0){
				$response=array('status'=>200,'message'=>'Book is already Bookmark','Result'=>"");
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>'');
			}
			echo json_encode($response);
		}

		public function delete_question(){

			$q_id=$_REQUEST['q_id'];

			$where='q_id="'.$q_id.'"';

			$resultr=$this->Apimodel->delete_questions($where);

			if($resultr>0){
				$response=array('status'=>200,'message'=>'delete Successfull','Result'=>"well done");
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>'');
			}
			echo json_encode($response);
		}
		public function delete_answer(){

			$a_id=$_REQUEST['a_id'];

			$where='a_id="'.$a_id.'"';

			$resultr=$this->Apimodel->delete_answers($where);

			if($resultr>0){
				$response=array('status'=>200,'message'=>'delete Successfull','Result'=>"well done");
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>'');
			}
			echo json_encode($response);
		}

		public function allBookmark(){

			$user_id=$_REQUEST['user_id'];

			$where_tra='bo_user_id='.$user_id.' ';

			$resultr=$this->Apimodel->allbook();

			$resultr_con=$this->Apimodel->bookmarks($where_tra);

			$rk=array();
			foreach($resultr as $ra){
				$ra->b_image=base_url().'assets/images/book/'.$ra->b_image;
				$ra->sample_b_url=base_url().'assets/images/book/'.$ra->sample_b_url;
				$ra->b_url=base_url().'assets/images/book/'.$ra->b_url;
				$ra->a_image=base_url().'assets/images/book/'.$ra->a_image;

				foreach($resultr_con as $racon){
					if($racon->bo_b_id == $ra->b_id){
						$rk[]= $ra;
					}
				}
			}

			if(sizeof($rk)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$rk);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>'');
			}
			echo json_encode($response);
		}


		public function general_setting(){

			$resultr=$this->Apimodel->genaral_setting();

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function userlist(){

			$resultr=$this->Apimodel->userlist();

			if(sizeof($resultr)>0){
				$response=array('status'=>200,'message'=>'Success','Result'=>$resultr);
			}else{
				$response=array('status'=>400,'message'=>'Sorry, we could not find any matches.<br>Please try again.','Result'=>$resultr);
			}
			echo json_encode($response);
		}

		public function give_rating(){
			$book_id = $_POST['book_id'];
			$user_id = $_POST['user_id'];
			$ratingData  = $_POST['rating'];
			$where   ='book_id="'.$book_id.'" and user_id="'.$user_id.'"';
			$rating = $this->Apimodel->get_book_rating($where);

			$data = array(
				'book_id' => $book_id,
				'user_id'=>$user_id,
				'rating'=>$ratingData);
			if(sizeof($rating)>0){
				$where ='rating_id="'.$rating[0]->rating_id.'"';
				$this->Apimodel->update_book_rating($where,$data);
			}else{
				$this->Apimodel->insert_book_rating($data);
			}
			$response=array('status'=>200,'message'=>'Success');
			echo json_encode($response);
		}
		public function update_question(){
			$question = $_POST['question'];
			$q_id = $_POST['q_id'];
			$data = array('question' => $question);
			$where ='q_id="'.$q_id.'"';
			$res =$this->Apimodel->update_questions($where,$data);
			$response=array('status'=>200,'message'=>$res);
			echo json_encode($response);
		}
		public function update_answer(){
			$answer = $_POST['answer'];
			$a_id = $_POST['a_id'];
			$data = array('answer' => $answer);
			$where ='a_id="'.$a_id.'"';
			$res =$this->Apimodel->update_answers($where,$data);
			$response=array('status'=>200,'message'=>$res);
			echo json_encode($response);
		}

	}
