<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {
	public function index()
	{
		$this->load->view('superadmin/login');
	}
    public function alpha_dash_space($fullname){
        if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function dashboard()
    {
        $this->load->view('superadmin/dashboard');
    }
    public function designation()
    {
        $this->load->view('superadmin/designation');
    }
    public function add_doctor()
    {
        $this->load->view('superadmin/add_doctor');
    }
    public function add_patient()
    {
        $this->load->view('superadmin/add_patient');
    }
}