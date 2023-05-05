<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Patient</title>
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
      <h1>Patient</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Patient</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
       

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Patient </h5>

              <!-- Vertical Form -->
              <form>              
            
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control input-text" id="first_name" name="first_name" placeholder="Enter Your First Name">
                  </div>
                  
                </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control input-text" id="last_name" name="last_name" placeholder="Enter Your Last Name">
                  </div>
                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Email</label>
                    <input type="text" class="form-control input-text" id="email" name="email" placeholder="Enter Your Email">
                  </div>
                  
                </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Contact No</label>
                    <input type="text" class="form-control input-text" id="email" name="email" placeholder="Enter Your Contact No" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Gender</label>
                    <select class="form-group chosen-select-deselect">
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Date of Birth</label>
                    <input type="text" class="form-control input-text datepicker" id="email" name="email" placeholder="Enter Your Date of Birth">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Material Status</label>
                    <select class="form-group chosen-select-deselect">
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Address 1</label>
                    <input type="text" class="form-control input-text" id="address" name="address" placeholder="Enter Your Address 1">
                  </div>                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Address 2</label>
                    <input type="text" class="form-control input-text" id="address" name="address" placeholder="Enter Your Address 2">
                  </div>                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">State</label>
                    <select class="form-group chosen-select-deselect">
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                </div>
                   <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">City</label>
                    <select class="form-group chosen-select-deselect">
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="form-label">Pincode</label>
                    <input type="text" class="form-control input-text" id="pincode" name="pincode" placeholder="Enter Your Pincode">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Insurance Provider</label>
                    <input type="text" class="form-control input-text" id="insurance_provider" name="insurance_provider" placeholder="Enter Your Insurance Provider">
                  </div>                 
                </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Policy Number</label>
                    <input type="text" class="form-control input-text" id="policy_number" name="policy_number" placeholder="Enter Your Policy Number">
                  </div>                 
                </div>
              </div>
              <div class="row">
                <h5 class="card-title" style="margin-left: 15px;"><strong>In Case of Emergency</strong></h5>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control input-text" id="emergency_contact_name" name="emergency_contact_name" placeholder="Enter Your Emergency Contact Name">
                  </div>                 
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address" class="form-label">Emergency Contact Number</label>
                    <input type="text" class="form-control input-text" id="emergency_contact_phone" name="emergency_contact_phone" placeholder="Enter Your Emergency Contact Number" onkeypress="return isNumberKey(event)">
                  </div>                 
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary button_style">Submit</button>
                  <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                </div>
              </div>
                </form><!-- Vertical Form -->

            </div>
          </div>

        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Patient List</h5>
                <table class="table" id="patient_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td> 
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>Designer</td>
                    <td><label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                    </td>
                    <td><div class="action-buttons">
                    <span class="edit" data-bs-toggle="modal" data-bs-target="#largeModal"><i class="bi bi-pencil-fill"></i></span> 
                    <span class="remove"><i class="bi bi-trash-fill"></i></span> 
                   
                    </div></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td> 
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>Designer</td>
                    <td><label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                    </td>
                    <td><div class="action-buttons">
                    <span class="edit"><i class="bi bi-pencil-fill"></i></span> 
                    <span class="remove"><i class="bi bi-trash-fill"></i></span> 
                   
                    </div></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td> 
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>Designer</td>
                    <td><label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                    </td>
                     <td><div class="action-buttons">
                    <span class="edit"><i class="bi bi-pencil-fill"></i></span> 
                    <span class="remove"><i class="bi bi-trash-fill"></i></span> 
                   
                    </div></td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td> 
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>Designer</td>
                    <td><label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                    </td>
                    <td><div class="action-buttons">
                    <span class="edit"><i class="bi bi-pencil-fill"></i></span> 
                    <span class="remove"><i class="bi bi-trash-fill"></i></span> 
                   
                    </div></td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Brandon Jacob</td>
                    <td>Designer</td> 
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                    <td>Designer</td>
                    <td><label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </label>
                    </td>
                     <td><div class="action-buttons">
                    <span class="edit"><i class="bi bi-pencil-fill "data-toggle="modal" data-target="#myModal"></i></span> 
                    <span class="remove"><i class="bi bi-trash-fill"></i></span> 
                   
                    </div></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <!-- Modal -->
   <div class="modal fade" id="largeModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Large Modal</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>


  <!-- ======= Footer ======= -->
   <?php include 'common/footer.php';?><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
   <?php include 'common/jsfiles.php';?>
   <script type="text/javascript" src="<?=base_url()?>assets/view_js/patient.js"></script>

</body>

</html>