<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

   <?php include 'common/cssfiles.php';?>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="javascript:void(0)" class="logo d-flex align-items-center w-auto">
                  <img src="<?=base_url();?>assets/img/logo.png" alt="">
                  <!-- <span class="d-none d-lg-block">Feenixx Hospital</span> -->
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>
                   <?php echo form_open('common/login', array('id'=>'login_form')) ?>
                  <div class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="login_email" class="form-control" id="login_email" required>
                        <div class="invalid-feedback">Please enter your Email.</div>
                      </div>
                      <span class="error_msg" id="login_email_error"></span>
                    </div>

                    <div class="col-12">
                      <label for="login_password" class="form-label">Password</label>
                      <input type="password" name="login_password" class="form-control" id="login_password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <span class="error_msg" id="login_password_error"></span>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" id="login_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Login</button>
                    </div>
                  </div>
                   <?php echo form_close() ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
 <?php include 'common/jsfiles.php';?>
  <script src="<?=base_url()?>assets/view_js/login.js"></script>

</body>

</html>