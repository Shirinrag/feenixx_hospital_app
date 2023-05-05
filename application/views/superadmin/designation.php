<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Designation</title>
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
      <h1>Designation</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Designation</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
       

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Designation Form</h5>

              <!-- Vertical Form -->
              <form class="row ">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="inputNanme4" class="form-label">Designation</label>
                    <input type="text" class="form-control" id="inputNanme4">
                  </div>
                  
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary button_style">Submit</button>
                  <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>

        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Designation List</h5>
                <table class="table" id="designation_table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Brandon Jacob</td>
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
                    <th scope="row">2</th>
                    <td>Bridie Kessler</td>
                    <td>Developer</td>
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
                    <td>Ashleigh Langosh</td>
                    <td>Finance</td>
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
                    <td>Angus Grady</td>
                    <td>HR</td>
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
                    <td>Raheem Lehner</td>
                    <td>Dynamic Division Officer</td>
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
   <?php include 'common/footer.php';?><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
   <?php include 'common/jsfiles.php';?>
   <script type="text/javascript" src="<?=base_url()?>assets/view_js/designation.js"></script>

</body>

</html>