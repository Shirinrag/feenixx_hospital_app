<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Doctor</title>
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
            <h1>Doctor</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Doctor</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <section class="section">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Add Doctor </h5>
                        <!-- Vertical Form -->
                        <?php echo form_open('superadmin/save_doctor_details', array('id'=>'save_doctor_details_form')) ?>            
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="first_name" class="form-label">First Name</label>
                                 <input type="text" class="form-control input-text" id="first_name" name="first_name" placeholder="Enter Your First Name">
                                 <span class="error_msg" id="first_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Last Name</label>
                                 <input type="text" class="form-control input-text" id="last_name" name="last_name" placeholder="Enter Your Last Name">
                                 <span class="error_msg" id="last_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="email" class="form-label">Email</label>
                                 <input type="text" class="form-control input-text" id="email" name="email" placeholder="Enter Your Email">
                                 <span class="error_msg" id="email_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="contact_no" class="form-label">Contact No</label>
                                 <input type="text" class="form-control input-text" id="contact_no" name="contact_no" placeholder="Enter Your Contact No" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="contact_no_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="password" class="form-label">Password</label>
                                 <input type="text" class="form-control input-text" id="password" name="password" placeholder="Enter Your Password">
                                 <span class="error_msg" id="password_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="dob" class="form-label">Date of Birth</label>
                                 <input type="text" class="form-control input-text datepicker" id="dob" name="dob" placeholder="Enter Your Date of Birth">
                                 <span class="error_msg" id="dob_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Specialization</label>
                                 <select class="form-group chosen-select-deselect" id="specialization" name="specialization" data-placeholder="Select Specialization">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($designation_data as $designation_data_key => $designation_data_row) { ?>
                                    <option value="<?=$designation_data_row['id']?>"><?=$designation_data_row['designation_name'] ?></option>
                                    <?php  }
                                       ?>                      
                                 </select>
                                 <span class="error_msg" id="specialization_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="gender" class="form-label">Gender</label>
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
                                 <label for="address1" class="form-label">Address 1</label>
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
                                 <label for="last_name" class="form-label">State</label>
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
                                 <label for="last_name" class="form-label">City</label>
                                 <select class="form-group chosen-select-deselect" name="city" id="city">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="city_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Pincode</label>
                                 <input type="text" class="form-control input-text" id="pincode" name="pincode" placeholder="Enter Your Pincode">
                                 <span class="error_msg" id="pincode_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Upload Image</label>
                                 <input type="file" class="form-control input-text" id="image" name="image" placeholder="Upload Image">
                                 <span class="error_msg" id="image_error"></span> 
                              </div>
                           </div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_doctor_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                              <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                           </div>
                        </div>
                        <?php echo form_close() ?>
                        <!-- Vertical Form -->
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Doctor List</h5>
                        <table class="table dt-responsive"  id="Doctor_table">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">First Name</th>
                                 <th scope="col">Last Name</th>
                                 <th scope="col">Email</th>
                                 <th scope="col">Contact</th>
                                 <th scope="col">Specialization</th>
                                 <!-- <th scope="col">Status</th> -->
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
      <div id="delete_doctor" class="modal fade">
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
                     <input type="text" name="delete_doctor_id" id="delete_doctor_id">
                     <button class="btn btn-primary" id="doctor_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="update_doctor_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Doctor</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <?php echo form_open('superadmin/update_doctor_details', array('id'=>'update_doctor_details_form')) ?> 
                      <div class="modal-body">                             
                        <div class="row">
                           <input type="hidden" name="edit_id" id="edit_id" class="form-control">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_first_name" class="form-label">First Name</label>
                                 <input type="text" class="form-control input-text" id="edit_first_name" name="edit_first_name" placeholder="Enter Your First Name">
                                 <span class="error_msg" id="edit_first_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_last_name" class="form-label">Last Name</label>
                                 <input type="text" class="form-control input-text" id="edit_last_name" name="edit_last_name" placeholder="Enter Your Last Name">
                                 <span class="error_msg" id="edit_last_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="email" class="form-label">Email</label>
                                 <input type="text" class="form-control input-text" id="edit_email" name="edit_email" placeholder="Enter Your Email" disabled>
                                 <span class="error_msg" id="edit_email_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_contact_no" class="form-label">Contact No</label>
                                 <input type="text" class="form-control input-text" id="edit_contact_no" name="edit_contact_no" placeholder="Enter Your Contact No" onkeypress="return isNumberKey(event)" disabled>
                                 <span class="error_msg" id="edit_contact_no_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_dob" class="form-label">Date of Birth</label>
                                 <input type="text" class="form-control input-text datepicker" id="edit_dob" name="edit_dob" placeholder="Enter Your Date of Birth">
                                 <span class="error_msg" id="edit_dob_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_specialization" class="form-label">Specialization</label>
                                 <select class="form-group chosen-select-deselect" id="edit_specialization" name="edit_specialization" data-placeholder="Select Specialization">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($designation_data as $designation_data_key => $designation_data_row) { ?>
                                    <option value="<?=$designation_data_row['id']?>"><?=$designation_data_row['designation_name'] ?></option>
                                    <?php  }
                                       ?>                      
                                 </select>
                                 <span class="error_msg" id="edit_specialization_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_gender" class="form-label">Gender</label>
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
                                 <label for="edit_address1" class="form-label">Address 1</label>
                                 <input type="text" class="form-control input-text" id="edit_address1" name="edit_address1" placeholder="Enter Your Address 1">
                                 <span class="error_msg" id="address1_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_address2" class="form-label">Address 2</label>
                                 <input type="text" class="form-control input-text" id="edit_address2" name="edit_address2" placeholder="Enter Your Address 2">
                                 <span class="error_msg" id="address2_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_state" class="form-label">State</label>
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
                                 <label for="edit_city" class="form-label">City</label>
                                 <select class="form-group chosen-select-deselect" name="edit_city" id="edit_city">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="edit_city_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_pincode" class="form-label">Pincode</label>
                                 <input type="text" class="form-control input-text" id="edit_pincode" name="edit_pincode" placeholder="Enter Your Pincode">
                                 <span class="error_msg" id="edit_pincode_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Upload Image</label>
                                 <input type="file" class="form-control input-text" id="edit_image" name="edit_image" placeholder="Upload Image">
                                 <span class="error_msg" id="edit_image_error"></span> <input type="hidden" name="last_inserted_image" id="last_inserted_image">
                              </div>
                           </div>
                           <div id="image_data"></div>
                           
                        </div>
                        
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="update_doctor_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Update</button>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/superadmin/doctor.js"></script>
   </body>
</html>