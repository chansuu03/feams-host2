<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> <?= $title?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('file_sharing');?>">File Sharing</a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></li>
        </ol>
    </div><!-- /.col -->
</div>
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

<form action="<?= base_url('file_sharing')?>/<?= $edit ? 'edit/'.esc($link): 'add'?>" method="post" enctype="multipart/form-data">

<div class="card card-light">
    <div class="card-body">
        <div class="form-group">
            <label for="name">File Name</label>
            <input type="text" class="form-control <?=isset($errors['name']) ? 'is-invalid': ''?>" id="name" placeholder="Accomplishment Form" name="name">
            <small id="nameHelp" class="form-text text-muted">This will be the new file name to be uploaded.</small>
            <?php if(isset($errors['name'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['name'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="file">File</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input <?=isset($errors['file']) ? 'is-invalid': ''?>" id="file" name="file">
                <label class="custom-file-label" for="file">Choose file</label>
            </div>
            <small id="nameHelp" class="form-text text-muted">File must not exceed 20mb</small>
            <?php if(isset($errors['file'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc($errors['file'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="admin" id="defaultCheck1" name="visibility">
              <label class="form-check-label" for="defaultCheck1">
                Submit only to admin
              </label>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="float-end btn btn-primary btn-sm" >Submit</button>
    </div>
</div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<!-- Select2 -->
<script src="<?= base_url();?>/public/dist/adminlte/plugins/select2/js/select2.full.min.js"></script>

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
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var name = document.getElementById("file").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
  })
</script>
<?= $this->endSection() ?>