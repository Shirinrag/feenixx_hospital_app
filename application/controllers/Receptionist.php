<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receptionist extends CI_Controller {
	public function __construct()
    {
        parent::__construct();      
        header('Access-Control-Allow-Origin: *'); 
    }
	public function dashboard()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $curl = $this->link->hits('doctor-dashboard', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['patient_count'] = $curl['patient_count'];
            $data['male_patient_count'] = $curl['male_patient_count'];
            $data['female_patient_count'] = $curl['female_patient_count'];
            $data['transgender_patient_count'] = $curl['transgender_patient_count'];
            $data['appointment_count'] = $curl['appointment_count'];
            $data['diseases_count'] = $curl['diseases_count'];
            $this->load->view('receptionist/dashboard',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function get_city_data_on_state_id()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
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
    public function add_patient()
    {
         if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['gender_data'] = $curl['gender_data'];
            $data['marital_status_data'] = $curl['marital_status_data'];
            $data['state_data'] = $curl['state_data'];  
            $data['blood_group_data'] = $curl['blood_group_data'];   
            $data['patient_id'] = $curl['patient_id'];   
            $this->load->view('receptionist/add_patient',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function save_patient_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
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
            $this->form_validation->set_rules('first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('email','Last Name', 'trim|required|valid_email',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required|exact_length[10]',array('required' => 'You must provide a %s','exact_length' => 'Contact Number should be 10 digit number',));
            // $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
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
                    // 'email' => strip_tags(form_error('email')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    // 'dob' => strip_tags(form_error('dob')),
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
                            'added_by'=> $id, 
                        );
                       
                        $curl = $this->link->hits('add-patient', $curl_data);
                         // echo '<pre>'; print_r($curl); exit;
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
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
            // $this->form_validation->set_rules('edit_dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
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
                    // 'edit_dob' => strip_tags(form_error('edit_dob')),
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
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
                    $response['message']='Patient Deleted successfully';
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $curl = $this->link->hits('get-appointment-data', array(), '', 0); 
            $curl = json_decode($curl, true);
            $data['patient_data'] = $curl['patient_data'];
            $data['diseases_data'] = $curl['diseases_data'];
            $data['doctor_data'] = $curl['doctor_data'];
            $data['appointment_type'] = $curl['appointment_type'];
            $data['location_data'] = $curl['location_data'];
            $data['charges_data'] = $curl['charges_data'];
            $data['payment_type'] = $curl['payment_type'];

            $this->load->view('receptionist/appointment',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function get_charges_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
                $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
                $curl = $this->link->hits('get-appointment-data', array(), '', 0);  
                $curl = json_decode($curl, true);
                $response['charges_data'] = $curl['charges_data'];
        } else {
            $url = base_url();
            $response['status'] = 'login_failure';
            $response['message'] = $url;
        }
        echo json_encode($response);
    }
    public function get_patient_details_on_patient_id()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {
            $id = $this->input->post('id');
            if (!empty($id)) {
                $curl_data = array('id' => $id);
                $curl = $this->link->hits('get-patient-details-on-patient-id', $curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, TRUE);
                if (!empty($curl['patient_data'])) {
                    $response['status'] = 'success';
                    $response['patient_data'] = $curl['patient_data'];
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
    public function save_appointment_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $added_by = $session_data['id'];
            $patient_id = $this->input->post('patient_id');
            $patient_id_1 = $this->input->post('patient_id_1');
            $appointment_date = $this->input->post('appointment_date');
            $fk_diseases_id = $this->input->post('fk_diseases_id');
            $appointment_time = $this->input->post('appointment_time');
            $doctor_id = $this->input->post('doctor_id');
            $reference_doctor_name = $this->input->post('reference_doctor_name');
            // $payment_type = $this->input->post('payment_type');
            // $online_amount = $this->input->post('online_amount');
            // $cash_amount = $this->input->post('cash_amount');
            // $mediclaim_amount = $this->input->post('mediclaim_amount');
            // $discount = $this->input->post('discount');
            // $total_amount = $this->input->post('total_amount');
            $admission_type = $this->input->post('admission_type');          
            $admission_sub_type = $this->input->post('admission_sub_type');
            $fk_visit_location_id = $this->input->post('fk_visit_location_id');
            $deposite_amount = $this->input->post('deposite_amount');

            $this->form_validation->set_rules('patient_id','Patient ID', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('appointment_date','Appointment Date', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('appointment_time','Appointment Time', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('fk_diseases_id','Diseases', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('doctor_id','Doctor', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('description','Description', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('payment_type','Payment Type', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('online_amount','Online Amount', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('cash_amount','Cash Amount', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('mediclaim_amount','Mediclaim Amount', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('discount','Discount', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('total_amount','Total Amount', 'trim|required',array('required' => 'You must provide a %s',));            
            $this->form_validation->set_rules('admission_type','Admission Type', 'trim|required',array('required' => 'You must provide a %s',));       
            if($admission_type==3){
                $this->form_validation->set_rules('admission_sub_type','Sub Admission Type', 'trim|required',array('required' => 'You must provide a %s',));   
                $this->form_validation->set_rules('fk_visit_location_id','Admission Type', 'trim|required',array('required' => 'You must provide a %s',));   
            }else if($admission_type==2){
                $this->form_validation->set_rules('deposite_amount','Deposite Amount', 'trim|required',array('required' => 'You must provide a %s',));  
            }   
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'patient_id' => strip_tags(form_error('patient_id')),
                    // 'fk_diseases_id' => strip_tags(form_error('fk_diseases_id')),
                    'description' => strip_tags(form_error('description')),
                    'appointment_date' => strip_tags(form_error('appointment_date')),
                    'appointment_time' => strip_tags(form_error('appointment_time')),
                    'doctor_id' => strip_tags(form_error('doctor_id')),
                    // 'payment_type' => strip_tags(form_error('payment_type')),
                    // 'online_amount' => strip_tags(form_error('online_amount')),
                    // 'cash_amount' => strip_tags(form_error('cash_amount')),
                    // 'discount' => strip_tags(form_error('discount')),
                    // 'mediclaim_amount' => strip_tags(form_error('mediclaim_amount')),
                    // 'total_amount' => strip_tags(form_error('total_amount')),
                    'admission_type' => strip_tags(form_error('admission_type')),
                    'admission_sub_type' => strip_tags(form_error('admission_sub_type')),
                    'fk_visit_location_id' => strip_tags(form_error('fk_visit_location_id')),
                    'deposite_amount' => strip_tags(form_error('deposite_amount')),
                );
            } else {
                // $upload_data = 'uploads/pescription/'.$patient_id_1.'/';
               
                $documents_upload_data = 'uploads/documents/'.$patient_id_1.'/';
                // if (!is_dir($upload_data)) {
                //     mkdir($upload_data, 0777, TRUE);
                // }
                
                if (!is_dir($documents_upload_data)) {
                    mkdir($documents_upload_data, 0777, TRUE);
                }
                // $sample_image = '';
                $is_signature_file = true;
                // if (!empty($_FILES['pescription']['name'])) {
                //     $filename = $_FILES['pescription']['name'];
                //     $test_img = $filename;
                //     $test_img = preg_replace('/\s/', '_', $test_img);
                //     $test_image = mt_rand(100000, 999999) . '_' .$test_img;
                //     $setting['image_path'] = $_FILES['pescription']['tmp_name'];
                //     $setting['image_name'] = $test_image;
                //     $setting['compress_path'] = $upload_data;
                //     $setting['jpg_compress_level'] = 5;
                //     $setting['png_compress_level'] = 5;
                //     $setting['create_thumb'] = FALSE;
                //     $this->load->library('imgcompressor');
                //     $results = $this->imgcompressor->do_compress($setting);
                //     if (empty($results['data']['compressed']['name'])) {
                //         $is_signature_file = false;
                //         $response['status'] = 'failure';
                //         $response['error'] = array(
                //             'pescription' => $results['message'],
                //         );
                //     } else {
                //         $sample_image = $upload_data.$test_image;
                //     }
                // }else {
                //     $is_signature_file = false;
                //     $response['status'] = 'failure';
                //     $response['error'] = array('image' => "Image required",);
                // }
                
                $this->load->library('upload');
                $dataInfo = array();
                $files = $_FILES;
                $cpt = count($_FILES['document']['name']);
                for($i=0; $i<$cpt; $i++){ 
                    $_FILES['images']['name'] = $files['document']['name'][$i];
                    $_FILES['images']['type']= $files['document']['type'][$i];
                    $_FILES['images']['tmp_name']= $files['document']['tmp_name'][$i];
                    $_FILES['images']['error']= $files['document']['error'][$i];
                    $_FILES['images']['size']= $files['document']['size'][$i];
                    $this->upload->initialize($this->set_upload_options($files['document']['name'][$i],$documents_upload_data));
                    if (!$this->upload->do_upload('images')){
                        $is_file = false;                   
                        $response['status'] = 'failure_img';
                        $response['message'] = $this->upload->display_errors();                 
                    } else {
                        $image_info = $this->upload->data();
                        $dataInfo[] = $documents_upload_data.$image_info['file_name'];
                        if(empty($response_image['status'])){                           
                            $is_file = false;
                            $response['status'] = 'failure';                            
                            $response['message'] = $this->upload->display_errors();
                        }
                    }
                }
                if ($is_signature_file) {
                        $curl_data = array(
                            'doctor_id'=>$doctor_id,
                            'patient_id'=>$patient_id,
                            'appointment_time'=>$appointment_time,
                            'appointment_date'=>$appointment_date,
                            'fk_diseases_id'=>$fk_diseases_id,
                            // 'payment_type'=>$payment_type,
                            // 'description'=>$description,
                            // 'cash_amount'=>$cash_amount,
                            // 'online_amount'=>$online_amount,
                            // 'mediclaim_amount'=>$mediclaim_amount,
                            // 'discount'=>$discount,
                            // 'total_amount'=>$total_amount,
                            // 'image'=>$sample_image,                          
                            'document'=>json_encode($dataInfo), 
                            'admission_type'=>$admission_type,           
                            'admission_sub_type'=>$admission_sub_type,
                            'fk_visit_location_id'=>$fk_visit_location_id,
                            'reference_doctor_name'=>$reference_doctor_name,
                            'deposite_amount'=>$deposite_amount   
                        );
                        $curl = $this->link->hits('save-appointment-details', $curl_data);
                        // echo '<pre>'; print_r($curl); exit;
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
    private function set_upload_options($provided_file_name='',$documents_upload_data=""){   
        //upload an image options
        $config = array();
        if(!empty($provided_file_name)){
            $extension = pathinfo($provided_file_name, PATHINFO_EXTENSION);
            $unique_no = uniqid();
            $filename = $unique_no.'.'.$extension;
            $config['file_name'] = $filename;
        }
        // $config['upload_path'] = './uploads/documents/';
        $config['upload_path'] = $documents_upload_data;
        $config['allowed_types'] = get_allowed_file_type();
        $config['max_size']      = '0';
        $config['overwrite']     = TRUE;
        return $config;
    }
    public function display_all_appointment_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $id = $session_data['fk_id'];
            $curl = $this->link->hits('get-all-appointment-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['appointment_details_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function add_appointment_payment_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');

            $payment_type = $this->input->post('payment_type');
            $charges = $this->input->post('charges');
            $amount = $this->input->post('amount');
            $online_amount = $this->input->post('online_amount');
            $cash_amount = $this->input->post('cash_amount');
            $mediclaim_amount = $this->input->post('mediclaim_amount');
            $discount = $this->input->post('discount');
            $total_amount = $this->input->post('total_amount');
            $total_paid_amount = $this->input->post('total_paid_amount');
            $remaining_amount = $this->input->post('remaining_amount');
            $fk_patient_id = $this->input->post('fk_patient_id');
            $fk_appointment_id = $this->input->post('fk_appointment_id');
            $added_by = $session_data['id'];

            $this->form_validation->set_rules('total_paid_amount','Total Paid amount', 'trim|required',array('required' => 'You must provide a %s',));       
            $this->form_validation->set_rules('total_amount','Total Amount', 'trim|required',array('required' => 'You must provide a %s',));       
            $this->form_validation->set_rules('payment_type','Payment', 'trim|required',array('required' => 'You must provide a %s',));       
              
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'total_amount' => strip_tags(form_error('total_amount')),
                    'total_paid_amount' => strip_tags(form_error('total_paid_amount')),
                    'payment_type' => strip_tags(form_error('payment_type')),
                );
            } else {
                $curl_data = array(
                    'payment_type'=>$payment_type,
                    'charges'=>$charges,
                    'amount'=>$amount,
                    'online_amount'=>$online_amount,
                    'cash_amount'=>$cash_amount,
                    'mediclaim_amount'=>$mediclaim_amount,
                    'discount'=>$discount,
                    'total_amount'=>$total_amount,
                    'total_paid_amount'=>$total_paid_amount,
                    'remaining_amount'=>$remaining_amount,
                );

                $data = array(
                    'payment_details'=> json_encode($curl_data,true),
                     'online_amount'=>$online_amount,
                    'cash_amount'=>$cash_amount,
                    'mediclaim_amount'=>$mediclaim_amount,
                    'total_amount'=>$total_amount,
                    'total_paid_amount'=>$total_paid_amount,
                    'remaining_amount'=>$remaining_amount,
                    'fk_patient_id'=>$fk_patient_id,
                    'fk_appointment_id'=>$fk_appointment_id,
                     'added_by'=>$added_by,
                );
                $curl = $this->link->hits('add-appointment-payment-details', $data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('payment_type' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }

    public function reschedule_appointment()
    {
       if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $update_id = $this->input->post('update_id');
            $update_appointment_date = $this->input->post('update_appointment_date');
            $update_appointment_time = $this->input->post('update_appointment_time');
        

            $this->form_validation->set_rules('update_appointment_date','Appointment Date', 'trim|required',array('required' => 'You must provide a %s',));       
            $this->form_validation->set_rules('update_appointment_time','Appointment Time', 'trim|required',array('required' => 'You must provide a %s',));          
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'update_appointment_time' => strip_tags(form_error('update_appointment_time')),
                    'update_appointment_date' => strip_tags(form_error('update_appointment_date')),
                );
            } else {           
                $curl_data = array(
                    'id'=>$update_id,
                    'appointment_date'=>$update_appointment_date,
                    'appointment_time'=>$update_appointment_time,
                );
                $curl = $this->link->hits('reschedule-appointment-details', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']= $curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('update_appointment_date' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }

    public function get_payment_data_on_appointment_id()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $id = $this->input->post('id');
            $curl_data=array('id'=>$id);
            $curl = $this->link->hits('get-payment-data-on-appointment-id',$curl_data);       
            $curl = json_decode($curl, true);
            $response['payment_detail'] = $curl['payment_detail'];
            $response['advance_payment'] = $curl['advance_payment'];
            $response['charges_payment_details'] = $curl['charges_payment_details'];
            $response['payment_info'] = $curl['payment_info'];
            
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_payment_details()
    {
       if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $total_amount = $this->input->post('up_total_amount');
            $online_amount = $this->input->post('up_online_amount');
            $cash_amount = $this->input->post('up_cash_amount');
            $mediclaim_amount = $this->input->post('up_mediclaim_amount');
            $total_paid_amount = $this->input->post('up_total_paid_amount');
            $remaining_amount = $this->input->post('up_remaining_amount');
            $fk_patient_id = $this->input->post('u_fk_patient_id');
            $fk_appointment_id = $this->input->post('u_fk_appointment_id');
            $fk_payment_id = $this->input->post('u_fk_payment_id');
            $added_by = $session_data['id'];
            $up_total_amount = $this->input->post('up_total_amount');
            $this->form_validation->set_rules('up_total_paid_amount','Total Paid amount', 'trim|required',array('required' => 'You must provide a %s',));       
            $this->form_validation->set_rules('up_total_amount','Total Amount', 'trim|required',array('required' => 'You must provide a %s',));           
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'up_total_amount' => strip_tags(form_error('up_total_amount')),
                    'up_total_paid_amount' => strip_tags(form_error('up_total_paid_amount')),
                );
            } else {
                $data = array(
                    'online_amount'=>$online_amount,
                    'cash_amount'=>$cash_amount,
                    'mediclaim_amount'=>$mediclaim_amount,
                    'total_amount'=>$total_amount,
                    'total_paid_amount'=>$total_paid_amount,
                    'remaining_amount'=>$remaining_amount,
                    'fk_patient_id'=>$fk_patient_id,
                    'fk_appointment_id'=>$fk_appointment_id,
                    'fk_payment_id'=>$fk_payment_id,
                    'added_by'=>$added_by,
                );
                $curl = $this->link->hits('update-payment-details', $data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']= $curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('payment_type' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }


     // ======================= Diseases =============================

    public function diseases()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $this->load->view('receptionist/diseases');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_diseases()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
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
                     $response['error'] = array('diseases' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_diseases_data()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');       
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
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
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
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
    // ======================== Add Location =============================
    public function add_location()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['state_data'] = $curl['state_data'];  
            $this->load->view('receptionist/visit_location',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }

    public function save_location_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $id = $session_data['id'];            
            $place_name = $this->input->post('place_name');
            $address1 = $this->input->post('address1');
            $address2 = $this->input->post('address2');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $pincode = $this->input->post('pincode');
            $this->form_validation->set_rules('place_name','Place Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'place_name' => strip_tags(form_error('place_name')),
                    'address1' => strip_tags(form_error('address1')),
                    'state' => strip_tags(form_error('state')),
                    'city' => strip_tags(form_error('city')),
                    'pincode' => strip_tags(form_error('pincode')),
                );
            } else {
                $curl_data = array(        
                    'place_name'=>$place_name,
                    'address1'=>$address1,
                    'address2'=>$address2,
                    'state'=>$state,
                    'city'=>$city,
                    'pincode'=>$pincode,                          
                );
                $curl = $this->link->hits('save-location', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array('place_name' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_location_data()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {

            $curl = $this->link->hits('display-all-location-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['location_details_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_location_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            // $id = $session_data['id'];            
            $place_name = $this->input->post('edit_place_name');
            $address1 = $this->input->post('edit_address1');
            $address2 = $this->input->post('edit_address2');
            $state = $this->input->post('edit_state');
            $city = $this->input->post('edit_city');
            $pincode = $this->input->post('edit_pincode');
            $id = $this->input->post('edit_id');
            $this->form_validation->set_rules('edit_place_name','Place Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required|exact_length[6]',array('required' => 'You must provide a %s','exact_length' => 'Pincode should be 6 digit number',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_place_name' => strip_tags(form_error('edit_place_name')),
                    'edit_address1' => strip_tags(form_error('edit_address1')),
                    'edit_state' => strip_tags(form_error('edit_state')),
                    'edit_city' => strip_tags(form_error('edit_city')),
                    'edit_pincode' => strip_tags(form_error('edit_pincode')),
                );
            } else {
                $curl_data = array(        
                    'place_name'=>$place_name,
                    'address1'=>$address1,
                    'address2'=>$address2,
                    'state'=>$state,
                    'city'=>$city,
                    'pincode'=>$pincode,  
                    'id'=>$id,                       
                );
                $curl = $this->link->hits('update-location', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array('edit_place_name' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }

    public function delete_location()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $id = $this->input->post('delete_location_id'); 
            if (empty($id)) {
                $response['message'] = 'Is is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-location',$curl_data);
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
    public function get_sub_type_data_on_appoitment_id()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {
            $admission_type = $this->input->post('admission_type');
            if (!empty($admission_type)) {
                $curl_data = array('id' => $admission_type);
                $curl = $this->link->hits('get-sub-type-data-on-appoitment-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                if (!empty($curl['appointment_sub_type'])) {
                    $response['status'] = 'success';
                    $response['appointment_sub_type'] = $curl['appointment_sub_type'];
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

     // ======================== Charges =============================

    public function add_charges()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $this->load->view('receptionist/add_charges');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_charges()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $id = $session_data['id'];
            $charges_name = $this->input->post('charges_name');           
            $this->form_validation->set_rules('charges_name','Charges', 'trim|required',array('required' => 'You must provide a %s',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'charges_name' => strip_tags(form_error('charges_name')),
                );
            } else {
                $curl_data = array(
                    'charges_name'=>$charges_name,                    
                );
                $curl = $this->link->hits('add-charges', $curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']= $curl['message'];
                } else {
                     $response['status'] = 'failure';
                     $response['error'] = array('charges_name' => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function display_all_charges_data()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in'))
        {
            $curl = $this->link->hits('display-all-charges-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['charges_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_charges_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');       
            $id = $this->input->post('edit_id');
            $edit_charges_name = $this->input->post('edit_charges_name');
            $this->form_validation->set_rules('edit_charges_name','charges_name', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_charges_name' => strip_tags(form_error('edit_charges_name')),
                );
            } else {
                $curl_data = array(
                    'charges_name'=>$edit_charges_name,
                    'id'=>$id,
                );
                $curl = $this->link->hits('update-charges', $curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('edit_charges_name'=> $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_charges()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $id = $this->input->post('delete_charges_id'); 
            if (empty($id)) {
                $response['message'] = 'Id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );         
                $curl = $this->link->hits('delete-charges',$curl_data);
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
    public function change_charges_status()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
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
                $curl = $this->link->hits('update-charges-status',$curl_data);
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
    public function get_payment_type_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
                $curl = $this->link->hits('get-appointment-data', array(), '', 0);  
                $curl = json_decode($curl, true);
                $response['payment_type'] = $curl['payment_type'];
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);  
    }

    public function add_appointment_advance_payment_details()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $added_by = $session_data['id'];
            $advance_fk_patient_id = $this->input->post('advance_fk_patient_id');
            $advance_fk_appointment_id = $this->input->post('advance_fk_appointment_id');
            $advance_amount = $this->input->post('advance_amount');
            $advance_payment_type = $this->input->post('advance_payment_type');
            $advance_payment_date = $this->input->post('advance_payment_date');

            $curl_data = array(
                'fk_patient_id'=>$advance_fk_patient_id,
                'fk_appointment_id'=>$advance_fk_appointment_id,
                'advance_amount'=>json_encode($advance_amount),
                'fk_payment_type'=>json_encode($advance_payment_type),
                'advance_payment_date'=>json_encode($advance_payment_date),
                'added_by'=>$added_by,
            );                     
            $curl = $this->link->hits('add-appointment-advance-payment-details', $curl_data);
            // echo '<pre>'; print_r($curl); exit;
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
                $response['msg']=$curl['message'];
            } else {
                $response['status'] = 'failure';
                $response['error'] = array('advance_amount' => $curl['message']);
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }

    public function add_appointment_charges_details()
    {
       if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $fk_patient_id = $this->input->post('fk_patient_id');
            $fk_appointment_id = $this->input->post('fk_appointment_id');
            $charges = $this->input->post('charges');
            $amount = $this->input->post('amount');
            $no_of_count = $this->input->post('unit');
            $total_amount = $this->input->post('total_amount');
            $date = $this->input->post('date');
            $dr_name = $this->input->post('dr_name');            
            $added_by = $session_data['id'];
                $curl_data = array( 
                    'fk_patient_id'=>$fk_patient_id,
                    'fk_appointment_id'=>$fk_appointment_id,               
                    'charges'=>json_encode($charges),
                    'amount'=>json_encode($amount),                   
                    'total_amount'=>json_encode($total_amount),
                    'no_of_count'=>json_encode($no_of_count),                   
                    'dr_name'=>json_encode($dr_name),
                    'date'=>json_encode($date),
                );                
                $curl = $this->link->hits('add-appointment-charges-details', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('payment_type' => $curl['message']);
                }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function update_discharge_date()
    {
        if ($this->session->userdata('feenixx_hospital_receptionists_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_receptionists_logged_in');
            $date_of_discharge = $this->input->post('date_of_discharge');
            $id = $this->input->post('id');
            
                $curl_data = array( 
                    'date_of_discharge'=>$date_of_discharge,
                    'id'=>$id,               
                );                
                $curl = $this->link->hits('update-discharge-date', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['msg']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array('date_of_discharge' => $curl['message']);
                }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }

    public function discharge_summary()
    {
        $this->load->view('discharge_summary');
    }
}
