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
            <li class="breadcrumb-item"><a href="<?= base_url('admin/news');?>"><?= esc($title)?></a></li>
            <li class="breadcrumb-item active"><?= $edit ? 'Edit': 'Add'?></li>
        </ol>
    </div><!-- /.col -->
</div>
<?= $this->endSection();?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/news')?>/<?= $edit ? 'edit/'.esc($id): 'add'?>" method="post" enctype="multipart/form-data">

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
        <div class="form-group"> <!-- Content -->
            <label for="content">Content</label>
            <textarea class="form-control <?=isset($errors['content']) ? 'is-invalid': ''?>" name="content" id="content"><?=isset($value['content']) ? esc($value['content']): ''?></textarea>
            <?php if(isset($errors['content'])):?>
                <div class="invalid-feedback">
                    <?=esc($errors['content'])?>
                </div>
            <?php endif;?>
        </div>
        <div class="form-group"> <!-- Image -->
            <label for="image">Image</label>
            <div class="custom-file"> 
                <input type="file" class="custom-file-input <?=isset($errors['image']) ? 'is-invalid': ''?>" id="image" name="image">
                <label class="custom-file-label" for="customFile">Choose news image</label>
            </div>
            <?php if(isset($errors['image'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc($errors['image'])?>
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

<script src="<?= base_url();?>/dist/ckeditor5/ckeditor.js"></script>

<script>
    $('#content').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
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