<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
      <h1><?= esc($title)?></h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('admin/elections')?>">Elections</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('admin/candidates');?>">Candidates</a></li>
        <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></li>
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

<form action="<?= base_url('admin/candidates2')?>/<?= $edit ? 'edit/'.esc($link): 'add'?>" method="post" enctype="multipart/form-data">

<div class="card card-light">
    <div class="card-body">
      <div class="form-group"> <!-- Elections -->
        <label for="election_id">Election</label>
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
      <div id="positions">
      </div>
      <div class="form-group"> <!-- Candidate Name -->
        <label for="user_id">Candidate Name</label>
        <select class="form-control select2 <?=isset($errors['user_id']) ? 'is-invalid': ''?>" id="user_id" name="user_id">
          <option value="">Select...</option>
          <?php foreach($users as $user):?>
            <option value="<?= esc($user['id'])?>"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></option>
          <?php endforeach;?>
        </select>
        <?php if(isset($errors['user_id'])):?>
            <div class="invalid-feedback">
                <?=esc($errors['user_id'])?>
            </div>
        <?php endif;?>
      </div>
      <div class="form-group"> <!-- Photo -->
        <label for="photo">Photo</label>
        <div class="custom-file"> 
            <input type="file" class="custom-file-input <?=isset($errors['photo']) ? 'is-invalid': ''?>" id="photo" name="photo">
            <label class="custom-file-label" for="photo">Choose candidate photo</label>
        </div>
        <?php if(isset($errors['photo'])):?>
            <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                <?=esc($errors['photo'])?>
            </div>
        <?php endif;?>
        </div>
        <div class="form-group"> <!-- Platform -->
            <label for="platform">Platform</label>
            <textarea class="form-control <?=isset($errors['platform']) ? 'is-invalid': ''?>" name="platform" id="platform"><?=isset($value['platform']) ? esc($value['platform']): ''?></textarea>
            <?php if(isset($errors['platform'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['platform'])?>
                </div>
            <?php endif;?>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="float-end btn btn-primary btn-sm" >Submit</button>
    </div>
</div>
</form>

<?= $this->endSection();?>

<?= $this->section('scripts') ?>

<!-- Select2 -->
<script src="<?= base_url();?>/public/dist/select2/js/select2.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4',
    })
  })

  // Select on change
  $('#election_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('admin/candidates2/elec'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#positions').html('Loading Table ...');
      },
      success: function (data) {
        $('#positions').html(data);
      }
    })
  })
</script>

<script>
    $('#platform').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
        ]
    });
</script>

<script>
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var name = document.getElementById("photo").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
  })
</script>
<?= $this->endSection();?>