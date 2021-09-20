<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load->library('session');
		$this->load->helper('url');
		$this->load->model('Adminmodel');
	}

	public function index(){
		if($this->session->userdata('id')) {
			$data['settinglist'] = $this->Adminmodel->settings_data();
			redirect(base_url().'index.php/admin/dashboard',$data);
		}else{
			$data['settinglist'] = $this->Adminmodel->settings_data();
			$this->load->view("admin/login",$data);
		}
	}

	public function adminlogin(){
		$email= $this->input->post('email');
		$password= $this->input->post('password');
		$where='password="'.$password.'" and email="'.$email.'"';
		$result = $this->Adminmodel->admin_varify($where);

		if(count($result) > 0) {
			$this->session->set_userdata('email',$result[0]->email);
			$this->session->set_userdata('id',$result[0]->id);
			$this->session->set_userdata('name',$result[0]->fullname);
			echo '100';
		} else {
			echo '200';
		}
	}

	public function logout(){
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('name');
		redirect(base_url().'index.php/login');
	}

	public function dashboard(){

		/*for all users*/
		$result = $this->Adminmodel->userlist();
		$data['totalUser']=sizeof($result);

		$where='account_type = 1';
		$result = $this->Adminmodel->totalClient($where);
		$data['totalClient']=sizeof($result);

		$where='account_type = 2';
		$result = $this->Adminmodel->totalVendor($where);
		$data['totalVendor']=sizeof($result);

		// Total Transaction today
		$result = $this->Adminmodel->todayTransaction();
		$data['totalTodayTransaction']=sizeof($result);



		$this->load->view("admin/dashboard", $data);

	}

	/*======================Category=============================*/

	public function categorylist(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['categorydata'] = $this->Adminmodel->category_list();
		$this->load->view("admin/categorylist",$data);
	}


	public function courselist(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['coursedata'] = $this->Adminmodel->course_list();
		$this->load->view("admin/courselist",$data);
	}
	public function semlist(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['semdata'] = $this->Adminmodel->sem_list();
		$this->load->view("admin/semlist",$data);
	}
	public function view_details_installment(){
		$client_id=$_GET['id'];
		$data['client_id'] =$client_id;

		$data['settinglist'] = $this->Adminmodel->settings_data();

		$where='id="'.$client_id.'"';
		$data['user'] = $this->Adminmodel->find_user($where);

		$where='cph_user_id="'.$client_id.'"';
		$data['details'] = $this->Adminmodel->get_installment_details($where);

		$where='id_user_id="'.$client_id.'"';
		$data['total_amount'] = $this->Adminmodel->get_installment_total_amount($where);

		$this->load->view("admin/viewDetailsInstallment",$data);
	}

	public function addcategory(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/addcategory",$data);
	}
	public function edit_details_installment(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$id=$_GET['id'];
		$id_id=$_GET['id_id'];
		$client_id=$_GET['c_id'];
		$where='id="'.$client_id.'"';
		$data['user'] = $this->Adminmodel->find_user($where);
		$data['project_name'] = $this->Adminmodel->get_work_name($id);
		$data['installment_details'] = $this->Adminmodel->get_id_amount($id_id);

		$this->load->view("admin/editDetailsInstallment",$data);
	}
	public function add_installment_record(){
		$client_id=$_GET['id'];
		$data['client_id'] =$client_id;

		$where='id="'.$client_id.'"';
		$data['user'] = $this->Adminmodel->find_user($where);


		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/addInstallmentRecord",$data);
	}

	public function addcourse(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/addcourse",$data);
	}

	public function savecategory(){
		$category_name=$_POST['category_name'];

		$category_image=$this->imageupload($_FILES['category_image'],'category_image', FCPATH . 'assets/images/category');

		$data = array(
			'cat_name' => $category_name,
			'cat_image' => $category_image,
			'cat_date'=>date('Y-m-d h:i:s'),
			'cat_status'=>'enable'
		);

		$cat_id=$this->Adminmodel->add_category($data);

		if($cat_id){
			$res=array('status'=>'200','msg'=>'New Category Create.','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	public function savecourse(){
		$course_name=$_POST['course_name'];
		$data = array(
			'course_name' => $course_name,
			'course_date'=>date('Y-m-d h:i:s'),
			'course_status'=>'enable'
		);

		$course_id=$this->Adminmodel->add_course($data);

		if($course_id){
			$res=array('status'=>'200','msg'=>'New Course Created.','id'=>$course_id);
			echo json_encode($res);
			exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}

	public function saveInstallmentRecords(){
		$input_title=$_POST['input_title'];
		$id=$_POST['client_id'];
		$input_amt=$_POST['input_amt'];

		$data = array(

			'cph_user_id' => $id,
			'cph_title'=>$input_title,
			'cph_paid_amt'=>$input_amt
		);

		$status=$this->Adminmodel->add_data($data,"client_payment_history");

		if($status){
			$res=array('status'=>'200','msg'=>'New Record Created.','id'=>$status);
			echo json_encode($res);
			exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}


	public function saveInstallment(){
		$select_user=$_POST['select_user'];
		$total_amt=$_POST['total_amt'];
		$total_installment=$_POST['total_installment'];
		//to check if the record already exist
		$check_status=1;
		$check_id=$this->Adminmodel->check_installment();
		foreach($check_id as $id ){
			if( $id->id_user_id===$select_user)
			$check_status=0;
		}
		// to check if the work of the given client is available
		$check_work_id=1;
		$check_work=$this->Adminmodel->check_work();
		foreach($check_work as $id ){
			if( $id->w_user_id===$select_user)
			$check_work_id=1;
		}
		if($check_status===1){
			// previous record not found
			if ($check_work_id===1) {
				// work details found

				// saving data to database
				$data = array(
					'id_user_id'	=>$select_user ,
					'id_total_amt'	=>$total_amt ,
					'id_total_installment'	=>$total_installment
				);
				$status=$this->Adminmodel->addInstallment($data);
				if($status){
					$res=array('status'=>'200','msg'=>'New Installment Created.','id'=>$status);
					echo json_encode($res);
					exit;
				}else{
					$res=array('status'=>'400','msg'=>'fail');
					echo json_encode($res);
					exit;
				}
			}else {
				$res=array('status'=>'200','msg'=>'Please Add work first');
				echo json_encode($res);
				exit;
			}
		}
		else {
			$res=array('status'=>'200','msg'=>'user have already created installment details');
			echo json_encode($res);
			exit;

		}
	}
	public function editcategory(){
		$id=$_GET['id'];
		$where='cat_id="'.$id.'"';
		$data['category'] = $this->Adminmodel->get_category($where);
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/editCategory",$data);
	}
	public function editWork(){
		$id=$_GET['id'];
		$where=' w_id="'.$id.'"';
		$data['list'] = $this->Adminmodel->get_work_data($id);
		$this->load->view("admin/editWork",$data);
	}
	public function editcourse(){
		$id=$_GET['id'];
		$where='course_id="'.$id.'"';
		$data['course'] = $this->Adminmodel->get_course($where);
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/editcourse",$data);
	}

	public function updatecategory(){
		$category_name=$_POST['category_name'];

		if (isset($_FILES['category_image']) && !empty($_FILES['category_image']['name'])) {

			$CatImage=$this->imageupload($_FILES['category_image'],'category_image', FCPATH . 'assets/images/category');
		}else{
			$CatImage=$_POST['categoryimage'];
		}
		$id=$_POST['id'];
		$data = array(
			'cat_name' => $category_name,
			'cat_image' => $CatImage,
			'cat_date'=>date('Y-m-d h:i:s')
		);
		$cat_id=$this->Adminmodel->update_status_category($id,$data);
		if($cat_id){
			$res=array('status'=>'200','msg'=>'Update category success','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	public function updateInstallment(){
		$select_user=$_POST['id'];
		$total_amt=$_POST['total_amt'];
		$total_installment=$_POST['total_installment'];
		$select_work=$_POST['w_id'];
		$id_id=$_POST['id_id'];

		$data = array(
			'id_user_id'	=>$select_user,
			'id_total_amt'	=>$total_amt,
			'id_total_installment'	=>$total_installment ,
			'id_work_id'	=>$select_work
		);

		$cat_id=$this->Adminmodel->update_Installment($data,$id_id);
		if($cat_id){
			$res=array('status'=>'200','msg'=>'Update category success','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	public function updateWork(){

		$title=$_POST['title'];
		$start_date=$_POST['start_date'];
		$dead_line=$_POST['dead_line'];
		$id=$_POST['id'];

		$data = array(
			' w_work_title '=>$title,
			'  w_start_date '=>$start_date,
			' w_dead_line '=>$dead_line
				);
		$res_id=	$this->Adminmodel->update_Work($data,$id);
		if($res_id){
			$res=array('status'=>'200','msg'=>' successfully added.');
			echo json_encode($res);
			exit;
		}else{
			$res=array('status'=>'400','msg'=>'failed');
			echo json_encode($res);
			exit;
		}
	}

	public function updatecourse(){
		$category_name=$_POST['course_name'];

		$id=$_POST['id'];
		$data = array(
			'course_name' => $category_name,
			'course_date'=>date('Y-m-d h:i:s')
		);
		$cat_id=$this->Adminmodel->update_status_course($id,$data);
		if($cat_id){
			$res=array('status'=>'200','msg'=>'Update category success','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	/*======================End Category=============================*/


	/*======================Question=============================*/

	public function questionslist(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['questiondata'] = $this->Adminmodel->question_list();
		$this->load->view("admin/questionslist",$data);
	}
	public function test(){

		$this->load->view("admin/test/testfile");
	}



	public function addquestion(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['courselist'] = $this->Adminmodel->course_list();

		$this->load->view("admin/addquestion",$data);
	}


	public function savequestion(){
		$question=$_POST['question'];
		$course_id=$_POST['input_course'];
		$data = array(
			'question' => $question,
			'status'=>'enable',
			'user_id'=>'1',
			'course_id'=>$course_id

		);

		$q_id=$this->Adminmodel->add_question($data);

		if($q_id){
			$res=array('status'=>'200','msg'=>'New question created.','id'=>$q_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}


	public function editquestion(){
		$id=$_GET['id'];
		$where='cat_id="'.$id.'"';
		$data['category'] = $this->Adminmodel->get_category($where);
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/editCategory",$data);
	}


	public function updatequestion(){
		$category_name=$_POST['category_name'];

		if (isset($_FILES['category_image']) && !empty($_FILES['category_image']['name'])) {

			$CatImage=$this->imageupload($_FILES['category_image'],'category_image', FCPATH . 'assets/images/category');
		}else{
			$CatImage=$_POST['categoryimage'];
		}
		$id=$_POST['id'];
		$data = array(
			'cat_name' => $category_name,
			'cat_image' => $CatImage,
			'cat_date'=>date('Y-m-d h:i:s')
		);
		$cat_id=$this->Adminmodel->update_status_category($id,$data);
		if($cat_id){
			$res=array('status'=>'200','msg'=>'Update category success','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	/*======================End Question=============================*/


	/*====================== Users =============================*/

	public function adduser(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['courselist'] = $this->Adminmodel->course_list();
		$this->load->view("admin/addUser",$data);
	}
	public function addwork(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlistClient();
		$this->load->view("admin/addWork",$data);
	}
	public function addworkprogress(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['workList'] = $this->Adminmodel->workList();
		$this->load->view("admin/addWorkProgress",$data);
	}

	public function addworkUpdate(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlistClient();
		$this->load->view("admin/addWorkUpdate",$data);
	}

	public function saveuser(){
		$input_name = $_POST['input_name'];
		$input_email = $_POST['input_email'];
		$input_account_type = $_POST['input_account_type'];
		$input_password = $_POST['input_password'];

		$where='email="'.$input_email.'"';
		$userlist= $this->Adminmodel->userlist_by_where($where);

		if(sizeof($userlist)>0){
			$res=array('status'=>'400','msg'=>'User already exits');
			echo json_encode($res);
			exit;
		}else{
			$data = array(
				'fullname' => $input_name,
				'email' => $input_email,
				'password' => password_hash($input_password,PASSWORD_DEFAULT),
				'account_type' => $input_account_type,
			);

			$res_id=$this->Adminmodel->add_user($data);

			if($res_id){
				$res=array('status'=>'200','msg'=>'New user added Sucessfully',
				'id'=>$res_id);
				echo json_encode($res);
			}else{
				$res=array('status'=>'400','msg'=>'Please try again');
				echo json_encode($res);
			}
		}
	}
	public function userlist(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlist();
		$this->load->view("admin/userList",$data);
	}
	public function userSuggest(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['reportList'] = $this->Adminmodel->reportList();
		$this->load->view("admin/userSuggest",$data);
	}
	public function workList(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['Worklist'] = $this->Adminmodel->workListWithClient();
		$this->load->view("admin/workList",$data);
	}

	//today edit
	public function workProgress(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['Worklist'] = $this->Adminmodel->workProgressList();
		$this->load->view("admin/workProgress",$data);
	}
	public function workUpdates(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['workUpdateList'] = $this->Adminmodel->workUpdateList();
		$this->load->view("admin/workUpdates",$data);
	}

	public function userListClient(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlistClient();
		$this->load->view("admin/userList",$data);
	}
	public function userlistVendor(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlistVendor();
		$this->load->view("admin/userList",$data);
	}
	public function vendorPayment(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['vlist'] = $this->Adminmodel->vendor_payment_list();
		$this->load->view("admin/vendor/vendorPayment",$data);
	}
	public function vendorPaymentAdd(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userlist'] = $this->Adminmodel->userlistVendor();
		$this->load->view("admin/vendor/vendorPaymentAdd",$data);
	}
	public function billsDetails(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['billsDetailsList'] = $this->Adminmodel->billsDetailsList();
		$this->load->view("admin/vendor/bills/billsDetails",$data);
	}
	public function billsTransaction(){
		$data['settinglist'] = $this->Adminmodel->settings_data();

		$date=$_GET['date_given'];
		$data['date'] =$date;
		$id=$_GET['id'];
		$data['user_id'] =$id;

		$bill_id=$_GET['bill_id'];
		$where='bill_details_id="'.$bill_id.'"';
		$data['tlist'] = $this->Adminmodel->transactionDetails($where);
		$this->load->view("admin/vendor/bills/billsTransaction",$data);
	}
	public function notifyUser(){
		$data['settinglist'] = $this->Adminmodel->settings_data();

		$date=$_GET['date_given'];
		$data['date'] =$date;

		$id=$_GET['id'];
		$where='id="'.$id.'"';
		$data['userlist'] = $this->Adminmodel->userlistbywhere($where);
		$this->load->view("admin/notifyUser",$data);
	}
	public function vendorPaymentSave(){
			$currency=$_POST['currency'];
			$amount=$_POST['amount'];
			$user_id=$_POST['select_vendor_id'];
			$data = array(
				'amount'=>$amount,
				'user_id'=>$user_id,
				'currency'=>$currency
			);
			$res_id=	$this->Adminmodel->add_data($data,'vendor_payment');
			if($res_id){
				$res=array('status'=>'200','msg'=>'successfully inserted.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			}

	public function edituser(){
		$id=$_GET['id'];

		$where='id="'.$id.'"';
		$data['userlist'] = $this->Adminmodel->userlistbywhere($where);
		$this->load->view("admin/editUser",$data);
	}

	public function editWorkProgress(){
		$id=$_GET['id'];
		$data['list'] = $this->Adminmodel->editProgressList($id);
		$this->load->view("admin/editWorkProgress",$data);
	}

	public function updateWorkProgress(){
		$title=$_POST['title'];
		$description=$_POST['description'];
		$complete_percent=$_POST['complete_percent'];
		$id=$_POST['id'];


		$data = array(
			' wp_title '=>$title,
			'  wp_desc'=>$description,
			' wp_percent_complete'=>$complete_percent,
		);
		$res_id=	$this->Adminmodel->update_data("work_progress",'wp_id',$id,$data);
		if($res_id){

			$res=array('status'=>'200','msg'=>'successfully added.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}

	public function updateuser(){
		$user_name=$_POST['user_name'];
		$user_email=$_POST['user_email'];
		$user_password=$_POST['user_password'];
		$user_number=$_POST['user_number'];
		$id=$_POST['id'];

		$data = array(
			'fullname' => $user_name,
			'email' => $user_email,
			'password' => $user_password,
			'mobile_number' => $user_number,
			'c_date'=>date('Y-m-d h:i:s')
		);

		$cat_id=$this->Adminmodel->update_user($data,$id);
		if($cat_id){
			$res=array('status'=>'200','msg'=>'Sucessfully updated','id'=>$cat_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'failed','id'=>$cat_id);
			echo json_encode($res);exit;
		}
	}


	/*======================End Users=============================*/


	/*==========================Authors==========================*/

	public function authorlist(){
		$data['authorlist'] = $this->Adminmodel->authorall();
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/authorlist",$data);
	}

	public function addauthor(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['courselist'] = $this->Adminmodel->course_list();
		$this->load->view("admin/addauthor",$data);
	}

	public function saveauthor(){
		$input_name = $_POST['input_name'];
		$input_description = $_POST['input_description'];
		$input_address = $_POST['input_address'];
		$b_status = "enable";

		$image=$this->imageupload($_FILES['input_profile'],'input_profile', FCPATH . 'assets/images/author');

		$data = array(
			'a_title' => $input_name,
			'a_address' => $input_address,
			'a_bio' => $input_description,
			'a_image' => $image,
			'a_status' => $b_status
		);

		$res_id=$this->Adminmodel->add_author($data);

		if($res_id){
			$res=array('status'=>'200','msg'=>'Author added successfully.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}
public function saveGeneralData(){
		$g_id = $_POST['id'];
		$input_title = $_POST['input_title'];
		$input_description = $_POST['input_description'];
		$input_address = $_POST['input_address'];

		$data = array(
			'g_title' => $input_title,
			'g_desc' => $input_description,
			'g_url' => $input_address,
		);
		$res_id=$this->Adminmodel->update_data("general_data","g_id",$g_id,$data);

		if($res_id){
			$res=array('status'=>'200','msg'=>'Author added successfully.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	public function editauthor(){

		$id=$_GET['a_id'];
		$where='a_id="'.$id.'"';
		$data['authorlist'] = $this->Adminmodel->author_by_id($where);
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['courselist'] = $this->Adminmodel->course_list();
		$this->load->view("admin/editauthor",$data);
	}

	public function updateauthor(){
		$name=$_POST['input_name'];
		$description=$_POST['input_description'];
		$input_address = $_POST['input_address'];

		if (isset($_FILES['input_profile']) && !empty($_FILES['input_profile']['name'])) {
			$authorimage=$this->imageupload($_FILES['input_profile'],'input_profile', FCPATH . 'assets/images/author');
		}else{
			$authorimage=$_POST['inputprofile'];
		}

		$id=$_POST['id'];
		$data = array(
			'a_title' => $name,
			'a_address' => $input_address,
			'a_image' => $authorimage,
			'a_bio' => $description
		);

		$res_id=$this->Adminmodel->update_author($id,$data);

		if($res_id){
			$res=array('status'=>'200','msg'=>'Author added successfully.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	/*============================Books===================================*/

	public function booklist(){
		$data['bookslist'] = $this->Adminmodel->booksall();
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/booklist",$data);
	}

	public function addbook(){
		$data['booklist'] = $this->Adminmodel->booksall();
		$data['authorlist'] = $this->Adminmodel->authorall();
		$data['categorylist'] = $this->Adminmodel->category_list();
		$data['courselist'] = $this->Adminmodel->course_list();
		$data['semlist'] = $this->Adminmodel->sem_list();
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/addbook",$data);
	}

	public function savebook(){
		$input_name = $_POST['input_name'];
		$input_course = $_POST['select_course'];
		$input_sem = $_POST['select_Sem'];
		$input_description = $_POST['input_description'];
		$input_price = $_POST['input_price'];
		$select_category = $_POST['select_category'];
		$select_author = $_POST['select_author'];
		$select_cost = $_POST['select_cost'];
		$is_feature = "yes";
		$b_status = "enable";
		$fa_id = $_POST['select_author'];

		$input_bookcover=$this->imageupload($_FILES['input_bookcover'],'input_bookcover', FCPATH . 'assets/images/book');

		if (isset($_FILES['input_full_book']) && !empty($_FILES['input_full_book']['name'])) {
			$input_full_book=$this->fileupload($_FILES['input_full_book'],'input_full_book', FCPATH . 'assets/images/book');
		}

		$data = array(
			'b_title' => $input_name,
			'fc_id' => $input_course,
			'fs_id' => $input_sem,
			'b_description' => $input_description,
			'b_url' => $input_full_book,
			'fcat_id'=> $select_category,
			'b_image' => $input_bookcover,
			'is_feature' => $is_feature,
			'b_status' => $b_status,
			'fa_id' => $fa_id,
			'b_date' => date('Y-m-d h:i:s')
		);

		$res_id=$this->Adminmodel->add_book($data);

		if($res_id){
			$res=array('status'=>'200','msg'=>'  successfully added.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);exit;
		}
	}

	public function editbook(){
		$id=$_GET['b_id'];
		$data['categorylist'] = $this->Adminmodel->category_list();
		$data['courselist'] = $this->Adminmodel->course_list();
		$data['semlist'] = $this->Adminmodel->sem_list();

		$where='b_id="'.$id.'"';

		$data['booklist'] = $this->Adminmodel->books_by_id($where);
		$data['authorlist'] = $this->Adminmodel->authorall();
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/editbook",$data);
	}

	public function update_book(){
		$id = $_POST['id'];
		$input_name = $_POST['input_name'];
		$input_course = $_POST['select_course'];
		$input_sem = $_POST['select_Sem'];
		$input_description = $_POST['input_description'];
		$input_price = $_POST['input_price'];
		$select_category = $_POST['select_category'];
		$select_author = $_POST['select_author'];
		$select_cost = $_POST['select_cost'];
		$is_feature = "yes";
		$b_status = "enable";
		$fa_id = $_POST['select_author'];

		if (isset($_FILES['input_bookcover']) && !empty($_FILES['input_bookcover']['name'])) {
			$BookCoverImage=$this->imageupload($_FILES['input_bookcover'],'input_bookcover', FCPATH . 'assets/images/book');
		}else{
			$BookCoverImage=$_POST['inputbookcover'];
		}

		if (isset($_FILES['input_sample_book']) && !empty($_FILES['input_sample_book']['name'])) {
			$SampleBook=$this->fileupload($_FILES['input_sample_book'],'input_sample_book', FCPATH . 'assets/images/book');
		}else{
			$SampleBook=$_POST['inputsamplebook'];
		}

		if (isset($_FILES['input_full_book']) && !empty($_FILES['input_full_book']['name'])) {
			$FullBook=$this->fileupload($_FILES['input_full_book'],'input_full_book', FCPATH . 'assets/images/book');
		}else{
			$FullBook=$_POST['inputfullbook'];
		}

		$data = array(
			'b_title' => $input_name,
			'b_description' => $input_description,
			'fc_id' => $input_course,
			'fs_id' => $input_sem,
			'is_paid' => $select_cost,
			'sample_b_url' => $SampleBook,
			'b_url' => $FullBook,
			'b_price' => $input_price,
			'fcat_id'=> $select_category,
			'b_image' =>$BookCoverImage,
			'is_feature' => $is_feature,
			'b_status' => $b_status,
			'fa_id' => $fa_id,
			'b_date' => date('Y-m-d h:i:s')
		);

		$res_id=$this->Adminmodel->update_book($data,$id);

		if($res_id){
			$res=array('status'=>'200','msg'=>'  successfully added.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'Please try again');
			echo json_encode($res);exit;
		}
	}

	/*============================End Book===================================*/

	public function settingpage(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$where='id="'.$this->session->userdata('id').'"';
		$admin = $this->Adminmodel->admin_varify($where);
		$data['admin'] = $admin[0];
		$this->load->view("admin/settings",$data);
	}

	public function carouselPage(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['cList'] = $this->Adminmodel->carousel();
	
		$this->load->view("admin/carousel",$data);
	}

	public function socialMedia(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['sm_list'] = $this->Adminmodel->get_all_data("social_media");
		$this->load->view("admin/socialMedia",$data);
	}

	public function siteGallery(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['wg_list'] = $this->Adminmodel->get_all_data("website_gallery");
		$this->load->view("admin/siteGallery",$data);
	}

	public function offer(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['cList'] = $this->Adminmodel->get_all_data("offer");
	
		$this->load->view("admin/offerPage",$data);
	}

	public function update_text(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['g_text'] = $this->Adminmodel->update_text_data();
		$this->load->view("admin/update_text",$data);
	}

	public function savesetting(){
		$app_name=$_POST['app_name'];
		$app_image_logo=$_FILES['app_image']['name'];
		$app_desc=$_POST['app_desc'];
		$app_privacy=$_POST['app_privacy'];
		$host_email=$_POST['host_email'];

		$app_author=$_POST['app_author'];
		$host_contact=$_POST['host_contact'];
		$host_website=$_POST['host_website'];

		if (isset($_FILES['app_image']) && !empty($_FILES['app_image']['name'])) {
			$config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => FCPATH . 'assets/images/app'
			);
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload('app_image');

			$data3 = array(
				'value' => $app_image_logo,
			);
			// $where3='key=';
			$this->Adminmodel->update_general_setting($data3,'app_logo');

		}

		$data = array(
			'value' => $host_email,
		);
		// $where='key="host_email"';
		$this->Adminmodel->update_general_setting($data,'host_email');

		$data1 = array(
			'value' => $app_desc,
		);
		//$where='key="app_desripation"';
		$this->Adminmodel->update_general_setting($data1,'app_desripation');

		$data2 = array(
			'value' => $app_name,
		);
		$this->Adminmodel->update_general_setting($data2,'app_name');


		$data_author = array(
			'value' => $app_author,
		);
		$this->Adminmodel->update_general_setting($data_author,'Author');

		$data_contact = array(
			'value' => $host_contact,
		);
		$this->Adminmodel->update_general_setting($data_contact,'contact');

		$data_priv = array(
			'value' => $app_privacy,
		);
		$this->Adminmodel->update_general_setting($data_priv,'privacy_policy');

		$data_website = array(
			'value' => $host_website,
		);
		$res_id=$this->Adminmodel->update_general_setting($data_website,'website');

		if($res_id){
			$res=array('status'=>'200','msg'=>'Sucessfully updated','id'=>$res_id);
			echo json_encode($res);
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
		}

	}

	public function delete_record(){
		$id=$_POST['id'];
		$tablename=$_POST['tablename'];
		if($tablename=='gallery'){
			$this->Adminmodel->delete_gallery($id);
		}elseif ($tablename=='category') {
			$this->Adminmodel->delete_category($id);
		}elseif ($tablename=='author') {
			$this->Adminmodel->delete_author($id);
		}elseif ($tablename=='course') {
			$this->Adminmodel->delete_course($id);
		}elseif ($tablename=='question') {
			$this->Adminmodel->delete_question($id);
		}elseif ($tablename=='work') {
			$this->Adminmodel->delete_work($id);
		}elseif ($tablename=='installment_details') {
			$this->Adminmodel->delete_installment_details($id);
		}
		elseif ($tablename=='client_payment_history') {
			$this->Adminmodel->delete_client_payment_history($id);
		}
		elseif ($tablename=='work_updates') {
			$this->Adminmodel->delete_work_updates($id);
		}
		elseif ($tablename=='work_progress') {
			$this->Adminmodel->delete_work_progress($id);
		}
		elseif ($tablename=='vendor_payment') {
			$this->Adminmodel->delete_vendor_payment($id);
		}elseif ($tablename=='carousel') {
			$this->Adminmodel->delete_Carousel($id);
		}elseif ($tablename=='offer') {
			$this->Adminmodel->delete_offer($id);
		}
		elseif ($tablename=='website_gallery') {
			$this->Adminmodel->delete_website_gallery($id);
		}
		elseif ($tablename=='social_media') {
			$this->Adminmodel->social_media_data($id);
		}
		return true;
	}

	public function notification(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['userList'] = $this->Adminmodel->userlist();
		$this->load->view("admin/notification",$data);
	}
	public function addSocialLink(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$this->load->view("admin/addSocialLink.php",$data);
	}
	public function gallery(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['glist'] = $this->Adminmodel->galleryList();
		$data['wlist'] = $this->Adminmodel->workList();
		$this->load->view("admin/gallery",$data);
	}
	public function InstallmentDetails(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$data['installmentInfo'] = $this->Adminmodel->clientPaymentInfo();
		$this->load->view("admin/InstallmentDetails",$data);
	}

	public function addInstallment(){
		$data['settinglist'] = $this->Adminmodel->settings_data();
		$where='account_type = 1';
		$data['clientList'] = $this->Adminmodel->totalClient($where);
		$data['workList'] = $this->Adminmodel-> workList();
		$this->load->view("admin/addInstallment",$data);
	}
	public function eachInstallmentDetails(){
		$select_user=$_POST['select_user'];
		$data['clientList'] = $this->Adminmodel->totalClient($where);
		$data['transactionDetais'] = $this->Adminmodel->clientTransactionDetais($select_user);
		$data['installmentInfo'] = $this->Adminmodel->clientPaymentInfo($select_user);
		$this->load->view("admin/InstallmentDetails",$data);
	}

	public function save_admob(){
		$publisher_id=$_POST['publisher_id'];
		$banner_ad=$_POST['banner_ad'];
		$banner_ad_id=$_POST['banner_ad_id'];
		$interstital_ad=$_POST['interstital_ad'];
		$interstital_adid=$_POST['interstital_adid'];
		$interstital_adid_click=$_POST['interstital_adid_click'];
		$custom_ad=$_POST['custom_ad'];
		$data3 = array(
			'value' => $publisher_id,
		);
		// $where3='key=';
		$this->Adminmodel->update_general_setting($data3,'publisher_id');

		$data = array(
			'value' => $banner_ad,
		);
		// $where='key="host_email"';
		$this->Adminmodel->update_general_setting($data,'banner_ad');

		$data1 = array(
			'value' => $banner_ad_id,
		);
		//$where='key="app_desripation"';
		$this->Adminmodel->update_general_setting($data1,'banner_adid');

		$data2 = array(
			'value' => $interstital_ad,
		);
		// $where2='key="app_name"';
		$this->Adminmodel->update_general_setting($data2,'interstital_ad');

		$data5 = array(
			'value' => $interstital_adid,
		);
		// $where2='key="app_name"';
		$this->Adminmodel->update_general_setting($data5,'interstital_adid');

		$data4 = array(
			'value' => $interstital_adid_click,
		);
		// $where2='key="app_name"';
		$this->Adminmodel->update_general_setting($data4,'interstital_adid_click');

		$data_custom_ads = array(
			'value' => $custom_ad,
		);
		$this->Adminmodel->update_general_setting($data_custom_ads,'custom_ads');

		if (isset($_FILES['app_image1']) && !empty($_FILES['app_image1']['name'])) {
			$BookCoverImage=$this->imageupload($_FILES['app_image1'],'app_image1', FCPATH . 'assets/images/app');
		}else{
			$BookCoverImage=$this->imageupload($_FILES['app_image_logo1'],'app_image_logo1', FCPATH . 'assets/images/app');
		}

		$data3 = array(
			'value' => $BookCoverImage,
		);
		$this->Adminmodel->update_general_setting($data3,'custom_image');
	}

	public function save_signal_noti(){
		$one_signal=$_POST['one_signal'];
		$rest_key=$_POST['rest_key'];

		$data = array(
			'value' => $one_signal,
		);
		// $where='key="host_email"';
		$this->Adminmodel->update_general_setting($data,'onesignal_apid');
		$data1 = array(
			'value' => $rest_key,
		);
		//$where='key="app_desripation"';
		$this->Adminmodel->update_general_setting($data1,'onesignal_rest_key');
	}

	public function saveWork(){
		$title=$_POST['title'];
		$start_date=$_POST['start_date'];
		$w_mentor_name=$_POST['m_name'];
		$w_mentor_phone_num=$_POST['m_phone'];
		$dead_line=$_POST['dead_line'];
		$user_id=$_POST['user_id'];

		$data = array(
			' w_work_title '=>$title,
			'  w_start_date '=>$start_date,
			' w_dead_line '=>$dead_line,
			' w_mentor_name '=>$w_mentor_name,
			' w_mentor_phone_num '=>$w_mentor_phone_num,
			' w_user_id '=>$user_id
		);
		$res_id=	$this->Adminmodel->add_data($data,'work');
		if($res_id){

			$res=array('status'=>'200','msg'=>' successfully added.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}

	public function saveWorkProgress(){
		$title=$_POST['title'];
		$description=$_POST['description'];
		$complete_percent=$_POST['complete_percent'];
		$work_id=$_POST['work_id'];

		$data = array(
			' wp_title '=>$title,
			'  wp_desc'=>$description,
			' wp_percent_complete'=>$complete_percent,
			' wp_work_id '=>$work_id
		);
		$res_id=	$this->Adminmodel->add_data($data,'work_progress');
		if($res_id){

			$res=array('status'=>'200','msg'=>'successfully added.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}

	public function saveWorkupdate(){
		$title=$_POST['title'];
		$user_id=$_POST['user_id'];

		$data = array(
			'u_title'=>$title,
			'user_id'=>$user_id,
			'status'=>'enable'
		);
		$res_id=	$this->Adminmodel->add_data($data,'work_updates');
		if($res_id){
			$res=array('status'=>'200','msg'=>'successfully inserted.','id'=>$res_id);
			echo json_encode($res);exit;
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
			exit;
		}
	}
	public function saveGalary(){
		//  uploading the file
		$config['upload_path']          =  APPPATH .'../assets/images/gallery/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$basename = md5(date('H:i:s:u')).$_FILES['userfile']['name'];

		if(move_uploaded_file($_FILES['userfile']['tmp_name'],$config['upload_path'].$basename)){
			// inter record in the table
			$title=$_POST['title'];
			$work_id=$_POST['select_user'];
			$data = array(
				'g_title'=>$title,
				'g_url'=>$basename,
				'g_work_id'=>$work_id
			);
			$res_id=$this->Adminmodel->add_data($data,'gallery');
			if($res_id){
				$res=array('status'=>'200','msg'=>' successfull.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			//end inter record in the table
		}
	}
	public function saveCarousel(){
		//  uploading the file
		$config['upload_path']          =  APPPATH .'../assets/images/carousel/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$basename = md5(date('H:i:s:u')).$_FILES['userfile']['name'];

		if(move_uploaded_file($_FILES['userfile']['tmp_name'],$config['upload_path'].$basename)){
			// inter record in the table
			$title=$_POST['title'];
			$data = array(
				'c_title'=>$title,
				'c_image_url'=>"/assets/images/carousel/".$basename
			);
			$res_id=$this->Adminmodel->add_data($data,'carousel');
			if($res_id){
				$res=array('status'=>'200','msg'=>' successfull.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			//end inter record in the table
		}
	}
	public function saveSocialLink(){
			// inter record in the table
			$input_name=$_POST['input_name'];
			$input_f_color=$_POST['input_f_color'];
			$input_b_color=$_POST['input_b_color'];
			$icon=$_POST['input_icon'];
			$input_address=$_POST['input_address'];

			$data = array(
				's_name'=>$input_name,
				'front_color'=>$input_f_color,
				'back_color	'=>$input_b_color,
				's_link'=>$input_address,
				'icon'=>$icon
			);
			$res_id=$this->Adminmodel->add_data($data,'social_media');
			if($res_id){
				$res=array('status'=>'200','msg'=>' successfull.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			//end inter record in the table
	}

	public function saveWG(){
		//  uploading the file
		$config['upload_path']          =  APPPATH .'../assets/images/siteGallery/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$basename = md5(date('H:i:s:u')).$_FILES['userfile']['name'];

		if(move_uploaded_file($_FILES['userfile']['tmp_name'],$config['upload_path'].$basename)){
			// inter record in the table
			$title=$_POST['title'];
			$data = array(
				'wg_title'=>$title,
				'wg_url'=>"/assets/images/siteGallery/".$basename
			);
			$res_id=$this->Adminmodel->add_data($data,'website_gallery');
			if($res_id){
				$res=array('status'=>'200','msg'=>' successfull.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			//end inter record in the table
		}
	}
		public function saveOffer(){
		//  uploading the file
		$config['upload_path']          =  APPPATH .'../assets/images/offer/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$basename = md5(date('H:i:s:u')).$_FILES['userfile']['name'];

		if(move_uploaded_file($_FILES['userfile']['tmp_name'],$config['upload_path'].$basename)){
			// inter record in the table
			$o_title=$_POST['o_title'];
			$o_desc=$_POST['o_desc'];
			$o_url=$_POST['o_url'];
			$data = array(
				'o_title'=>$o_title,
				'o_desc'=>$o_desc,
				'o_url'=>$o_url,
				'o_image_url'=>"/assets/images/offer/".$basename
			);
			$res_id=$this->Adminmodel->add_data($data,'offer');
			if($res_id){
				$res=array('status'=>'200','msg'=>' successfull.','id'=>$res_id);
				echo json_encode($res);exit;
			}else{
				$res=array('status'=>'400','msg'=>'fail');
				echo json_encode($res);
				exit;
			}
			//end inter record in the table
		}
	}
	public function change_password(){
		$password  =$_POST['password'];
		$confirm_password  =$_POST['confirm_password'];
		$where = $_POST['admin_id'];
		$data =  array('password' => $password );
		$res_id=$this->Adminmodel->update_user($data,$where);
		if($res_id){
			$res=array('status'=>'200','msg'=>'Sucessfully updated','id'=>$res_id);
			echo json_encode($res);
		}else{
			$res=array('status'=>'400','msg'=>'fail');
			echo json_encode($res);
		}
	}

	public function save_payment(){
		$paypal_name=$_POST['paypal_name'];
		$paypal_client_id=$_POST['paypal_client_id'];
		$upi_name=$_POST['upi_name'];
		$upi_id=$_POST['upi_id'];

		$data = array(
			'value' => $paypal_name,
		);
		$this->Adminmodel->update_general_setting($data,'paypal_name');

		$data1 = array(
			'value' => $paypal_client_id,
		);
		$this->Adminmodel->update_general_setting($data1,'paypal_client_id');

		$data2 = array(
			'value' => $upi_name,
		);
		$this->Adminmodel->update_general_setting($data2,'UPI_Name');

		$data3 = array(
			'value' => $upi_id,
		);
		$this->Adminmodel->update_general_setting($data3,'UPI');

	}
	public function sendNotification(){

		$url = "https://fcm.googleapis.com/fcm/send";
		$token = " d2nOoeorTNSYajaCkf21hl:APA91bHFsRrpHInM64ACSmt-CoZ9IJ0gzWrflog_1FAWunVt0dl8M4klaR1OtBaJioE1D2zpbVbsMIuvjmlbYgIMNR141jqcw-IYGPatlbLo9J5O9sjqRLQxQF4uQQYyUzik5m2VeI00";
		$serverKey = 'AAAAiTqcIRg:APA91bG9Of28bykt9ZNv2gJJgqd84iIWEPWIDAdMxKoUiWxmyKPDxHwrkNWaySSN22RKCi_PfOebx3sDMA_EOi7SZboAzkCk-NtwFM91c46XkvtNN5-d2JbQ-fTMHj6Yu_pShtSLE8KR';

		$title = "public title";
		$body = "public message";
		$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);
		//Close request
		if ($response === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);

	}
	function sendNotificationOld(){
		$setting= $this->Adminmodel->settings_data();
		foreach($setting as $set)
		{
			$setn[$set->key]=$set->value;
		}
		$ONESIGNAL_APP_ID=$setn['onesignal_apid'];
		$ONESIGNAL_REST_KEY=$setn['onesignal_rest_key'];
		$big_picture=$_FILES['thumbnail']['name'];
		$tpath2= FCPATH . 'assets/images/book/';
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => FCPATH . 'assets/images/book'
		);
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->do_upload('thumbnail');

		$content = array(
			"en" => $_POST['message']
		);

		if(isset($_FILES['thumbnail']['name']))
		{
			$_FILES['thumbnail']['name'];
			$file_path = base_url().'assets/images/book/'.$big_picture;
			$fields = array(
				'app_id' =>  $ONESIGNAL_APP_ID,
				'included_segments' => array('All'),
				'data' => array("foo" => "bar"),
				'headings'=> array("en" => $_POST['title']),
				'contents' => $content,
				'big_picture' =>$file_path
			);
		}else
		{
			$file_path = '';
			$fields = array(
				'app_id' => $ONESIGNAL_APP_ID,
				'included_segments' => array('All'),
				'data' => array("foo" => "bar"),
				'headings'=> array("en" => $_POST['title']),
				'contents' => $content,
			);
		}

		$fields = json_encode($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
		'Authorization: Basic '.$ONESIGNAL_REST_KEY));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$response = curl_exec($ch);
		curl_close($ch);
		print_r($response);
	}

	public function savenotification(){
		$url = "https://fcm.googleapis.com/fcm/send";
		// $this->sendNotification();
		$setting= $this->Adminmodel->settings_data();
		foreach($setting as $set)
		{
			$setn[$set->key]=$set->value;
		}
		$serverKey =$setn['onesignal_rest_key'];
		$title=$_POST['title'];
		$user_id=$_POST['select_user'];
		$body=$_POST['body'];

		$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array( 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		// $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		// $this->Adminmodel->send_notification($user_id,$notification,'Android',$serverKey);
		if($user_id =="0"){
			// // 	//send notification to all user

			$results = $this->Adminmodel->getAllFcm();
			try{
				for ($i = 0; $i < sizeof($results); $i++) {
					$token = $results[$i]->fcm_key;
					// $title = "public title";
					// $body = "public message";
					// $token ='d2nOoeorTNSYajaCkf21hl:APA91bHFsRrpHInM64ACSmt-CoZ9IJ0gzWrflog_1FAWunVt0dl8M4klaR1OtBaJioE1D2zpbVbsMIuvjmlbYgIMNR141jqcw-IYGPatlbLo9J5O9sjqRLQxQF4uQQYyUzik5m2VeI00';

					$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
					$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key='. $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
					$response = curl_exec($ch);

					curl_close($ch);
				}
			}catch(exception $e){

				// sleep(3);
			}

		}else{
			
			$results = $this->Adminmodel->getuserFcm($user_id);
			try{
				for ($i = 0; $i < sizeof($results); $i++) {
					$token = $results[$i]->fcm_key;
					$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
					$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key='. $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
					$response = curl_exec($ch);

					curl_close($ch);
				}
			}catch(exception $e){

				// sleep(3);
			}

		}
		$response=array('status'=>200,'message'=>'Success');


		echo json_encode($response);

	}

	public function imageupload($imageName,$imgname, $uploadpath){

		if(empty($imageName['name'])){
			$res=array('status'=>'400','msg'=>'Please Upload Image first.');
			echo json_encode($res);exit;
		}
		if(!empty($imageName['name']) && ($imageName['error']==1 || $imageName['size']>2215000)){
			$res=array('status'=>'400','msg'=>'Max 2MB file is allowed for image.');
			echo json_encode($res);exit;
		}else{
			list($width, $height) = getimagesize($imageName['tmp_name']);
			if($width>1000 || $height >1000){
				$res=array('status'=>'400','msg'=>'Image height and width must be less than 1000px.');
				echo json_encode($res);exit;
			}else{

				$catImg = $imageName['name'];
				$ext = pathinfo($catImg);
				$catImages = str_replace(' ', '_', $ext['filename']);
				$category_image =$catImages.time().'.'.$ext['extension'];
				$config = array(
					'allowed_types' => 'jpg|jpeg|gif|png',
					'upload_path' => $uploadpath,
					'file_name' => $category_image
				);
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload($imgname);
				return $category_image;
			}

		}
	}

	public function fileupload($imageName,$imgname, $uploadpath){

		if(empty($imageName['name'])){
			$res=array('status'=>'400','msg'=>'Please Upload file first.');
			echo json_encode($res);exit;
		}
		if(!empty($imageName['name']) && ($imageName['error']==1 || $imageName['size']>103790053)){
			$res=array('status'=>'400','msg'=>'Max 10MB file is allowed for image.');
			echo json_encode($res);exit;
		}else{

			$catImg = $imageName['name'];
			$ext = pathinfo($catImg);
			$catImages = str_replace(' ', '_', $ext['filename']);
			$file_name = substr($catImages, 0, 5);
			$category_image =$file_name.time().'.'.$ext['extension'];
			$config = array(
				'allowed_types' => '*',
				'upload_path' => $uploadpath,
				'file_name' => $category_image
			);
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload($imgname);
			return $category_image;
		}
	}

	public function status_change(){
		$id=$_POST['id'];
		$tablename=$_POST['tablename'];
		$status=$_POST['status'];
		if($status=='enable'){
			$status1='disable';
		}else{
			$status1='enable';
		}
		if($tablename=='user'){
			$data1=array('status' => $status1);
			$this->Adminmodel->user_status_change($id,$data1);
		}elseif ($tablename=='category') {
			$data1=array('cat_status' => $status1);
			$this->Adminmodel->update_status_category($id,$data1);
		}elseif ($tablename=='course') {
			$data1=array('course_status' => $status1);
			$this->Adminmodel->update_status_course($id,$data1);
		}else{
			$data1=array('cat_status' => $status1);
			$this->Adminmodel->update_status_album($id,$data1);
		}
		return true;
	}
}
