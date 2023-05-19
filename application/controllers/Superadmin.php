<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();       
    }
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
    //============================= Dashboard Details===================
    public function dashboard()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $curl = $this->link->hits('superadmin-dashboard', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['doctor_count'] = $curl['doctor_count'];
            $data['active_doctor_count'] = $curl['active_doctor_count'];
            $data['inactive_doctor_count'] = $curl['inactive_doctor_count'];
            $data['male_doctor_count'] = $curl['male_doctor_count'];
            $data['female_doctor_count'] = $curl['female_doctor_count'];
            $data['patient_count'] = $curl['patient_count'];
            $data['male_patient_count'] = $curl['male_patient_count'];
            $data['female_patient_count'] = $curl['female_patient_count'];
            $data['transgender_patient_count'] = $curl['transgender_patient_count'];
            $data['appointment_count'] = $curl['appointment_count'];
            $data['diseases_count'] = $curl['diseases_count'];
            $this->load->view('superadmin/dashboard',$data);
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
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('specialization','Specialization', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
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
                            $response['msg']=$curl['message'];
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
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_doctor_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_doctor_model" id="'.$doctor_data_row['id'].'"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill delete_doctor" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_doctor" id="'.$doctor_data_row['id'].'" aria-hidden="true"></i></a></span>';
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
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
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
                            $response['msg']=$curl['message'];
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
                    $response['message']=$curl['message'];
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
            $data['blood_group_data'] = $curl['blood_group_data'];   
            $data['patient_id'] = $curl['patient_id'];   
            $this->load->view('superadmin/add_patient',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function save_patient_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];            
            $patient_id = $this->input->post('patient_id');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $contact_no = $this->input->post('contact_no');
            $dob = $this->input->post('dob');
            $marital_status = $this->input->post('marital_status');
            $blood_group = $this->input->post('blood_group');
            $address1 = $this->input->post('address1');
            $address2 = $this->input->post('address2');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $pincode = $this->input->post('pincode');
            $gender = $this->input->post('gender');
            $emergency_contact_name = $this->input->post('emergency_contact_name');
            $emergency_contact_phone = $this->input->post('emergency_contact_phone');
            $edit_insurance_doc = $this->input->post('last_inserted_insurance_document');
            
            $this->form_validation->set_rules('first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('email','Last Name', 'trim|required|valid_email',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('marital_status','Marital Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
            $this->form_validation->set_rules('gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('emergency_contact_name','Emergency Contact Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('emergency_contact_phone','Emergency Contact Phone', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'first_name' => strip_tags(form_error('first_name')),
                    'last_name' => strip_tags(form_error('last_name')),
                    'email' => strip_tags(form_error('email')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    'dob' => strip_tags(form_error('dob')),
                    'marital_status' => strip_tags(form_error('marital_status')),
                    'gender' => strip_tags(form_error('gender')),
                    'address1' => strip_tags(form_error('address1')),
                    'state' => strip_tags(form_error('state')),
                    'city' => strip_tags(form_error('city')),
                    'pincode' => strip_tags(form_error('pincode')),
                    'emergency_contact_name' => strip_tags(form_error('emergency_contact_name')),
                    'emergency_contact_phone' => strip_tags(form_error('emergency_contact_phone')),
                );
            } else {
                $insurance_document_1 = 'uploads/insurance_document/'.$patient_id.'/';
                if (!is_dir($insurance_document_1)) {
                    mkdir($insurance_document_1, 0777, TRUE);
                }
                $insurance_document = '';
                $is_signature_file = true;
                if (!empty($_FILES['insurance_document']['name'])) {
                    $edit_profile_img = trim($_FILES['insurance_document']['name']);
                    $edit_profile_img = preg_replace('/\s/', '_', $edit_profile_img);
                    $profile_image = mt_rand(100000, 999999) . '_' . $edit_profile_img;
                    $config['upload_path'] = $insurance_document_1;
                    $config['file_name'] = $profile_image;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('insurance_document')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('insurance_document' => $errors,);
                    }
                } else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('insurance_document' => "Insurance Document is required",);
                }
                if ($is_signature_file) {
                    $curl_data = array(
                        'patient_id'=>$patient_id,
                        'first_name'=>$first_name,
                        'last_name'=>$last_name,
                        'email'=>$email,
                        'phone_no'=>$contact_no,
                        'dob'=>$dob,
                        'marital_status'=>$marital_status,
                        'blood_group'=>$blood_group,                          
                        'gender'=>$gender,
                        'address1'=>$address1,
                        'address2'=>$address2,
                        'state'=>$state,
                        'city'=>$city,
                        'pincode'=>$pincode,                          
                        'emergency_contact_name'=>$emergency_contact_name,
                        'emergency_contact_phone'=>$emergency_contact_phone,
                        'insurance_document'=>$insurance_document_1.$profile_image,            
                    );
                    $curl = $this->link->hits('add-patient', $curl_data);
                    $curl = json_decode($curl, true);
                    if ($curl['status']==1) {
                        $response['status']='success';
                        $response['msg']=$curl['message'];
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
    public function display_all_patient_data()
    {
            $patient_data = $this->link->hits('display-all-patient-details', array());
            $patient_data = json_decode($patient_data, true);
            $data = array();
            $no = @$_POST['start'];
            foreach ($patient_data['patient_data'] as $patient_data_key => $patient_data_row) {        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $patient_data_row['patient_id'];
            $row[] = $patient_data_row['first_name'];
            $row[] = $patient_data_row['last_name'];
            $row[] = $patient_data_row['email'];
            $row[] = $patient_data_row['contact_no'];
            $row[] = $patient_data_row['blood_group'];         
            $edit_html = '';
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_patient_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_patient_model" id="'.$patient_data_row['id'].'"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill delete_patient" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal"  data-bs-target="#delete_patient" id="'.$patient_data_row['id'].'" aria-hidden="true"></i></a></span>';
            $row[] = $edit_html;
            $data[] = $row;
        }
        $output = array("draw" => @$_POST['draw'], "recordsTotal" => $patient_data['count'], "recordsFiltered" => $patient_data['count_filtered'], "data" => $data);
        echo json_encode($output);
    }
    public function get_patient_details_on_id() {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('id');
            $curl_data = array('id' => $id);
            $curl = $this->link->hits('get-all-patient-on-id', $curl_data);
            $curl = json_decode($curl, TRUE);
            $data['patient_details_data'] = $curl['patient_details_data'];
            $data['city_data'] = $curl['city_data'];
            $response = $data;
        }else {
            $resoponse['status']='login_failure'; 
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_patient_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            // $id = $session_data['id'];            
            $id = $this->input->post('edit_id');
            $edit_patient_id = $this->input->post('edit_patient_id');
            $first_name = $this->input->post('edit_first_name');
            $last_name = $this->input->post('edit_last_name');
            $dob = $this->input->post('edit_dob');
            $marital_status = $this->input->post('edit_marital_status');
            $blood_group = $this->input->post('edit_blood_group');
            $address1 = $this->input->post('edit_address1');
            $address2 = $this->input->post('edit_address2');
            $state = $this->input->post('edit_state');
            $city = $this->input->post('edit_city');
            $pincode = $this->input->post('edit_pincode');
            $gender = $this->input->post('edit_gender');
            $emergency_contact_name = $this->input->post('edit_emergency_contact_name');
            $emergency_contact_phone = $this->input->post('edit_emergency_contact_phone');
             $edit_insurance_doc = $this->input->post('last_inserted_insurance_document');
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_marital_status','Marital Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
            $this->form_validation->set_rules('edit_gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_emergency_contact_name','Emergency Contact Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_emergency_contact_phone','Emergency Contact Phone', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_first_name' => strip_tags(form_error('edit_first_name')),
                    'edit_last_name' => strip_tags(form_error('edit_last_name')),
                    'edit_dob' => strip_tags(form_error('edit_dob')),
                    'edit_marital_status' => strip_tags(form_error('edit_marital_status')),
                    'edit_gender' => strip_tags(form_error('edit_gender')),
                    'edit_address1' => strip_tags(form_error('edit_address1')),
                    'edit_state' => strip_tags(form_error('edit_state')),
                    'edit_city' => strip_tags(form_error('edit_city')),
                    'edit_pincode' => strip_tags(form_error('edit_pincode')),
                    'edit_emergency_contact_name' => strip_tags(form_error('edit_emergency_contact_name')),
                    'edit_emergency_contact_phone' => strip_tags(form_error('edit_emergency_contact_phone')),
                );
            } else {
               $insurance_document_1 = 'uploads/insurance_document/'.$edit_patient_id.'/';
                if (!is_dir($insurance_document_1)) {
                    mkdir($insurance_document_1, 0777, TRUE);
                }
                $is_signature_file = true;
                if (!empty($_FILES['edit_insurance_document']['name'])) {
                        $image = trim($_FILES['edit_insurance_document']['name']);
                        $image = preg_replace('/\s/', '_', $image);
                        $cat_image = mt_rand(100000, 999999) . '_' . $image;
                        $config['upload_path'] = $insurance_document_1;
                        $config['file_name'] = $cat_image;
                        $config['overwrite'] = TRUE;
                        $config["allowed_types"] = 'pdf';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('edit_insurance_document')) {
                            $is_signature_file = false;
                            $errors = $this->upload->display_errors();
                            $response['code'] = 201;
                            $response['message'] = $errors;
                        } else {
                            $edit_insurance_doc = $insurance_document_1 . $cat_image;
                        }
                    }
                if($is_signature_file){
                        $curl_data = array(
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'dob'=>$dob,
                            'marital_status'=>$marital_status,
                            'blood_group'=>$blood_group,                          
                            'gender'=>$gender,
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'state'=>$state,
                            'city'=>$city,
                            'pincode'=>$pincode,                          
                            'emergency_contact_name'=>$emergency_contact_name,
                            'emergency_contact_phone'=>$emergency_contact_phone,
                            'id'=>$id,
                            'insurance_document'=>$edit_insurance_doc,
                        );
                        $curl = $this->link->hits('update-patient', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                            $response['msg']=$curl['message'];
                        } else {
                            $response['status'] = 'failure';
                            $response['error'] = array('first_name'=> $curl['message']);
                        }
                    }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_patient()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('delete_patient_id'); 
            if (empty($id)) {
                $response['message'] = 'Is is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-patient',$curl_data);
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['message']=$curl['message'];
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
    public function appointment()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $curl = $this->link->hits('get-appointment-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['patient_data'] = $curl['patient_data'];
            $data['diseases_data'] = $curl['diseases_data'];
            $this->load->view('superadmin/appointment',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function display_all_appointment_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $curl = $this->link->hits('superadmin-get-all-appointment-details', array(), '', 0);
            // echo '<pre>'; print_r($curl); exit;
            $curl = json_decode($curl, true);
            $response['data'] = $curl['appointment_details_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function patient_reports()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $this->load->view('superadmin/reports');
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function display_all_patient_report_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $curl = $this->link->hits('get-all-appointment-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['appointment_details_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    // ======================== Diseases =============================

    public function diseases()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $this->load->view('superadmin/diseases');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_diseases()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];
            $diseases = $this->input->post('diseases');           
            $this->form_validation->set_rules('diseases','Diseases', 'trim|required',array('required' => 'You must provide a %s',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'diseases' => strip_tags(form_error('diseases')),
                );
            } else {
                $curl_data = array(
                    'diseases'=>$diseases,                    
                );
                $curl = $this->link->hits('add-diseases', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']= $curl['message'];
                } else {
                     $response['status'] = 'failure';
                     $response['error'] = array('disease' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_diseases_data()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-diesases-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['diseases_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_diseases_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');       
            $id = $this->input->post('edit_id');
            $edit_diseases = $this->input->post('edit_diseases');
            $this->form_validation->set_rules('edit_diseases','Diseases', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_diseases' => strip_tags(form_error('edit_diseases')),
                );
            } else {
                $curl_data = array(
                    'diseases'=>$edit_diseases,
                    'id'=>$id,
                );
                $curl = $this->link->hits('update-diseases', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('edit_diseases'=> $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_diseases()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('delete_diseases_id'); 
            if (empty($id)) {
                $response['message'] = 'Is is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-diseases',$curl_data);
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['msg']=$curl['message'];
                    $response['status'] = 'success';
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
    public function change_diseases_status()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id )) {
                $response['message'] = 'Id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );
                $curl = $this->link->hits('update-diseases-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']=$curl['message'];
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ======================== Wards =============================

    public function wards()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $this->load->view('superadmin/add_wards');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_wards()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];
            $wards = $this->input->post('wards');           
            $this->form_validation->set_rules('wards','wards', 'trim|required',array('required' => 'You must provide a %s',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'wards' => strip_tags(form_error('wards')),
                );
            } else {
                $curl_data = array(
                    'wards'=>$wards,                    
                );
                $curl = $this->link->hits('add-wards', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']= $curl['message'];
                } else {
                     $response['status'] = 'failure';
                     $response['error'] = array('wards' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_wards_data()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-wards-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['wards_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_wards_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');       
            $id = $this->input->post('edit_id');
            $edit_wards = $this->input->post('edit_wards');
            $this->form_validation->set_rules('edit_wards','wards', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_wards' => strip_tags(form_error('edit_wards')),
                );
            } else {
                $curl_data = array(
                    'wards'=>$edit_wards,
                    'id'=>$id,
                );
                $curl = $this->link->hits('update-wards', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('edit_wards'=> $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_wards()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('delete_wards_id'); 
            if (empty($id)) {
                $response['message'] = 'Is is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-wards',$curl_data);
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['msg']=$curl['message'];
                    $response['status'] = 'success';
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
    public function change_wards_status()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id )) {
                $response['message'] = 'Id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );
                $curl = $this->link->hits('update-wards-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']=$curl['message'];
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ======================== Staff ===================================
    public function add_staff()
    {
         if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
             $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['gender_data'] = $curl['gender_data'];
            $data['marital_status_data'] = $curl['marital_status_data'];
            $data['state_data'] = $curl['state_data'];  
            $data['patient_id'] = $curl['patient_id'];   
            $user_type = $curl['user_type'];   
            unset($user_type[0]);
            unset($user_type[1]);
            unset($user_type[3]);
            $data['user_type']= $user_type; 
            $this->load->view('superadmin/add_staff',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function save_staff_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];            
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $contact_no = $this->input->post('contact_no');
            $dob = $this->input->post('dob');
            $address1 = $this->input->post('address1');
            $address2 = $this->input->post('address2');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $pincode = $this->input->post('pincode');
            $gender = $this->input->post('gender');            
            $user_type = $this->input->post('user_type');            
            $password = $this->input->post('password');            
            $this->form_validation->set_rules('first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('email','Last Name', 'trim|required|valid_email',array('required' => 'You must provide a %s',));
             $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
            $this->form_validation->set_rules('gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('user_type','user_type', 'trim|required',array('required' => 'You must provide a %s',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'first_name' => strip_tags(form_error('first_name')),
                    'last_name' => strip_tags(form_error('last_name')),
                    'email' => strip_tags(form_error('email')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    'dob' => strip_tags(form_error('dob')),
                    'gender' => strip_tags(form_error('gender')),
                    'address1' => strip_tags(form_error('address1')),
                    'state' => strip_tags(form_error('state')),
                    'city' => strip_tags(form_error('city')),
                    'pincode' => strip_tags(form_error('pincode')),
                    'password' => strip_tags(form_error('password')),
                    'user_type' => strip_tags(form_error('user_type')),
                   
                );
            } else {
                $pan_card = 'uploads/pan_card/';
                if (!is_dir($pan_card)) {
                    mkdir($pan_card, 0777, TRUE);
                }
                $aadhar_card = 'uploads/aadhar_card/';
                if (!is_dir($aadhar_card)) {
                    mkdir($aadhar_card, 0777, TRUE);
                }
                $is_signature_file = true;
                if (!empty($_FILES['pan_card']['name'])) {
                    $pan_card_image = trim($_FILES['pan_card']['name']);
                    $pan_card_image = preg_replace('/\s/', '_', $pan_card_image);
                    $profile_image = mt_rand(100000, 999999) . '_' . $pan_card_image;
                    $config['upload_path'] = $pan_card;
                    $config['file_name'] = $profile_image;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpeg|png|bmp|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('pan_card')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('pan_card' => $errors,);
                    }
                } else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('pan_card' => "Pan Card Document is required",);
                }
                if (!empty($_FILES['aadhar_card']['name'])) {
                    $aadhar_card_image = trim($_FILES['aadhar_card']['name']);
                    $aadhar_card_image = preg_replace('/\s/', '_', $aadhar_card_image);
                    $aadhar_card_images = mt_rand(100000, 999999) . '_' . $aadhar_card_image;
                    $config['upload_path'] = $aadhar_card;
                    $config['file_name'] = $aadhar_card_images;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpeg|png|bmp|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('aadhar_card')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('aadhar_card' => $errors,);
                    }
                } else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('aadhar_card' => "Pan Card Document is required",);
                }
                if ($is_signature_file) {
                    $curl_data = array(
                        'user_type'=>$user_type,
                        'first_name'=>$first_name,
                        'last_name'=>$last_name,
                        'email'=>$email,
                        'phone_no'=>$contact_no,
                        'dob'=>$dob,                        
                        'gender'=>$gender,
                        'address1'=>$address1,
                        'address2'=>$address2,
                        'state'=>$state,
                        'city'=>$city,
                        'pincode'=>$pincode,                          
                        'password'=>$password,                          
                        'pan_card'=>$pan_card.$profile_image,            
                        'aadhar_card'=>$aadhar_card.$aadhar_card_images,      
                    );
                    $curl = $this->link->hits('add-staff', $curl_data);
                    $curl = json_decode($curl, true);
                    if ($curl['status']==1) {
                        $response['status']='success';
                        $response['msg']=$curl['message'];
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
    public function display_all_staff_data()
    {
            $staff_data = $this->link->hits('display-all-staff-details', array());
            $staff_data = json_decode($staff_data, true);
            $data = array();
            $no = @$_POST['start'];
            foreach ($staff_data['staff_data'] as $staff_data_key => $staff_data_row) {        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $staff_data_row['first_name'];
            $row[] = $staff_data_row['last_name'];
            $row[] = $staff_data_row['email'];
            $row[] = $staff_data_row['contact_no'];
            $row[] = $staff_data_row['user_type'];         
            $edit_html = '';
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_staff_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_staff_model" id="'.$staff_data_row['id'].'"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill delete_staff" class="trigger-btn" data-bs-toggle="modal"  data-bs-target="#delete_staff" id="'.$staff_data_row['id'].'" aria-hidden="true"></i></a></span>';
            $row[] = $edit_html;
            $data[] = $row;
        }
        $output = array("draw" => @$_POST['draw'], "recordsTotal" => $staff_data['count'], "recordsFiltered" => $staff_data['count_filtered'], "data" => $data);
        echo json_encode($output);
    }
    public function get_staff_details_on_id() {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $id = $this->input->post('id');
            $curl_data = array('id' => $id);
            $curl = $this->link->hits('get-all-staff-on-id', $curl_data);
            $curl = json_decode($curl, TRUE);
            $data['staff_details_data'] = $curl['staff_details_data'];
            $data['city_data'] = $curl['city_data'];
            $response = $data;
        }else {
            $resoponse['status']='login_failure'; 
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_staff_details()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            // $id = $session_data['id'];            
            $id = $this->input->post('edit_id');
            $first_name = $this->input->post('edit_first_name');
            $last_name = $this->input->post('edit_last_name');
            $dob = $this->input->post('edit_dob');
            $user_type = $this->input->post('edit_user_type');
            $address1 = $this->input->post('edit_address1');
            $address2 = $this->input->post('edit_address2');
            $state = $this->input->post('edit_state');
            $city = $this->input->post('edit_city');
            $pincode = $this->input->post('edit_pincode');
            $gender = $this->input->post('edit_gender');
            $edit_pan_card_images = $this->input->post('last_inserted_pancard_document');
            $edit_aadhar_card_images = $this->input->post('last_inserted_aadhar_card_document');           
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));
            $this->form_validation->set_rules('edit_gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_first_name' => strip_tags(form_error('edit_first_name')),
                    'edit_last_name' => strip_tags(form_error('edit_last_name')),
                    'edit_dob' => strip_tags(form_error('edit_dob')),
                    'edit_gender' => strip_tags(form_error('edit_gender')),
                    'edit_address1' => strip_tags(form_error('edit_address1')),
                    'edit_state' => strip_tags(form_error('edit_state')),
                    'edit_city' => strip_tags(form_error('edit_city')),
                    'edit_pincode' => strip_tags(form_error('edit_pincode')),
                );
            } else {
                $edit_pan_card = 'uploads/pan_card/';
                if (!is_dir($edit_pan_card)) {
                    mkdir($edit_pan_card, 0777, TRUE);
                }
                $edit_aadhar_card = 'uploads/aadhar_card/';
                if (!is_dir($edit_aadhar_card)) {
                    mkdir($edit_aadhar_card, 0777, TRUE);
                }
                $is_signature_file = true;
                if (!empty($_FILES['edit_pan_card']['name'])) {
                        $image = trim($_FILES['edit_pan_card']['name']);
                        $image = preg_replace('/\s/', '_', $image);
                        $cat_image = mt_rand(100000, 999999) . '_' . $image;
                        $config['upload_path'] = $edit_pan_card;
                        $config['file_name'] = $cat_image;
                        $config['overwrite'] = TRUE;
                        $config["allowed_types"] = 'jpeg|jpg|png';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('edit_pan_card')) {
                            $is_signature_file = false;
                            $errors = $this->upload->display_errors();
                            $response['code'] = 201;
                            $response['message'] = $errors;
                        } else {
                            $edit_pan_card_images = $edit_pan_card . $cat_image;
                        }
                    }
                
                if (!empty($_FILES['edit_aadhar_card']['name'])) {
                        $image = trim($_FILES['edit_aadhar_card']['name']);
                        $image = preg_replace('/\s/', '_', $image);
                        $aadhar_doc = mt_rand(100000, 999999) . '_' . $image;
                        $config['upload_path'] = $edit_aadhar_card;
                        $config['file_name'] = $aadhar_doc;
                        $config['overwrite'] = TRUE;
                        $config["allowed_types"] = 'jpeg|jpg|png';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('edit_aadhar_card')) {
                            $is_signature_file = false;
                            $errors = $this->upload->display_errors();
                            $response['code'] = 201;
                            $response['message'] = $errors;
                        } else {
                            $edit_aadhar_card_images = $edit_aadhar_card . $aadhar_doc;
                        }
                    } 
                if ($is_signature_file) {
                        $curl_data = array(
                            'user_type'=>$user_type,
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'dob'=>$dob,
                            'user_type'=>$user_type, 
                            'gender'=>$gender,
                            'address1'=>$address1,
                            'address2'=>$address2,
                            'state'=>$state,
                            'city'=>$city,
                            'pincode'=>$pincode,
                            'id'=>$id,
                            'pan_card'=>$edit_pan_card_images,
                            'aadhar_card'=>$edit_aadhar_card_images,
                        );
                        $curl = $this->link->hits('update-staff', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                            $response['msg']=$curl['message'];
                        } else {
                            $response['status'] = 'failure';
                            $response['error'] = array('first_name'=> $curl['message']);
                        }
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
}