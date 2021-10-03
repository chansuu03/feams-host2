<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/dist/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/dist/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/permissions');?>"><?= esc($title)?></a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div>
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/permissions')?>/<?= $edit ? 'edit/'.esc($link): 'add'?>" method="post" enctype="multipart/form-data" id="form">

<div class="card card-light">
    <div class="card-body">
        <div class="form-group"> <!-- Role -->
          <label for="role_id">Role</label>
          <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
          <select class="form-control select2bs4 <?=isset($errors['role_id']) ? 'is-invalid': ''?>" id="role_id" name="role_id" required>
            <option value="">Select...</option>
            <?php foreach($roles as $role):?>
              <option value="<?= esc($role['id'])?>"><?= esc($role['role_name'])?></option>
            <?php endforeach;?>
          </select>
          <?php if(isset($errors['role_id'])):?>
              <div class="invalid-feedback">
                  <?=esc($errors['role_id'])?>
              </div>
          <?php endif;?>
        </div>
        <div class="form-group"> <!-- Permissions -->
          <label for="perm_id">Permissions</label>
          <select class="form-control select2bs4 <?=isset($errors['perm_id']) ? 'is-invalid': ''?>" multiple="multiple" id="perm_id" name="perm_id[]" data-placeholder="Select a Permission/s" required>
            <option value="">Select...</option>
            <?php foreach($permissions as $permission):?>
              <option value="<?= esc($permission['id'])?>"><?= esc($permission['desc'])?></option>
            <?php endforeach;?>
          </select>
          <?php if(isset($errors['perm_id'])):?>
              <div class="invalid-feedback">
                  <?=esc($errors['perm_id'])?>
              </div>
          <?php endif;?>
        </div>
        
        <button type="button" class="float-end btn btn-primary btn-sm submit" >Submit</button>
    </div>
</div>

</form>

<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<!-- Select2 -->
<!-- <script src="<?= base_url();?>/dist/select2/js/select2.min.js"></script> -->
<!-- Select2 -->
<script src="<?= base_url();?>/dist/adminlte/plugins/select2/js/select2.full.min.js"></script>

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

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
  });

  $(document).ready(function ()
  {
    $('.submit').click(function (e)
    {
      e.preventDefault();

      Swal.fire({
        icon: 'question',
        title: 'Add?',
        text: 'Are you sure to set permission to role?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          document.getElementById('form').submit();
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>
<?= $this->endSection() ?>