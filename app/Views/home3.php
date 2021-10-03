<?= $this->extend('temp') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url();?>/public/css/home3.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">FEAMS</a>
    <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
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

<div class="container-fluid mt-3 mb-3">
  <div class="row">
    <div class="col-md-8">
      <p class="text-center font-weight-light" style="font-size: 2.8em">Announcements</p>
      <hr style="border: 3px solid; color: #424242;">
      <?php if(empty($announces)):?>
        <p class="lead text-center">
          No announcements posted.
        </p>
      <?php else:?>
        <?php foreach($announces as $announce):?>
          <div class="card mt-2">
            <div class="card-body">
              <div class="row">
                  <div class="col-md-3">
                    <img src="<?= base_url();?>/public/uploads/announcements/<?= esc($announce['image'], 'raw')?>" class="img-thumbnail">
                  </div>
                  <div class="col-md-9">
                    <a href="<?= base_url()?>/announcements/<?= esc($announce['link'], 'raw')?>" class="mt-1 h4 text-dark text-left"><?= esc($announce['title'], 'raw')?></a>
                    <p class="mt-1">Posted in: <?= date('F d,Y', strtotime($announce['created_at']))?></p>
                    <div class="row">
                        <div class="col-12" style="height: 100px; overflow: auto; overflow-y: hidden; overflow-x: hidden;">
                          <?= esc($announce['description'], 'raw')?>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        <?php endforeach;?>
        <a class="btn btn-primary mt-3 float-right" href="<?= base_url('admin/announcements')?>" role="button">See More</a>
      <?php endif;?>
    </div>
    <div class="col-md-4">
      <p class="text-center font-weight-light" style="font-size: 2.8em">Discussions</p>
      <hr style="border: 3px solid; color: #424242;">
      <div class="contents">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Shared</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?= esc($user_details['role_name'])?></a>
          </li>
        </ul>
        <!-- all discussions -->
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="height: 500px; overflow: auto">
            <ul class="list-group">
              <?php if(empty($allDiscussion)):?>
                <p class="lead text-center mt-2">
                  No discussions set. <a href="<?= base_url('discussions/add/0')?>">Start one?</a>
                </p>
              <?php else:?>
                <?php foreach($allDiscussion as $all):?>
                  <li class="list-group-item">
                    <div class="d-flex flex-row mb-1">
                      <div><a href="<?= base_url()?>/discussions/<?= esc($all['link'])?>"><?= esc($all['subject'])?></a></div>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                      <div><?= esc($all['first_name'])?> <?= esc($all['last_name'])?></div>
                      <div><?= date('F d,Y', strtotime($all['created_at']))?></div>
                    </div>
                  </li>
                <?php endforeach?>
              <?php endif;?>
            </ul>
            <a class="btn btn-primary mt-2 float-right" href="<?= base_url('discussions')?>" role="button">See More</a>
          </div>
          <!-- Per role discussion -->
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab" style="height: 500px; overflow: auto">
            <ul class="list-group">
              <?php if(empty($roleDiscussion)):?>
                <p class="lead text-center mt-2">
                  No discussions set. <a href="<?= base_url('discussions/add')?>/<?= session()->get('role')?>">Start one?</a>
                </p>
              <?php else:?>
                <?php foreach($roleDiscussion as $role):?>
                    <li class="list-group-item">
                    <div class="d-flex flex-row mb-1">
                        <div><a href="<?= base_url()?>/discussions/<?= esc($role['link'])?>"><?= esc($role['subject'])?></a></div>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <div><?= esc($role['first_name'])?> <?= esc($role['last_name'])?></div>
                        <div><?= date('F d,Y', strtotime($role['created_at']))?></div>
                    </div>
                    </li>
                <?php endforeach?>
                <a class="btn btn-primary mt-2 float-right" href="<?= base_url('discussions')?>" role="button">See More</a>
              <?php endif;?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Footer here, paayos din ng header, di kita sa mobile</a>
</nav>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if(!empty(session()->getFlashdata('sweetalertfail'))):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
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