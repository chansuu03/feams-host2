<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> <?= esc($title)?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/payment-methods');?>"><?= esc($title)?></a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div><!-- /.col -->
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/payment-methods')?>/<?= $edit ? 'edit/'.esc($id): 'add'?>" method="post" enctype="multipart/form-data">

<div class="card card-light">
    <div class="card-body">
        <div class="form-group"> <!-- Name -->
            <label for="name">Name</label>
            <input type="text" class="form-control <?=isset($errors['name']) ? 'is-invalid': ''?>" id="name" name="name" placeholder="Enter name" value="<?=isset($value['name']) ? esc($value['name']): ''?>">
            <?php if(isset($errors['name'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['name'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group"> <!-- Description -->
            <label for="steps">Steps to Pay</label>
            <textarea class="form-control <?=isset($errors['steps']) ? 'is-invalid': ''?>" name="steps" id="steps"><?=isset($value['steps']) ? esc($value['steps']): ''?></textarea>
            <?php if(isset($errors['steps'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['steps'])?>
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


<script>
    $('#steps').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['insert', ['link', 'picture']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });
</script>

<?= $this->endSection() ?>