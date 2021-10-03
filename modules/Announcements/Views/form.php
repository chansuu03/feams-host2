<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= $edit ? 'Edit': 'Add'?> Announcement</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/announcements');?>">Announcements</a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div><!-- /.col -->
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/announcements')?>/<?= $edit ? 'edit/'.esc($link): 'add'?>" method="post" enctype="multipart/form-data">

<div class="card card-light">
    <div class="card-body">
        <div class="form-group"> <!-- Title -->
            <label for="title">Title</label>
            <input type="text" class="form-control <?=isset($errors['title']) ? 'is-invalid': ''?>" id="title" name="title" placeholder="Enter title" value="<?=isset($value['title']) ? esc($value['title']): ''?>">
            <?php if(isset($errors['title'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['title'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group"> <!-- Description -->
            <label for="description">Description</label>
            <textarea class="form-control <?=isset($errors['description']) ? 'is-invalid': ''?>" name="description" id="description"><?=isset($value['description']) ? esc($value['description']): ''?></textarea>
            <?php if(isset($errors['description'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['description'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group"> <!-- Image -->
            <label for="image">Image</label>
            <div class="custom-file"> 
                <input type="file" class="custom-file-input <?=isset($errors['image']) ? 'is-invalid': ''?>" id="image" name="image">
                <label class="custom-file-label" for="customFile">Choose announcement image</label>
            </div>
            <?php if(isset($errors['image'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc($errors['image'])?>
                </div>
            <?php endif;?>
        </div>
        <?php if(!$edit):?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="yes" id="defaultCheck1" name="sendMail">
                <label class="form-check-label" for="defaultCheck1">
                    Send e-mail to members
                </label>
            </div>
        <?php endif;?>
    </div>
    <div class="card-footer">
        <button type="submit" class="float-end btn btn-primary btn-sm" >Submit</button>
    </div>
</div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<script src="<?= base_url();?>/dist/ckeditor5/ckeditor.js"></script>

<script>
    $('#description').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
        ]
    });
</script>


<script>
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var name = document.getElementById("image").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
  })
</script>
<?= $this->endSection() ?>