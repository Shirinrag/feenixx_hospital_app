<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
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

  <!-- ======= Header ======= -->
  <?php include 'common/header.php';?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <?php include 'common/sidebar.php';?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Total Doctor Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_doctor"><div class="card-body">
                  <h5 class="card-title"><strong> Total Doctors </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$doctor_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Doctor Card -->
            <!-- Total Active Doctor Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_doctor"><div class="card-body">
                  <h5 class="card-title"><strong> Total Active Doctors </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$active_doctor_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Active Doctor Card -->
            <!-- Total Inactive Doctor Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_doctor"><div class="card-body">
                  <h5 class="card-title"><strong> Total Inactive Doctors </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$inactive_doctor_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Inactive Doctor Card -->
            <!-- Total Male Doctor Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_doctor"><div class="card-body">
                  <h5 class="card-title"><strong> Total Male Doctor </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gender-male"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$male_doctor_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Male Doctor Card -->
            <!-- Total Female Doctor Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title"><strong> Total Female Doctor </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gender-female"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$female_doctor_count?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Total Female Doctor Card -->
            <!-- Total Patient Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_patient"><div class="card-body">
                  <h5 class="card-title"><strong> Total Patients </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$patient_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Patient Card -->
            <!-- Total Male Patient Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_patient"><div class="card-body">
                  <h5 class="card-title"><strong> Total Male Patients </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gender-male"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$male_patient_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Male Patient Card -->
            <!-- Total Female Patient Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_patient"><div class="card-body">
                  <h5 class="card-title"><strong> Total Female Patients </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gender-female"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$female_patient_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Female Patient Card -->
            <!-- Total Female Patient Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <a href="<?= base_url()?>superadmin/add_patient"><div class="card-body">
                  <h5 class="card-title"><strong> Total Transgender Patients </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gender-trans"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$transgender_patient_count?></h6>
                    </div>
                  </div>
                </div></a>

              </div>
            </div><!-- End Total Female Patient Card -->
            <!-- Total Diseases Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title"><strong> Total Diseases </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-virus"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$diseases_count?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Total Diseases Card -->
            <!-- Total Appointment Card -->
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title"><strong> Total Appointment </strong></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-calendar2-plus"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?=$appointment_count?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Total Appointment Card -->
          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
   <?php include 'common/footer.php';?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
   <?php include 'common/jsfiles.php';?>

</body>

</html>