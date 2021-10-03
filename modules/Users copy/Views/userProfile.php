<?= $this->extend('admin/template') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content_header');?>
<div class="col-sm-6">
  <h1 class="m-0 text-dark">Profile</h1>
</div><!-- /.col -->
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>/admin/users">Users</a></li>
    <li class="breadcrumb-item active"><?= esc($user['username'])?></li>
  </ol>
</div><!-- /.col -->
<?= $this->endSection();?>

<?= $this->section('content') ?>

<?php if(!empty(session()->getFlashdata('failMsg'))):?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('failMsg');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif;?>
<?php if(!empty(session()->getFlashdata('successMsg'))):?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('successMsg');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif;?>

<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="<?= base_url()?>/uploads/profile_pic/<?= esc($user['profile_pic'])?>"
                        alt="User profile picture">
                </div>
                <h3 class="profile-username text-center"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></h3>
                <p class="text-muted text-center"><?= esc($user['role'])?></p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Birthdate</b> <a class="float-right"><?= esc($user['birthdate'])?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Contact Number</b> <a class="float-right"><?= esc($user['contact_number'])?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right"><?= esc($user['email'])?></a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Files uploaded
            </div><!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">File</th>
                            <th scope="col">Date uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ctr = 1?>
                        <?php if(empty($files)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No files uploaded by user</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($files as $file): ?>
                                <tr>
                                <td><?=esc($ctr)?></td>
                                <td><a href="<?= base_url('uploads/files')?>/<?=esc($file['name'])?>" class="card-link" target="_blank" rel="noopener noreferrer"><?= esc($file['name'])?></a></td>
                                <td>
                                    <?php
                                    $date = date_create(esc($file['uploaded_at']));
                                    echo date_format($date, 'F d, Y H:i');
                                    ?>
                                </td>
                                </tr>
                                <?php $ctr++?>            
                            <?php endforeach;?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>