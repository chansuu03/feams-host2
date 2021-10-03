<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/dist/select2/css/select2-bootstrap4.min.css">

<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/elections')?>">Elections</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/positions');?>">Positions</a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div>
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

<form action="<?= base_url('admin/positions')?>/<?= $edit ? 'edit/'.esc($link): 'add'?>" method="post" enctype="multipart/form-data" id="posForm">
<div class="card card-light">
    <div class="card-body">
      <div class="form-group"> <!-- Election Name -->
        <label for="election_id">Election Name</label>
        <select class="form-control select2 <?=isset($errors['election_id']) ? 'is-invalid': ''?>" id="election_id" name="election_id">
          <option value="">Select...</option>
          <?php foreach($elections as $election):?>
            <option value="<?= esc($election['id'])?>"><?= esc($election['title'])?></option>
          <?php endforeach;?>
        </select>
        <?php if(isset($errors['election_id'])):?>
            <div class="invalid-feedback">
                <?=esc($errors['election_id'])?>
            </div>
        <?php endif;?>
      </div>
      <div class="form-group"> <!-- Position Name -->
        <label for="name">Position Name</label>
        <input type="text" class="form-control <?=isset($errors['name']) ? 'is-invalid': ''?>" id="name" name="name">
        <?php if(isset($errors['name'])):?>
            <div class="invalid-feedback">
                <?=esc($errors['name'])?>
            </div>
        <?php endif;?>
      </div>
      <div class="form-group"> <!-- Max no. of Candidates -->
        <label for="max_candidate">Max no. of Candidates</label>
        <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"class="form-control <?=isset($errors['max_candidate']) ? 'is-invalid': ''?>" id="max_candidate" name="max_candidate">
        <?php if(isset($errors['max_candidate'])):?>
            <div class="invalid-feedback">
                <?=esc($errors['max_candidate'])?>
            </div>
        <?php endif;?>
      </div>
    </div>
    <div class="card-footer">
        <button type="button" class="float-end btn btn-primary btn-sm sub">Submit</button>
        <!-- <button type="submit" class="float-end btn btn-primary btn-sm" >Submit</button> -->
    </div>
</div>
</form>

<?= $this->endSection();?>

<?= $this->section('scripts') ?>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url();?>/dist/select2/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4',
    })
  })

  $(document).ready(function ()
  {
    $('.sub').click(function (e)
    {
      e.preventDefault();

      Swal.fire({
        icon: 'question',
        title: 'Add?',
        text: 'Are you sure to add position?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          document.getElementById('posForm').submit();
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>

<?= $this->endSection();?>