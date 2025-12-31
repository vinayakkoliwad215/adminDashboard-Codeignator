<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="app-url" content="<?= base_url(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <!-- DataTables -->
    <link rel="stylesheet" 
        href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" 
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    @media (max-width: 768px) {
        .modal-body .form-group label {
            font-size: 14px;
        }
        .btn {
            margin-bottom: 8px;
        }
    }
    </style>
    <style>
        /* small layout tweaks */
        body { padding-top: 0px; }
        .sidebar { min-height: 250vh; border-right: 1px solid #eee; }
        .sidebar .nav-link.active { background: #f0f0f0; font-weight:600; }
        .card-header .d-flex > * { align-self: center; }
        .total-row {
            background-color: #fff8c4;   /* light yellow */
            font-weight: bold;
        }
        .payModebtn {
            display: inline-block;
            background: #35f75fff;   
            color: #f30909d2;              
            padding: 6px 14px;       
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin: 3px;
        }
        #loginsmsTable td {
            white-space: normal !important;   /* Allow multi-line */
            word-break: break-word !important; /* Force wrapping */
            max-width: 300px;                 /* Prevent very wide column */
        }
        .sidebarmenus {
            background-color: #004085;      /* Blue background */
            height: 100vh;                  /* Optional full height */
        }

        .sidebarmenus .nav-link {
            color: #ffffff;                 /* White text */
            padding: 10px 15px;
            border-radius: 4px;
            transition: 0.3s;
        }

        /* Hover effect */
        .sidebarmenus .nav-link:hover {
            background-color: #ffffff;      /* White background */
            color: #004085 !important;      /* Blue text */
        }

        /* Active menu */
        .sidebarmenus .nav-link.active {
            background-color: #ffffff !important; /* Active white background */
            color: #004085 !important;            /* Active blue text */
            font-weight: bold;                    /* Optional */
        }
        .is-invalid {
            border: 1px solid red !important;
        }
        table.dataTable tbody td[rowspan] {
            vertical-align: middle !important;
        }
        @media print {
        table td[rowspan] {
            vertical-align: middle !important;
        }
        table, th, td {
            border: 1px solid #000 !important;
        }
        }
        /* Dashboard section only */
        .dashboard-section .small-box {
            border-radius: 0.25rem;
            position: relative;
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            color: #fff;
            overflow: hidden;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        }

        .dashboard-section .small-box .inner h3 {
            font-size: 2.4rem;
            font-weight: bold;
            margin: 0;
        }

        .dashboard-section .small-box .inner p {
            font-size: 1.1rem;
        }

        .dashboard-section .small-box .icon {
            position: absolute;
            right: 15px;
            top: 32%;
            transform: translateY(-50%);
            opacity: 0.3;
        }

        .dashboard-section .small-box .icon i {
            font-size: 50px;
        }

        .dashboard-section .small-box-footer {
            display: block;
            padding: 3px 0;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
        }

        .dashboard-section .small-box-footer:hover {
            opacity: 0.8;
        }

        .small-box {
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: .4s;
        }

        .small-box .inner {
            padding: 12px;
        }

        .small-box .icon {
            position: absolute;
            top: 5px;
            right: 15px;
            opacity: 0.25;
            transition: .5s;
        }

        .small-box:hover .icon {
            opacity: 0.5;
            transform: scale(1.1);
        }

        .small-box-footer {
            display: block;
            padding: 5px 0;
            font-weight: bold;
            color: #fff !important;
            /* background: rgba(255, 255, 255, 0.15); transparent */
            /* border-top: 1px solid rgba(255, 255, 255, 0.20); */
            transition: .4s;
        }

        .small-box-footer i {
            font-size: 12px;
            margin-left: 5px;
        }

        .small-box:hover .small-box-footer {
            background: rgba(255, 255, 255, 0.30);
        }
        small
        {
            font-size:15px;
            color:Blue;
        }
        .main-header .navbar .navbar-expand .navbar-white .navbar-light .fixed-top {
            border-bottom: 1px solid #ddd;
            z-index: 100;
        }
        .dashboard-section {
        padding-top: 10px;
        }
        .navbar-nav > .user-menu .user-image {
            float: left;
            width: 2rem;
            height: 2rem;
            margin-top: -2px;
            border-radius: 50%;
        }
        .rounded-circle {
            border-radius: 50% !important;
        }
        .navbar-nav > .user-menu > .dropdown-menu > li.user-header {
            min-height: 175px;
            padding: 10px;
            text-align: center;
        }
        .navbar-nav > .user-menu > .dropdown-menu > li.user-header > img {
            z-index: 5;
            width: 90px;
            height: 90px;
            border: 3px solid;
            border-color: transparent;
            border-color: var(--bs-border-color-translucent);
        }
        .navbar-nav > .user-menu > .dropdown-menu > li.user-header > p {
            z-index: 5;
            margin-top: 10px;
            font-size: 17px;
            word-wrap: break-word;
        }
        .navbar-nav > .user-menu > .dropdown-menu > li.user-header > p > small, .navbar-nav > .user-menu > .dropdown-menu > li.user-header > p > .small {
            display: block;
            font-size: 12px;
        }
        .payModebtn {
            background: #ffa600ff;
            color: black;
            padding: 6px 12px;
            margin: 4px;
            border-radius: 4px;
            display: inline-block;
            font-size: 14px;
        }
        /* thead { 
            display: table-header-group !important;
        }
        tfoot { 
            display: table-footer-group !important;
        } */
        #pdf-wrapper table thead {
            display: table-header-group !important;
        }
        #pdf-wrapper table tfoot {
            display: table-footer-group !important;
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
            font-size: 13px;
            margin-top: -5px;
            margin-bottom: 5px;
        }

        .field-wrapper {
        margin-bottom: 20px;
        position: relative;
    }

    input.valid {
        border: 2px solid #28a745 !important;
    }
    input.invalid {
        border: 2px solid red !important;
    }

    .error-msg {
        color: red;
        font-size: 13px;
        margin-top: 3px;
    }
    </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">