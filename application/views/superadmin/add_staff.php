<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Add Staff</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      <!-- Favicons -->
      <?php include 'common/cssfiles.php';?>
   </head>
   <body>
      <!-- ======= Header ======= -->
      <?php include 'common/header.php';?><!-- End Header -->
      <!-- ======= Sidebar ======= -->
      <?php include 'common/sidebar.php';?><!-- End Sidebar-->
      <main id="main" class="main">
         <div class="pagetitle">
            <h1>Add Staff</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Add Staff</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <section class="section">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Add Staff </h5>
                        <!-- Vertical Form -->
                        <?php echo form_open('superadmin/save_staff_details', array('id'=>'save_staff_details_form')) ?>          
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="user_type" class="form-label required">Select Employee Type</label>
                                 <select class="form-group chosen-select-deselect" id="user_type" name="user_type" data-placeholder="Select Employee Type">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($user_type as $user_type_key => $user_type_row) { ?>
                                    <option value="<?=$user_type_row['id']?>"><?=$user_type_row['user_type'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="user_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="first_name" class="form-label required">First Name</label>
                                 <input type="text" class="form-control input-text" id="first_name" name="first_name" placeholder="Enter Your First Name">
                                 <span class="error_msg" id="first_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Last Name</label>
                                 <input type="text" class="form-control input-text" id="last_name" name="last_name" placeholder="Enter Your Last Name">
                                 <span class="error_msg" id="last_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Email</label>
                                 <input type="text" class="form-control input-text" id="email" name="email" placeholder="Enter Your Email">
                                 <span class="error_msg" id="email_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="contact_no" class="form-label required">Contact No</label>
                                 <input type="text" class="form-control input-text" id="contact_no" name="contact_no" placeholder="Enter Your Contact No" onkeypress="return isNumberKey(event)" maxlength="10">
                                 <span class="error_msg" id="contact_no_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="password" class="form-label required">Password</label>
                                 <input type="text" class="form-control input-text" id="password" name="password" placeholder="Enter Your Password">
                                 <span class="error_msg" id="password_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="gender" class="form-label required">Gender</label>
                                 <select class="form-group chosen-select-deselect" id="gender" name="gender" data-placeholder="Select Gender">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($gender_data as $gender_data_key => $gender_data_row) { ?>
                                    <option value="<?=$gender_data_row['id']?>"><?=$gender_data_row['gender'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="gender_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="dob" class="form-label required">Date of Birth</label>
                                 <input type="text" class="form-control input-text datepicker" id="dob" name="dob" placeholder="Enter Your Date of Birth">
                                 <span class="error_msg" id="dob_error"></span>
                              </div>
                           </div>
                           <!-- <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Marital Status</label>
                                 <select class="form-group chosen-select-deselect" name="marital_status" id="marital_status" data-placeholder="Select Marital Status">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($marital_status_data as $marital_status_data_key => $marital_status_data_row) { ?>
                                    <option value="<?=$marital_status_data_row['id']?>"><?=$marital_status_data_row['marital_status'] ?></option>
                                    <?php  }
                                       ?>     
                                 </select>
                                 <span class="error_msg" id="marital_status_error"></span> 

                              </div>
                           </div> -->
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address1" class="form-label required">Address 1</label>
                                 <input type="text" class="form-control input-text" id="address1" name="address1" placeholder="Enter Your Address 1">
                                 <span class="error_msg" id="address1_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label">Address 2</label>
                                 <input type="text" class="form-control input-text" id="address" name="address2" placeholder="Enter Your Address 2">
                                 <span class="error_msg" id="address2_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">State</label>
                                 <select class="form-group chosen-select-deselect" name="state" id="state" data-placeholder="Select State">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($state_data as $state_data_key => $state_data_row) { ?>
                                    <option value="<?=$state_data_row['id']?>"><?=$state_data_row['name'] ?></option>
                                    <?php  }
                                       ?>       
                                 </select>
                                 <span class="error_msg" id="state_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">City</label>
                                 <select class="form-group chosen-select-deselect" name="city" id="city" data-placeholder="Select City">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="city_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Pincode</label>
                                 <input type="text" class="form-control input-text" id="pincode" name="pincode" placeholder="Enter Your Pincode" onkeypress="return isNumberKey(event)" maxlength="6">
                                 <span class="error_msg" id="pincode_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="pan_card" class="form-label required">Upload Pan Card</label>
                                 <input type="file" class="form-control input-text" id="pan_card" name="pan_card" placeholder="Upload Insurance Document" accept="application/pdf">
                                 <span class="error_msg" id="pan_card_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="aadhar_card" class="form-label required">Upload Aadhar Card</label>
                                 <input type="file" class="form-control input-text" id="aadhar_card" name="aadhar_card" placeholder="Upload Insurance Document" accept="application/pdf">
                                 <span class="error_msg" id="aadhar_card_error"></span> 
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_patient_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           </div>
                        </div>
                         <?php echo form_close() ?><!-- Vertical Form -->
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Staff List</h5>
                        <table class="table dt-responsive" id="staff_table">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">First Name</th>
                                 <th scope="col">Last Name</th>
                                 <th scope="col">Email</th>
                                 <th scope="col">Contact</th>
                                 <th scope="col">Employee Type</th>
                                 <th scope="col">Action</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <!-- End #main -->
      <!-- Modal -->
      <div id="delete_staff" class="modal fade">
         <div class="modal-dialog modal-confirm">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Are you sure</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>Do you really want to delete these records? This process cannot be undone.</p>
               </div>
               <div class="modal-footer justify-content-center">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                  <form method="POST" id="delete-form">
                     <input type="hidden" name="delete_staff_id" id="delete_staff_id">
                     <button class="btn btn-primary" id="patient_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="update_staff_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Staff Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
                <?php echo form_open('superadmin/update_staff_details', array('id'=>'update_staff_details_form')) ?> 
               <div class="modal-body">
                 <div class="row">
                            <input type="hidden" name="edit_id" id="edit_id">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="patient_id" class="form-label required">Employee Type</label>
                                 <input type="text" class="form-control input-text" id="edit_user_type" name="edit_user_type" placeholder="Enter Your Patient ID" readonly>
                                 <span class="error_msg" id="edit_user_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="first_name" class="form-label required">First Name</label>
                                 <input type="text" class="form-control input-text" id="edit_first_name" name="edit_first_name" placeholder="Enter Your First Name">
                                 <span class="error_msg" id="edit_first_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Last Name</label>
                                 <input type="text" class="form-control input-text" id="edit_last_name" name="edit_last_name" placeholder="Enter Your Last Name">
                                 <span class="error_msg" id="edit_last_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Email</label>
                                 <input type="text" class="form-control input-text" id="edit_email" name="edit_email" placeholder="Enter Your Email" disabled>
                                 <span class="error_msg" id="edit_email_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="contact_no" class="form-label required">Contact No</label>
                                 <input type="text" class="form-control input-text" id="edit_contact_no" name="edit_contact_no" placeholder="Enter Your Contact No" maxlength="10" onkeypress="return isNumberKey(event)" disabled>
                                 <span class="error_msg" id="edit_contact_no_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="gender" class="form-label required">Gender</label>
                                 <select class="form-group chosen-select-deselect" id="edit_gender" name="edit_gender" data-placeholder="Select Gender">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($gender_data as $gender_data_key => $gender_data_row) { ?>
                                    <option value="<?=$gender_data_row['id']?>"><?=$gender_data_row['gender'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="edit_gender_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="dob" class="form-label required">Date of Birth</label>
                                 <input type="text" class="form-control input-text datepicker" id="edit_dob" name="edit_dob" placeholder="Enter Your Date of Birth">
                                 <span class="error_msg" id="edit_dob_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address1" class="form-label required">Address 1</label>
                                 <input type="text" class="form-control input-text" id="edit_address1" name="edit_address1" placeholder="Enter Your Address 1">
                                 <span class="error_msg" id="edit_address1_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label">Address 2</label>
                                 <input type="text" class="form-control input-text" id="edit_address2" name="edit_address2" placeholder="Enter Your Address 2">
                                 <span class="error_msg" id="edit_address2_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">State</label>
                                 <select class="form-group chosen-select-deselect" name="edit_state" id="edit_state" data-placeholder="Select State">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($state_data as $state_data_key => $state_data_row) { ?>
                                    <option value="<?=$state_data_row['id']?>"><?=$state_data_row['name'] ?></option>
                                    <?php  }
                                       ?>       
                                 </select>
                                 <span class="error_msg" id="edit_state_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">City</label>
                                 <select class="form-group chosen-select-deselect" name="edit_city" id="edit_city" data-placeholder="Select City">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="edit_city_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Pincode</label>
                                 <input type="text" class="form-control input-text" id="edit_pincode" name="edit_pincode" placeholder="Enter Your Pincode">
                                 <span class="error_msg" id="edit_pincode_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_pan_card" class="form-label required">Upload Pan Card</label>
                                 <input type="file" class="form-control input-text" id="edit_pan_card" name="edit_pan_card" placeholder="Upload Pan Card" accept="application/image*">
                                 <span class="error_msg" id="edit_pan_card_error"></span> 
                              </div>
                              <input type="hidden" name="last_inserted_pancard_document" id="last_inserted_pancard_document">
                              <br>
                              <div id="pancard_doc">
                                 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_aadhar_card" class="form-label required">Upload Aadhar Card</label>
                                 <input type="file" class="form-control input-text" id="edit_aadhar_card" name="edit_aadhar_card" placeholder="Upload Aadhar Card" accept="application/image*">
                                 <span class="error_msg" id="edit_aadhar_card_error"></span> 
                              </div>
                              <input type="hidden" name="last_inserted_aadhar_card_document" id="last_inserted_aadhar_card_document">
                              <br>
                              <div id="aadharcard_doc">
                                 
                              </div>
                           </div>
                        </div>
                        
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="update_staff_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Update</button>
               </div>
                <?php echo form_close() ?>
            </div>
         </div>
      </div>
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/superadmin/staff.js"></script>
   </body>
</html>