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
    //============================= Dashboard Details===========================
    public function dashboard()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $this->load->view('superadmin/dashboard');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function designation()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $this->load->view('superadmin/designation');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    // =============================== Add Doctor =================================
    public function add_doctor()
    {
         if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['gender_data'] = $curl['gender_data'];
            $data['marital_status_data'] = $curl['marital_status_data'];
            $data['state_data'] = $curl['state_data'];
            $data['designation_data'] = $curl['designation_data'];            
            $this->load->view('superadmin/add_doctor',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
     public function get_city_data_on_state_id()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $state = $this->input->post('state');
            if (!empty($state)) {
                $curl_data = array('state' => $state);
                $curl = $this->link->hits('get-city-data-on-state-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                if (!empty($curl['city_data'])) {
                    $response['status'] = 'success';
                    $response['city_data'] = $curl['city_data'];
                } else {
                    $response['status'] = 'failure';
                }
            } else {
                $response['status'] = 'failure';
            }
        } else {
            $url = base_url();
            $response['status'] = 'login_failure';
            $response['message'] = $url;
        }
        echo json_encode($response);
    }
    public function save_doctor_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $contact_no = $this->input->post('contact_no');
            $password = $this->input->post('password');
            $dob = $this->input->post('dob');
            $specialization = $this->input->post('specialization');
            $address1 = $this->input->post('address1');
            $address2 = $this->input->post('address2');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $pincode = $this->input->post('pincode');
            $gender = $this->input->post('gender');

            $this->form_validation->set_rules('first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('email','Last Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('specialization','Specialization', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'first_name' => strip_tags(form_error('first_name')),
                    'last_name' => strip_tags(form_error('last_name')),
                    'email' => strip_tags(form_error('email')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    'password' => strip_tags(form_error('password')),
                    'dob' => strip_tags(form_error('dob')),
                    'specialization' => strip_tags(form_error('specialization')),
                    'gender' => strip_tags(form_error('gender')),
                    'address1' => strip_tags(form_error('address1')),
                    'state' => strip_tags(form_error('state')),
                    'city' => strip_tags(form_error('city')),
                    'pincode' => strip_tags(form_error('pincode')),
                );
            } else {
                $sample_image = '';
                $is_signature_file = true;
                if (!empty($_FILES['image']['name'])) {
                    $filename = $_FILES['image']['name'];
                    $test_img = $filename;
                    $test_img = preg_replace('/\s/', '_', $test_img);
                    $test_image = mt_rand(100000, 999999) . '_' .$test_img;
                    $setting['image_path'] = $_FILES['image']['tmp_name'];
                    $setting['image_name'] = $test_image;
                    $setting['compress_path'] = './uploads/';
                    $setting['jpg_compress_level'] = 5;
                    $setting['png_compress_level'] = 5;
                    $setting['create_thumb'] = FALSE;
                    $this->load->library('imgcompressor');
                    $results = $this->imgcompressor->do_compress($setting);
                    if (empty($results['data']['compressed']['name'])) {
                        $is_signature_file = false;
                        $response['status'] = 'failure';
                        $response['error'] = array(
                            'image' => $results['message'],
                        );
                    } else {
                        $sample_image = 'uploads/'.$test_image;
                    }
                }else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('image' => "Image required",);
                }
               
                if ($is_signature_file) {
                        $curl_data = array(
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'email'=>$email,
                            'phone_no'=>$contact_no,
                            'password'=>$password,
                            'dob'=>$dob,
                            'specialization'=>$specialization,
                            'gender'=>$gender,
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'state'=>$state,
                            'city'=>$city,
                            'pincode'=>$pincode,
                            'image'=>$sample_image,                           
                        );
                        $curl = $this->link->hits('add-doctor', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                        } else {
                            if ($curl['error_status'] == 'email') {
                                    $error = 'email';
                                } else if ($curl['error_status'] == 'contact_no') {
                                    $error = 'contact_no';
                                }
                            $response['status'] = 'failure';
                             $response['error'] = array($error => $curl['message']);
                        }
                    }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_doctor_data()
    {
            $doctor_data = $this->link->hits('display-all-doctor-details', array());
            $doctor_data = json_decode($doctor_data, true);
            $data = array();
            $no = @$_POST['start'];
            foreach ($doctor_data['doctor_data'] as $doctor_data_key => $doctor_data_row) {        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $doctor_data_row['first_name'];
            $row[] = $doctor_data_row['last_name'];
            $row[] = $doctor_data_row['email'];
            $row[] = $doctor_data_row['contact_no'];
            $row[] = $doctor_data_row['designation_name'];         
            $edit_html = '';
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_doctor_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_doctor_model" id="'.$doctor_data_row['id'].'"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_doctor" aria-hidden="true"></i></a></span>';
            $row[] = $edit_html;
            $data[] = $row;
        }
        $output = array("draw" => @$_POST['draw'], "recordsTotal" => $doctor_data['count'], "recordsFiltered" => $doctor_data['count_filtered'], "data" => $data);
        echo json_encode($output);
    }
    public function get_doctor_details_on_id() {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('id');
            $curl_data = array('id' => $id);
            $curl = $this->link->hits('get-all-doctor-on-id', $curl_data);
            $curl = json_decode($curl, TRUE);
            $data['doctor_details_data'] = $curl['doctor_details_data'];
            $data['city_data'] = $curl['city_data'];
            
            $response = $data;
            // echo '<pre>'; print_r($response); exit;
        }else {
            $resoponse['status']='login_failure'; 
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
      public function update_doctor_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];
            $first_name = $this->input->post('edit_first_name');
            $last_name = $this->input->post('edit_last_name');
            $dob = $this->input->post('edit_dob');
            $specialization = $this->input->post('edit_specialization');
            $address1 = $this->input->post('edit_address1');
            $address2 = $this->input->post('edit_address2');
            $state = $this->input->post('edit_state');
            $city = $this->input->post('edit_city');
            $pincode = $this->input->post('edit_pincode');
            $gender = $this->input->post('edit_gender');
            $is_file = true;
            $edit_profile_img = $this->input->post('last_inserted_image');
            $edit_id = $this->input->post('edit_id');
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
           
            $this->form_validation->set_rules('edit_dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_specialization','Specialization', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_first_name' => strip_tags(form_error('edit_first_name')),
                    'edit_last_name' => strip_tags(form_error('edit_last_name')),
                    'edit_dob' => strip_tags(form_error('edit_dob')),
                    'edit_specialization' => strip_tags(form_error('edit_specialization')),
                    'edit_gender' => strip_tags(form_error('edit_gender')),
                    'edit_address1' => strip_tags(form_error('edit_address1')),
                    'edit_state' => strip_tags(form_error('edit_state')),
                    'edit_city' => strip_tags(form_error('edit_city')),
                    'edit_pincode' => strip_tags(form_error('edit_pincode')),
                );
            } else {
                if (!empty($_FILES['edit_image']['name'])) {
                    $edit_profile_img = trim($_FILES['edit_image']['name']);
                    $edit_profile_img = preg_replace('/\s/', '_', $edit_profile_img);
                    $profile_image = mt_rand(100000, 999999) . '_' . $edit_profile_img;
                    $config['upload_path'] = './uploads/';
                    $config['file_name'] = $profile_image;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpg|jpeg|png|bmp';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('edit_image')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('edit_image' => $errors,);
                    }
                } 
                if ($is_file) {
                
                    if (!empty($profile_image)) {
                        $edit_profile_img = 'uploads/' . $profile_image;
                    }
                        $curl_data = array(
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'dob'=>$dob,
                            'specialization'=>$specialization,
                            'gender'=>$gender,
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'state'=>$state,
                            'city'=>$city,
                            'pincode'=>$pincode,
                            'image'=>$edit_profile_img,    
                            'id'=>$edit_id,                       
                        );
                        $curl = $this->link->hits('update-doctor', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                        } else {
                            if ($curl['error_status'] == 'email') {
                                    $error = 'edit_email';
                                } else if ($curl['error_status'] == 'contact_no') {
                                    $error = 'edit_contact_no';
                                }
                            $response['status'] = 'failure';
                             $response['error'] = array($error => $curl['message']);
                        }
                    }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_doctor()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('delete_doctor_id'); 
            if (empty($id)) {
                $response['message'] = 'id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-doctor',$curl_data);
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['message']='Data Deleted successfully';
                    $response['status'] = 1;
                } else {
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "superadmin";
        }
        echo json_encode($response);
    }
    public function add_patient()
    {
         if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
             $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['gender_data'] = $curl['gender_data'];
            $data['marital_status_data'] = $curl['marital_status_data'];
            $data['state_data'] = $curl['state_data'];
            $data['designation_data'] = $curl['designation_data'];   
            $this->load->view('superadmin/add_patient',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
}