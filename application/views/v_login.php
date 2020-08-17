<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=base_url()?>assets/img/favicon.gif" type="image/gif">
    <title>DKP Jawa Timur | Dashboard Fish Info</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/gentelella/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('assets/gentelella/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url('assets/gentelella/vendors/animate.css/animate.min.css') ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets/gentelella/build/css/custom.min.css') ?>" rel="stylesheet">
  </head>

  <style type="text/css">

    .login_content{
      text-shadow: none;
    }
    
  </style>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <center>
                <img src="<?php echo base_url('assets/img/logo.png') ?>" alt="..." class="img-responsive" width="260">
           </center>
             <br/>
            <form action="<?php echo base_url('auth/login') ?>" method="post">
              
                <h1>Login Form</h1>
                <?php echo $this->session->flashdata('pesan'); ?>
                <div>
                  <input type="text" name="user" class="form-control" placeholder="Kode" required="" />
                </div>
                <div>
                  <input type="password" name="passwd" class="form-control" placeholder="Kata Sandi" required="" />
                </div>
                <div>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Masuk </button>
                 
                  
                </div>
             </form>
              <div class="clearfix"></div>

              <div class="separator">
                <!--
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>
                -->

                <div class="clearfix"></div>
                <br /><br /><br />

                <div>
                  <p>&copy 2020 DKP Jawa Timur. All rights reserved <br/>Developed by <a style="color: blue;" title="PT.ALUGARA INOVASI UTAMA" href="https://alugarainovasi.com">AIU</a></p>
                </div>
              </div>
            
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
