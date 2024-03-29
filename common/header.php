<?php 
    $controller = $this->uri->segment(1);
    $session_name = get_session_name(lcfirst($controller));
    $session_data = $this->session->userdata($session_name);
    // echo '<pre>'; print_r($session_data); exit;
    $curl = $this->link->hits('get-user-type-on-id', array('id'=>$session_data['fk_user_type']));
    $curl = json_decode($curl, true);
    $curl_1 = $this->link->hits('get-doctor-details',array('id'=>$session_data['fk_id']));
    $curl_1 = json_decode($curl_1, true);
?>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?=base_url()?>assets/img/logo.png" alt="">
        <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <!-- End Messages Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <?php if(@$curl_1['doctor_data']['fk_gender_id'] ==1){
            ?>
            <img src="<?=base_url()?>assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <?php }else { ?>
               <img src="<?=base_url()?>assets/img/female.png" alt="Profile" class="rounded-circle">
            <?php }?>
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=@$session_data['first_name']." ".@$session_data['last_name']?><br>
            <?= $curl['user_type'];?></span>

          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?=@$session_data['first_name']." ".@$session_data['last_name']?>                
              </h6>
              <!-- <span>Web Designer</span> -->
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url();?>common/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>
  <div id="loader">
    
  </div>