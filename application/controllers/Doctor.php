<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {
	public function __construct()
    {
        parent::__construct();       
    }
	public function dashboard()
    {
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_doctor_logged_in');
            $this->load->view('doctor/dashboard');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function add_patient()
    {
         if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_doctor_logged_in');
             $curl = $this->link->hits('get-all-common-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['gender_data'] = $curl['gender_data'];
            $data['marital_status_data'] = $curl['marital_status_data'];
            $data['state_data'] = $curl['state_data'];  
            $data['blood_group_data'] = $curl['blood_group_data'];   
            $data['patient_id'] = $curl['patient_id'];   
            $this->load->view('doctor/add_patient',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function save_patient_details()
    {
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_doctor_logged_in');
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
            $this->form_validation->set_rules('email','Last Name', 'trim|required|valid_email',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('marital_status','Marital Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('emergency_contact_name','Emergency Contact Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('emergency_contact_phone','Emergency Contact Phone', 'trim|required',array('required' => 'You must provide a %s',));
            
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
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
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
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_doctor_logged_in');
            // $id = $session_data['id'];            
            $id = $this->input->post('edit_id');
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
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_dob','Date of Birth', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_marital_status','Marital Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address1','Address 1', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_state','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_city','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_gender','Gender', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_emergency_contact_name','Emergency Contact Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_emergency_contact_phone','Emergency Contact Phone', 'trim|required',array('required' => 'You must provide a %s',));
            
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
                        );
                        $curl = $this->link->hits('update-patient', $curl_data);
                        // echo '<pre>'; print_r($curl); exit;
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                        } else {
                            $response['status'] = 'failure';
                            $response['error'] = array('first_name'=> $curl['message']);
                        }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response);
    }
    public function delete_patient()
    {
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
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
        if ($this->session->userdata('feenixx_hospital_doctor_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_doctor_logged_in');
            $curl = $this->link->hits('get-appointment-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['patient_data'] = $curl['patient_data'];
            $data['diseases_data'] = $curl['diseases_data'];
            $this->load->view('doctor/appointment',$data);
         } else {
            redirect(base_url().'superadmin');
         }
    }
    public function get_patient_details_on_patient_id()
    {
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in'))
        {
            $id = $this->input->post('id');
            if (!empty($id)) {
                $curl_data = array('id' => $id);
                $curl = $this->link->hits('get-patient-details-on-patient-id', $curl_data);
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
        if ($this->session->userdata('feenixx_hospital_superadmin_logged_in')) {
            $session_data = $this->session->userdata('feenixx_hospital_superadmin_logged_in');
            $id = $session_data['id'];
            $patient_id = $this->input->post('patient_id');
            $patient_id_1 = $this->input->post('patient_id_1');
            $appointment_date = $this->input->post('appointment_date');
            $fk_diseases_id = $this->input->post('fk_diseases_id');
            $appointment_time = $this->input->post('appointment_time');
            $description = $this->input->post('description');
            $payment_type = $this->input->post('payment_type');
            $online_amount = $this->input->post('online_amount');
            $cash_amount = $this->input->post('cash_amount');
            $mediclaim_amount = $this->input->post('mediclaim_amount');
            $discount = $this->input->post('discount');
            $total_amount = $this->input->post('total_amount');
            $this->form_validation->set_rules('patient_id','Patient ID', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('appointment_date','Appointment Date', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('appointment_time','Appointment Time', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_diseases_id','Diseases', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('description','Description', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('payment_type','Payment Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('online_amount','Online Amount', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('cash_amount','Cash Amount', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('mediclaim_amount','Mediclaim Amount', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('discount','Discount', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('total_amount','Total Amount', 'trim|required',array('required' => 'You must provide a %s',));            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'patient_id' => strip_tags(form_error('patient_id')),
                    'fk_diseases_id' => strip_tags(form_error('fk_diseases_id')),
                    'description' => strip_tags(form_error('description')),
                    'appointment_date' => strip_tags(form_error('appointment_date')),
                    'appointment_time' => strip_tags(form_error('appointment_time')),
                    'payment_type' => strip_tags(form_error('payment_type')),
                    'online_amount' => strip_tags(form_error('online_amount')),
                    'cash_amount' => strip_tags(form_error('cash_amount')),
                    'discount' => strip_tags(form_error('discount')),
                    'mediclaim_amount' => strip_tags(form_error('mediclaim_amount')),
                    'total_amount' => strip_tags(form_error('total_amount')),
                );
            } else {
                $upload_data = 'uploads/pescription/'.$patient_id_1;
                if (!empty($upload_data)) {
                    mkdir($upload_data, 0777, TRUE);
                }
                $sample_image = '';
                $is_signature_file = true;
                if (!empty($_FILES['pescription']['name'])) {
                    $filename = $_FILES['pescription']['name'];
                    $test_img = $filename;
                    $test_img = preg_replace('/\s/', '_', $test_img);
                    $test_image = mt_rand(100000, 999999) . '_' .$test_img;
                    $setting['image_path'] = $_FILES['pescription']['tmp_name'];
                    $setting['image_name'] = $test_image;
                    $setting['compress_path'] = $upload_data;
                    $setting['jpg_compress_level'] = 5;
                    $setting['png_compress_level'] = 5;
                    $setting['create_thumb'] = FALSE;
                    $this->load->library('imgcompressor');
                    $results = $this->imgcompressor->do_compress($setting);
                    if (empty($results['data']['compressed']['name'])) {
                        $is_signature_file = false;
                        $response['status'] = 'failure';
                        $response['error'] = array(
                            'pescription' => $results['message'],
                        );
                    } else {
                        $sample_image = $upload_data.$test_image;
                    }
                }else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('image' => "Image required",);
                }
               
                if ($is_signature_file) {
                        $curl_data = array(
                            'patient_id'=>$patient_id,
                            'appointment_time'=>$appointment_time,
                            'appointment_date'=>$appointment_date,
                            'fk_diseases_id'=>$fk_diseases_id,
                            'payment_type'=>$payment_type,
                            'description'=>$description,
                            'cash_amount'=>$cash_amount,
                            'online_amount'=>$online_amount,
                            'mediclaim_amount'=>$mediclaim_amount,
                            'discount'=>$discount,
                            'total_amount'=>$total_amount,
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
}
