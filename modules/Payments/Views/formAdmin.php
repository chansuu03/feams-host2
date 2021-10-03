<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('payments');?>"><?= esc($title)?></a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div><!-- /.col -->
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('payments/admin')?>/<?= $edit ? 'edit/'.esc($id): 'add'?>" method="post" enctype="multipart/form-data">

<div class="card card-light">
    <div class="card-body">
        <div class="form-group"> <!-- Name -->
            <label for="name">Name</label>
            <select class="form-control select2 <?=isset($errors['user_id']) ? 'is-invalid': ''?>" id="user_id" name="user_id">
              <option value="">Select...</option>
              <?php foreach($users as $user):?>
                <option value="<?= esc($user['id'])?>"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></option>
              <?php endforeach;?>
            </select>
        </div>
        <div class="form-group"> <!-- Amount Paid -->
            <label for="payment_id">Contribution to be Paid</label>
            <select class="form-control select2 <?=isset($errors['contri_id']) ? 'is-invalid': ''?>" id="contri_id" name="contri_id">
              <option value="">Select...</option>
              <?php foreach($payments as $payment):?>
                <option value="<?= esc($payment['id'])?>"><?= esc($payment['name'])?> - <?= esc($payment['cost'])?></option>
              <?php endforeach;?>
            </select>
        </div>
        <div class="form-group"> <!-- Amount Paid -->
            <label for="amount">Amount</label>
            <input type="text" class="form-control <?=isset($errors['amount']) ? 'is-invalid': ''?>" id="amount" name="amount" placeholder="Enter amount" value="<?=isset($value['amount']) ? esc($value['amount']): ''?>"  onkeypress="return isNumberKey(event)">
            <?php if(isset($errors['amount'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['amount'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group"> <!-- Photo -->
            <label for="photo">Photo</label>
            <div class="custom-file"> 
                <input type="file" class="custom-file-input <?=isset($errors['photo']) ? 'is-invalid': ''?>" id="photo" name="photo">
                <label class="custom-file-label" for="photo">Upload photo as proof of payment</label>
            </div>
            <?php if(isset($errors['photo'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc($errors['photo'])?>
                </div>
            <?php endif;?>
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
<script src="<?= base_url();?>/public/dist/select2/js/select2.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4',
    })
  })

  function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode != 46 && charCode > 31 
       && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }

  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var name = document.getElementById("photo").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
  })
</script>
<?= $this->endSection() ?>