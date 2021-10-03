<?= $this->extend('temp') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url();?>/css/home.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">FEAMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
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
      </ul>
      <div class="form-inline my-2 my-lg-0">
        <?php if(session()->get('isLoggedIn') != TRUE): ?>
        <span class="navbar-text" style="margin-right: 5px;">
          Already have an account?
        </span>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url();?>/login">Login</a>
          </li>
        </ul>
      <?php else: ?>
        <span class="navbar-text" style="margin-right: 5px;">
          Welcome back! <?=$user['username']?>
        </span>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url();?>/logout">logout</a>
          </li>
        </ul>
      <?php endif ?>
    </div>
</nav>
<!-- end navbars -->

<div id="carousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" style="height: 340px;">
      <img class="d-block w-100" src="<?= base_url()?>/img/welcome.png" alt="First slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>FEAMS</h5>
            <p>Welcome to FEAMS</p>
          </div>
    </div>
    <?php foreach($sliders as $slider):?>
        <div class="carousel-item" style="height: 340px;">
          <img class="d-block w-100" src="<?= base_url()?>/uploads/sliders/<?= esc($slider['image'])?>" alt="Second slide" style="height: inherit; object-fit: cover;">
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

<div class="container-fluid mt-3 mb-3">
  <div class="row">
    <div class="col-md-9">
      <h1 class="display-4 text-center">Announcements</h1>
      <hr style="border: 3px solid; color: #424242;">
      <?php foreach($announces as $announce):?>
        <div class="card mt-2">
          <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                  <img src="<?= base_url();?>/uploads/announcements/<?= esc($announce['image'], 'raw')?>" class="img-thumbnail">
                </div>
                <div class="col-md-9">
                  <a href="<?= base_url()?>/announcements/<?= esc($announce['link'], 'raw')?>" class="mt-1 h4 text-dark text-left"><?= esc($announce['title'], 'raw')?></a>
                  <p class="mt-1">Posted in: <?= date('F d,Y', strtotime($announce['created_at']))?></p>
                  <div class="row">
                      <div class="col-12" style="min-height: 100%;">
                        <?php
                          $start = strpos(esc($announce['description'], 'raw'), '<p>');
                          $end = strpos(esc($announce['description'], 'raw'), '</p>', $start);
                          $paragraph = substr(esc($announce['description'], 'raw'), $start, $end-$start+4);
                        ?>
                        <?= esc($paragraph, 'raw')?>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      <?php endforeach;?>
      <a class="btn btn-primary mt-3 float-right" href="<?= base_url('admin/announcements')?>" role="button">See More</a>
    </div>
    <div class="col-md-3">
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if(!empty(session()->getFlashdata('sweetalertfail'))):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'There\'s an error accessing the page, please try again',
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
<?= $this->endSection() ?>