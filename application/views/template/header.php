<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <meta name="app-url" content="<?= base_url(); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <style>
    .hr-full-width {
      margin-left: -1.25rem; /* Matches Bootstrap's default .card-header padding */
      margin-right: -1.25rem; /* Matches Bootstrap's default .card-header padding */
      margin-top: -5px;
      margin-bottom: 10px;
    }
    .card-title
    {
      color:DarkMagenta;
      font-size:25px;
      font-weight:550;
      margin:5px;
    }
    .client
    {
      float:right;
      margin-right:20px;
    }
    .branch
    {
      float:right;
      margin-right:20px;
    }

    .input-warning { border: 2px solid orange !important; }
    .input-success { 
      border: 2px solid green !important;
      background-image: url('https://cdn-icons-png.flaticon.com/512/845/845646.png');
      background-size: 20px;
      background-repeat: no-repeat;
      background-position: right 10px center;
    }
    .input-error {
      border: 2px solid red !important;
      background-image: url('https://cdn-icons-png.flaticon.com/512/1828/1828665.png');
      background-size: 20px;
      background-repeat: no-repeat;
      background-position: right 10px center;
    }
    .error-msg {
      color: red;
      font-size: 16;
      margin-top: 12px;
    }
    .payModebtn {
      background: #e8f2fb;
      color: black;
      padding: 6px 12px;
      margin: 4px;
      border-radius: 4px;
      display: inline-block;
      font-size: 14px;
    }
    #update h1
    {
      font-size:200px;
      color:blue;
    }
    #createBtn
    {
      float:right;
      margin-right:20px;
      margin:3px;
    }
    #exportButtons .btn {
      margin-right: 5px;
    }

    #dataTableSearch input {
      width: 220px;
    }
  </style>
</head>