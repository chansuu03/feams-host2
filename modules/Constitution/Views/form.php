<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> <?= $title?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('constitution');?>">Constitutions</a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></li>
        </ol>
    </div><!-- /.col -->
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('constitution')?>/<?= $edit ? 'edit/'.esc($id): 'add'?>" method="post" enctype="multipart/form-data">
  <div class="card card-light">
    <div class="card-body">
      <div class="form-group"> <!-- Name -->
        <label for="area">Area</label>
        <input type="text" class="form-control <?=isset($errors['area']) ? 'is-invalid': ''?>" id="area" name="area" placeholder="Enter area" value="<?=isset($value['area']) ? esc($value['area']): ''?>">
        <?php if(isset($errors['area'])):?>
          <div class="invalid-feedback">
              <?=esc($errors['area'])?>
          </div>
        <?php endif;?>
      </div>
      <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="summernote" name="content"><?=isset($value['content']) ? esc($value['content']): ''?></textarea>
        <?php if(isset($errors['content'])):?>
          <div class="invalid-feedback">
              <?=esc($errors['content'])?>
          </div>
        <?php endif;?>
      </div>
      <button type="submit" class="float-end btn btn-primary btn-sm" >Submit</button>
    </div>
  </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<!-- Select2 -->
<script src="<?= base_url();?>/dist/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
  $(document).ready(function() {
    $('#summernote').summernote({
      tabsize: 2,
      height: 100,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  });
</script>
<?= $this->endSection() ?>