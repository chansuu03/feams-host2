<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Faculty and Employee Association Management System</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav" style="background-color: #F4F6F9;">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark navbar-dark">
    <div class="container">
      <a href="<?= base_url();?>" class="navbar-brand">
        <img src="<?= base_url()?>/public/img/puplogo.png" alt="PUP Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">PUPTFEA</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?= base_url();?>" class="nav-link">Home</a>
          </li>
          <?php if(session()->get('isLoggedIn') == TRUE):?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url();?>/user/<?= esc($user['username'])?>">Profile <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url();?>/file_sharing">Files</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url();?>/discussions">Discussions</a>
            </li>
            <?php if(session()->get('role') == '1'): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url();?>/admin/dashboard">Dashboard</a>
            </li>
            <?php endif ?>
          <?php endif ?>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <?php if(!session()->get('isLoggedIn')):?>
            <span style="color: #adb5bd">Already have an account?</span> <a href="<?= base_url()?>/login" class="ml-1"> Login</a>
          <?php else:?>
            <span style="color: #adb5bd">Welcome <?= $user_details['username']?>,</span>  <a href="<?= base_url()?>/logout" class="ml-1"> Logout</a>
          <?php endif?>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

<!-- carousel -->
<div id="carousel" class="carousel slide mt-3 ml-2 mr-2" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" style="height: 340px;">
      <img class="d-block w-100" src="<?= base_url()?>/public/img/welcome.png" alt="First slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>FEAMS</h5>
            <p>Welcome to FEAMS</p>
          </div>
    </div>
    <?php foreach($sliders as $slider):?>
        <div class="carousel-item" style="height: 340px;">
          <img class="d-block w-100" src="<?= base_url()?>/public/uploads/sliders/<?= esc($slider['image'])?>" alt="Second slide" style="height: inherit; object-fit: cover;">
          <div class="carousel-caption d-none d-md-block">
            <h5><?= esc($slider['title'])?></h5>
            <?= esc($slider['description'], 'raw')?>
          </div>
        </div>
    <?php endforeach;?>
  </div>
  <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h3 class="text-danger"><i class="fas fa-newspaper"></i> Association News</h3>
            <ul class="list-group list-group-flush">
              <?php if(empty($news)):?>
                <li class="list-group-item text-center" style="background: transparent;">
                  <div class="row">
                    <div class="col-md-12">
                      <span>No current news uploaded</span>
                    </div>
                  </div>
                </li>
              <?php endif?>
              <?php foreach($news as $news):?>
                <li class="list-group-item" style="background: transparent;">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="<?= base_url()?>/public/uploads/news/<?= esc($news['image'])?>" alt="<?= esc($news['title'])?>" class="img-thumbnail">
                    </div>
                    <div class="col-md-8">
                      <a href="<?= base_url()?>/news/<?= esc($news['id'])?>"><h5><?= esc($news['title'])?></h5></a>
                      <p class="card-text"><?=ucfirst(substr(strip_tags($news['content']),0,300)) . '...'?></p>
                    </div>
                  </div>
                </li>
              <?php endforeach?>
              <?php if(!empty($news)):?>
                <li class="list-group-item" style="background: transparent;">
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                      <a href="<?= base_url()?>/news" class="btn btn-outline-primary w-100 text-center" role="button">View more</a>
                      <!-- <button type="button" class="btn btn-outline-primary w-100 text-center">View more</button> -->
                    </div>
                  </div>
                </li>
              <?php endif?>
            </ul>
          </div>
          <div class="col-md-4">
            <h3 class="text-danger"><i class="fas fa-bullhorn"></i> Announcements</h3>
            <ul class="list-group list-group-flush">
              <?php foreach($announces as $announce):?>
                <a href="<?= base_url()?>/announcements/<?= esc($announce['link'], 'raw')?>" class="list-group-item list-group-item-action" style="background: transparent;"><?= esc($announce['title'])?></a>
              <?php endforeach?>
              <li class="list-group-item" style="background: transparent;">
                <div class="row">
                  <div class="col-md-8 offset-md-2">
                    <a href="<?= base_url('announcements')?>" class="btn btn-outline-primary w-100 text-center" role="button">View more</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer mt-3">
    <!-- To the right -->
    <!-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> -->
    <!-- <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div> -->
    <strong>Copyright &copy; 2021 <a href="#" data-toggle="modal" data-target="#developerModal">Data Driven Squad</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<?= view('devmodal')?>
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url()?>/public/dist/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url()?>/public/dist/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url()?>/public/dist/adminlte/js/adminlte.min.js"></script>
<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<?php if(!empty(session()->getFlashdata('sweetalertfail'))):?>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: '<?= session()->getFlashdata('sweetalertfail')?>',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Okay'
			})/*swal2*/.then((result) =>
			{
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed)
				{
					Swal.close()
				}
			})//then
		};
	</script>
<?php endif;?>
</body>
</html>
