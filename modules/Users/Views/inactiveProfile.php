<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <style>
    .required:after {
        content:" *";
        color: red;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users')?>">Users</a></li>
            <li class="breadcrumb-item active"><?= esc($title)?></li>
        </ol>
    </div>
</div>
<?= $this->endSection() ?>

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
                    <!-- <img class="profile-user-img img-fluid img-circle"
                        src="<?= base_url()?>/public/uploads/profile_pic/<?= esc($user['profile_pic'])?>"
                        alt="User profile picture"> -->
                    <img class="profile-user-img img-fluid img-circle"
                        src="<?= empty($user['profile_pic']) ? base_url().'/public/img/blank.jpg' : base_url().'/public/uploads/profile_pic/'.esc($user['profile_pic'])?>"
                        alt="User profile picture">
                </div>
                <h3 class="profile-username text-center"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></h3>
                <p class="text-muted text-center"><?= esc($user['role_name'])?></p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Birthdate</b> 
                        <a class="float-right">
                          <?php
                            $date = date_create(esc($user['birthdate']));
                            echo esc(date_format($date, 'F d, Y'));
                          ?>
                        </a>
                    </li>
                    <li class="list-group-item">
                      <b>Gender</b> <a class="float-right"> <?= esc($user['gender'])?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Status</b>
                      <a class="float-right">
                        <?php 
                          switch (esc($user['status'])) {
                            case '0':
                              echo 'Unpaid';
                              break;
                            case '1':
                              echo 'Active';
                              break;
                            case '2':
                              echo 'Inactive';
                              break;
                            case '3':
                              echo 'Paid';
                              break;
                            case '4':
                              echo 'Need email verification';
                              break;
                          }
                        ?>
                      </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <!-- User details -->
        <div class="card">
            <div class="card-header">
              User details
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="mb-2">
                <b>Username</b> <a class="float-right"><?= esc($user['username'])?></a> <br>
              </div>
              <div class="mb-2">
                <b>Contact Number</b> <a class="float-right"><?= esc($user['contact_number'])?></a> <br>
              </div>
              <div class="mb-2">
                <b>Email</b> <a class="float-right"><?= esc($user['email'])?></a> <br>
              </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
            <div class="card-header">
                Files uploaded
            </div><!-- /.card-header -->
            <div class="card-body">
                <table class="table">
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

<!-- Payments -->
  <div class="card">
      <div class="card-header">
        Contribution details
      </div><!-- /.card-header -->
      <div class="card-body">
        <table class="table" id="table_pay">
          <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Contribution</th>
                <th scope="col">Cost</th>
                <th scope="col">Paid</th>
                <th scope="col">Balance</th>
            </tr>
          </thead>
          <tbody>
            <?php $ctr = 1?>
            <?php foreach($contribs as $contri):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($contri['name'])?></td>
                <td><?= esc($contri['cost'])?></td>
                <td>
                  <?php $amt = 0;
                    foreach($payments as $pay) {
                      if($pay['contri_id'] == $contri['id']) {
                        $amt += $pay['amount'];
                      }
                    }
                    echo esc($amt);
                    ?>
                </td>
                <td>
                  <?php $total = $contri['cost'] - $amt; echo esc($total)?>
                </td>
              </tr>
              <?php $ctr++;?>
            <?php endforeach?>
          </tbody>
        </table>
      </div><!-- /.card-body -->
  </div>
<!-- End Payments -->

<?php $status = false; $role = false;
foreach($perm_id['perm_id'] as $perms) {
  if(!$status) {
    if($perms == '3') {
      $status = true;
      // echo '<h3>status</h3>';
    }
  }
  if(!$role) {
    if($perms == '4') {
      $role = true;
      // echo '<h3>role</h3>';
    }
  }
}?>

<?php if(session()->get('user_id') == $user['id'] || isset($edit)):?>
<div class="card">
  <div class="card-header">
    Edit User Information
  </div>
  <div class="card-body">
    <form action="<?= base_url()?>/user/<?= esc($user['username'])?>/verify" method="post" enctype="multipart/form-data" id="userForm">
      <input type="hidden" value="<?= esc($user['id'])?>" name="id">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?= $user['first_name']?>">
        </div>
        <div class="form-group col-md-4">
          <label for="middle_name">Middle Name</label>
          <input type="text" class="form-control" name="middle_name" value="<?= $user['middle_name']?>">
        </div>
        <div class="form-group col-md-4">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" name="last_name" value="<?= $user['last_name']?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" value="<?= $user['email']?>">
        </div>
        <div class="form-group col-md-6">
          <label for="contact_number">Contact Number</label>
          <input type="number" class="form-control" name="contact_number" value="<?= $user['contact_number']?>">
        </div>
      </div>
      <?php if($user['role'] != '0'):?>
        <div class="form-group">
          <label for="exampleInputFile">Profile Picture</label>
          <div class="input-group">
              <div class="custom-file">
                  <input type="file" class="custom-file-input <?php if(!empty($errors['image'])) echo 'is-invalid';?>" id="image" name="image" required>
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
          </div>
          <?php if(isset($errors['image'])): ?>
              <small id="emailHelp" class="form-text text-danger"><?= $errors['image']?></small>
          <?php endif; ?>
        </div>
      <?php endif;?>
      <?php if($role):?>
        <!-- Role -->
        <?php if($user['role'] == 0):?>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control form-control-sm select2bs4" name="role" disabled>
              <option value="0" selected>Temporary</option>
            </select>
          </div>
        <?php else:?>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control form-control-sm select2bs4" name="role">
              <?php foreach($roles as $role):?>
                <option value="<?= esc($role['id'])?>" <?= $user['role'] ==$role['id'] ? 'selected' : ''?>><?= esc($role['role_name'])?></option>
              <?php endforeach;?>
            </select>
          </div>
        <?php endif;?>
      <?php endif;?>
      <?php if($status):?>
        <!-- Role -->
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control form-control-sm select2bs4" name="status">
            <option value="1" <?= $user['status'] == '1' ? 'selected' : ''?>>Active</option>
            <option value="2" <?= $user['status'] == '2' ? 'selected' : ''?>>Inactive</option>
            <option value="3" <?= $user['status'] == '3' ? 'selected' : ''?>>Paid</option>
            <option value="0" <?= $user['status'] == '0' ? 'selected' : ''?>>Unpaid</option>
          </select>
        </div>
      <?php endif;?>
  </div>
  <div class="card-footer">
    <button class="btn btn-primary btn-sm sub" type="button">Save changes</button>
    </form>
  </div>
</div>
<?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- Select2 -->
<script src="<?= base_url();?>/public/dist/select2/js/select2.full.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    })
  })
</script>

<script>
// BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  // DataTables
  $(function () {
    $('#table_pay').DataTable({
      "responsive": true,
      "autoWidth": false,
      });
  });
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {
    $('.status').on('change', function() {
      var $form = $(this).closest('form');
      $form.submit();
    });

    $('.sub').click(function (e)
    {
      e.preventDefault();
      var id = $(this).val();
      console.log(id);

      Swal.fire({
        icon: 'question',
        title: 'Change status?',
        text: 'Email will be sent after you changed the status of the user',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, edit it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          $('#userForm').submit();
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>

<!-- file uploads para mapalitan agad file name once makaselect na ng file -->
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function (e)
    {
    var name = document.getElementById("image").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
    })
</script>
<?= $this->endSection() ?>
    