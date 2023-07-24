<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Button Inline Loader Example</title>
<!-- <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/darkly/bootstrap.min.css"> -->
<?php include 'common/cssfiles.php';?>
<style>
  .container { margin: 150px auto; max-width: 350px; }
  </style>
</head>

<body>
  <div class="container">
    <h1>Bootstrap Button Inline Loader Example</h1>
    <p>A small jQuery plugin to create Stateful Buttons that display an inline loader inside Bootstrap 4 buttons to show the state of processes like AJAX requests.</p>
    <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    <small id="passwordHelp" class="form-text text-muted">At Least 8 characters</small>
  </div>
    <button class="btn btn-danger btn-block button-loader btn-lg" data-loading-text="<i class='fa fa-spinner fa-spin'></i> My button with loader" type="submit">
    <i class="fal fa-sign-in"></i>
    Sign In
</button>
</form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/button-inline-loader.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
 <script src="<?=base_url()?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <!-- <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <!-- Template Main JS File -->
  <script src="<?=base_url()?>assets/js/main.js"></script>

  <script src="<?=base_url()?>assets/view_js/form.js"></script>
<script>
  $('.btn').on('click', function(){
    // alert();
  $('.button-loader').button('loading');
  setTimeout(function(){ $('.button-loader').button('reset'); }, 5000);

})
</script>

</body>
</html>
