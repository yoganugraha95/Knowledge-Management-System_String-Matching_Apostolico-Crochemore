<!DOCTYPE html>
<html lang="id">

  <head>

	<meta http-equiv="content-type" content="text/html" />
    <meta name="description" content="Karyawan Knowledge Management Systems PT Titis Sampurna" />
	<meta name="author" content="Ayu Zahrah Humairoh" />
    <link rel="icon" href="<?php echo base_url(); ?>asset/image/favicon.ico" />
    <title>Karyawan KMS PT Titis Sampurna</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" /> 

    <!-- Font Awesome CSS -->
    <link href="<?php echo base_url();?>asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>asset/style/halaman.css" rel="stylesheet" /> 
    
    <!-- Summernote -->
    <link href="<?php echo base_url();?>asset/summernote/summernote-bs4.css" rel="stylesheet" /> 
    
    <!-- DataTables -->
    <link href="<?php echo base_url();?>asset/datatables/jquery.dataTables.css" rel="stylesheet" /> 

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="<?php echo base_url() ?>divisi">Knowledge Management Systems</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url() ?>sharing/home">Beranda
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url() ?>sharing/proses">Sharing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url() ?>capture">Capture</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url() ?>discovery">Discovery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url() ?>profil">Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>karyawan_login/logout_action">Log Out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>