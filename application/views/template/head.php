<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/img/favicon.gif" type="image/gif">

    <title>DKP Jawa Timur | Dashboard Fish Info</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">


    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/gentelella/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">

   <!-- NProgress -->
    <link href="<?php echo base_url('assets/gentelella/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">

    <!-- iCheck -->
    <link href="<?php echo base_url('assets/gentelella/vendors/iCheck/skins/flat/green.css') ?>" rel="stylesheet">
    
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url('assets/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') ?>" rel="stylesheet">

    <!-- JQVMap -->
    <link href="<?php echo base_url('assets/gentelella/vendors/jqvmap/dist/jqvmap.min.css') ?>" rel="stylesheet"/>

    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">

    <!-- Animate.css -->
    <link href="<?php echo base_url('assets/gentelella/vendors/animate.css/animate.min.css') ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets/gentelella/build/css/custom.min.css') ?>" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/gentelella/vendors/jquery/dist/jquery.min.js') ?>"></script> 
    <link href="<?php echo base_url('assets/gentelella/vendors/jquery-ui/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>

    <!-- data tables -->
    <link href="<?php echo base_url('assets/gentelella/vendors/DataTables-1.10/media/css/dataTables.bootstrap.min.css') ?>" rel="stylesheet">

    <!-- select2 -->
    <link href="<?php echo base_url('assets/gentelella/vendors/select2/dist/css/select2.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/gentelella/vendors/select2/dist/js/select2.min.js') ?>"></script>

    <!--sweet alert2 -->
    <script src="<?php echo base_url('assets/gentelella/vendors/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>


    <!-- Date Picker  -->
    <link href="<?php echo base_url('assets/gentelella/vendors/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />

    <!-- ionicon -->
    <link href="<?php echo base_url('assets/gentelella/vendors/Ionicons/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- pure-css-loader -->
    <link href="<?php echo base_url('assets/gentelella/vendors/pure-css-loader/dist/css-loader.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Highchart -->
     <link href="<?php echo base_url('assets/gentelella/vendors/highcharts/css/highcharts.css') ?>" rel="stylesheet" type="text/css" />
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/highcharts.js" ?>></script>
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/highcharts-more.js" ?>></script>
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/modules/exporting.js" ?>></script>
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/modules/export-data.js" ?>></script>
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/modules/accessibility.js" ?>></script>
     <script src=<?php echo base_url()."assets/gentelella/vendors/highcharts/modules/offline-exporting.js" ?>></script>
  
    <style type="text/css">
        .content_head{
            padding-bottom: 20px;

        }

        .modal-content .modal-header{
            background-color: #1b70dd;
            color: white;
        }

        ul.breadcrumb {
          padding: 8px 16px;
          list-style: none;
          background-color: #eee;
          text-align: right;

        }
        ul.breadcrumb li {
          display: inline;
          font-size: 13px;
        }
        ul.breadcrumb li+li:before {
          padding: 8px;
          color: black;
          content: "/\00a0";
        }
        ul.breadcrumb li a {
          color: #0275d8;
          text-decoration: none;
        }
        ul.breadcrumb li a:hover {
          color: #01447e;
          text-decoration: underline;
        }

        .x_title-h2 {
          font-weight: bold;
        }

        .panel-btn{
          text-align: right;
          padding-top: 5%;
        }

        tbody>tr>td{
          text-align: center;
          font-size: 11px;
        }

        thead>tr>th{
          text-align: center;
          font-size: 12px;
        }

        table .removeRow
        {
         background-color:  #c4f7f3;
            color:  #2e92f6  ;
        }


    /* STYLE GRAFIK DUAL BAR 
        .highcharts-figure, .highcharts-data-table table {
                min-width: 310px; 
                max-width: 100%;
                margin: 1em auto;
          }

          .highcharts-data-table table {
              font-family: Verdana, sans-serif;
              border-collapse: collapse;
              border: 1px solid #EBEBEB;
              margin: 10px auto;
              text-align: center;
              width: 100%;
              max-width: 500px;
          }
          .highcharts-data-table caption {
              padding: 1em 0;
              font-size: 1.2em;
              color: #555;
          }
          .highcharts-data-table th {
              font-weight: 600;
              padding: 0.5em;
          }
          .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
              padding: 0.5em;
          }
          .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
              background: #f8f8f8;
          }
          .highcharts-data-table tr:hover {
              background: #f1f7ff;
          }

          .highcharts-color-0 {
              fill: #7cb5ec;
              stroke: #7cb5ec;
          }
          .highcharts-axis.highcharts-color-0 .highcharts-axis-line {
              stroke: #7cb5ec;
          }
          .highcharts-axis.highcharts-color-0 text {
              fill: #7cb5ec;
          }
          .highcharts-color-1 {
              fill: #60b94e;
              stroke: #60b94e;
          }
          .highcharts-axis.highcharts-color-1 .highcharts-axis-line {
              stroke: #60b94e;
          }
          .highcharts-axis.highcharts-color-1 text {
              fill: #60b94e;
          }


          .highcharts-yaxis .highcharts-axis-line {
              stroke-width: 2px;
          }

     END GRAFIK */
    </style>  