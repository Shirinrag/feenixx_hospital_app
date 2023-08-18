<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Specialization</title>
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
      <h1>Specialization</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Specialization</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
       

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Specialization Form</h5>

              <!-- Vertical Form -->
               <?php echo form_open('superadmin/save_specialization', array('id'=>'save_specialization_form')) ?>
               <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="inputNanme4" class="form-label">Specialization</label>
                    <input type="text" class="form-control input-text" id="designation_name" name="designation_name" placeholder="Enter Specialization">
                    <span class="error_msg" id="designation_name_error"></span>
                  </div>
                  
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary button_style" id="add_specialization_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                </div>
              <?php echo form_close() ?><!-- Vertical Form -->

            </div>
          </div>

        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Specialization List</h5>
                <table class="table" id="Specialization_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <!-- Modal -->
      <div id="delete_specialization" class="modal fade">
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
                     <input type="hidden" name="delete_specialization_id" id="delete_specialization_id">
                     <button class="btn btn-primary" id="specialization_del_button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading"  type="submit">Delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="update_specialization_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Specialization</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <?php echo form_open('superadmin/update_specialization_details', array('id'=>'update_specialization_details_form')) ?> 
                      <div class="modal-body">                             
                        <div class="row">
                           <input type="hidden" name="edit_id" id="edit_id" class="form-control">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="edit_specialization" class="form-label required">Specialization</label>
                                 <input type="text" class="form-control input-text" id="edit_specialization" name="edit_specialization" placeholder="Enter Specialization">
                                 <span class="error_msg" id="edit_specialization_error"></span>
                              </div>
                           </div>
                        </div>    
                    </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="update_specialization_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Update</button>
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
   <script type="text/javascript" src="<?=base_url()?>assets/view_js/superadmin/specialization.js"></script>

</body>

</html>