<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct() {
			parent::__construct();		
			$this->load->model('M_auth', 'login');
			
	}

	public function index()
	{
		if($this->session->userdata('is_logged_in') == false )
			$this->load->view('v_login');	
		else
			redirect('dashboard');
			

	}

   public function login() 
 	{
		if($_POST)
		{
	    	 $result = $this->login->validate_user( $this->input->post('user'), $this->input->post('passwd') )->row();
			 if(!empty($result)) 
			 {
			 	if($result->tipe_surveyor == 'admin')
			 	{
 			        $data = array( 'is_logged_in' => true,
					   'kode_surveyor' => $result->kode_surveyor,
				       'nama_surveyor' => $result->nama_surveyor,
				       'email_surveyor' => $result->email_surveyor,
				       'kode_kota' => $result->kode_kota,
				       'is_admin' => $result->is_admin,
				       'tipe_surveyor' => $result->tipe_surveyor,
				       'passwd_user' => $result->password_surveyor,
		             );


					$this->session->set_userdata($data);
					redirect('dashboard');
			 	}else{
			 		 $this->session->set_flashdata('pesan',
					 '
					 <center><div class="label label-danger" role="alert">Access Denied! Hanya ADMIN yang boleh login...
					 </div></center><br/>

					 ');
					redirect('auth');
			 	}

				
			 } else {

				 $this->session->set_flashdata('pesan',
				 '
				 <center><div class="label label-danger" role="alert">Kombinasi Kode & Kata Sandi Tidak Sesuai !
				 </div></center><br/>

				 ');
				redirect('auth');

			 }
		}else{
		 	show_404();
		}
			
	}

	public function logout()
	{

		$this->session->sess_destroy();
		redirect('auth');
	}

	public function login2() 
	{
		 $result = $this->login->validate_user( $this->input->post('user'), $this->input->post('passwd') )->row();
		 if(!empty($result)) 
			 {
				$data = array( 'is_logged_in' => true,
							   'kode_surveyor' => $result->kode_surveyor,
						       'nama_surveyor' => $result->nama_surveyor,
						       'email_surveyor' => $result->email_surveyor,
						       'kode_kota' => $result->kode_kota,
						       'is_admin' => $result->is_admin,
						       'tipe_surveyor' => $result->tipe_surveyor,
				             );


				echo json_encode(array('status', TRUE), $data);
				
			 } else {

				echo json_encode(array('status', TRUE));

			 }
	}

}
