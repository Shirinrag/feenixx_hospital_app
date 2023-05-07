<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

	public function login()
	{
		$this->form_validation->set_rules('login_email', 'Username ', 'required|trim',array(
				'required' => 'You must provide an %s',
			)
		);
		$this->form_validation->set_rules('login_password', 'Password', 'trim|required',
			array(
				'required' => 'You must provide a %s',
			)
		);		
		if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['error'] = array(
            	'login_email' => strip_tags(form_error('login_email')), 
            	'login_password' => strip_tags(form_error('login_password')),
            );
        } else{
			$username= $this->input->post('login_email');  
		  	$password= $this->input->post('login_password'); 
		  	$curl_data = array(
				'email'=>$username,
			  	'password'=>$password,
			);
			$curl = $this->link->hits('login-data',$curl_data); 
			
			$curl = json_decode($curl, TRUE);
			if($curl['status']==true){
				if (@$curl['data']['fk_user_type']=="1") {
					$this->session->set_userdata('feenixx_hospital_superadmin_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['fk_user_type']=="2") {
					$this->session->set_userdata('feenixx_hospital_doctor_logged_in', @$curl['data']);
					$url=base_url().'doctor/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} 
			} else if($curl['error_status']=='wrong_username'){
				$response['status']='failure';  
				$response['error'] = array( 
            		'login_email' =>$curl['message'],
            	); 				
			} else {
		  		$response['status'] = 'failure';
            	$response['error'] = array( 
            		'login_password' =>$curl['message'],
            	);
		  	}
		} 
		echo json_encode($response);
	}

	public function logout()
	{
		$this->session->sess_destroy();
        redirect(base_url().'superadmin'); 
	}
}