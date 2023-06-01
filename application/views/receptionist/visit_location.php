<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Add Location</title>
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
            <h1>Add Location</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Add Location</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <section class="section">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Add Patient </h5>
                        <!-- Vertical Form -->
                        <?php echo form_open('receptionist/save_location_details', array('id'=>'save_location_details_form')) ?>          
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="place_name" class="form-label required">Place Name</label>
                                 <input type="text" class="form-control input-text" id="place_name" name="place_name" placeholder="Enter Your Place Name">
                                 <span class="error_msg" id="place_name_error"></span>
                              </div>
                           </div>
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
                                 <input type="text" class="form-control input-text" id="pincode" name="pincode" placeholder="Enter Your Pincode">
                                 <span class="error_msg" id="pincode_error"></span> 
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
                        <h5 class="card-title">Location List</h5>
                        <table class="table dt-responsive" id="location_table">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Name</th>
                                 <th scope="col">Address</th>
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
      <div id="delete_location" class="modal fade">
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
                     <input type="hidden" name="delete_location_id" id="delete_location_id">
                     <button class="btn btn-primary" id="location_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="update_location_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Location</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
                <?php echo form_open('receptionist/update_location_details', array('id'=>'update_location_details_form')) ?> 
               <div class="modal-body">
                 <div class="row">
                            <input type="hidden" name="edit_id" id="edit_id">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_place_name" class="form-label required">Place Name</label>
                                 <input type="text" class="form-control input-text" id="edit_place_name" name="edit_place_name" placeholder="Enter Your Place Name">
                                 <span class="error_msg" id="edit_place_name_error"></span>
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
                                 <label for="address" class="form-label required">Address 2</label>
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
                           
                        </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="update_patient_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Update</button>
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
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/receptionist/visit_location.js"></script>
   </body>
</html>