<?= $this->extend('admin/template') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/dist/select2/css/select2-bootstrap4.min.css">

  <style>
    .required:after {
        content:" *";
        color: red;
    }
   </style>
<?= $this->endSection() ?>

<?= $this->section('content_header');?>
<div class="col-sm-6">
  <h1 class="m-0 text-dark"><?= esc($threadData['subject'])?></h1>
</div><!-- /.col -->
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('admin/discussions');?>">Discussions</a></li>
    <li class="breadcrumb-item active"><?= esc($threadData['subject'])?></li>
  </ol>
</div><!-- /.col -->
<?= $this->endSection();?>

<?= $this->section('content') ?>
<form action="<?= base_url()?>/discussions/<?= esc($threadData['link'])?>" method="post">
    <!-- Timelime example  -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
                <?php if(empty($comments)): ?>
                    
                <?php else:?>
                    <?php foreach($comments as $comment):?>
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-envelope bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 
                                    <?php
                                        $date = date_create(esc($comment['comment_date']));
                                        echo date_format($date, 'F d, Y H:i');
                                    ?>
                                </span>
                                <h3 class="timeline-header"><a href="<?= base_url()?>/admin/users/<?= esc($comment['username'])?>"><?= esc($comment['first_name'])?> <?= esc($comment['last_name'])?></a> commented</h3>
                                <div class="timeline-body">
                                    <?= esc($comment['comment'])?>
                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </div>
                             </div>
                        </div>
                        <!-- END timeline item -->
                    <?php endforeach;?>
                <?php endif;?>
                <!-- timeline item -->
                <div>
                    <i class="fas fa-comment bg-blue"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header">Write Comment</h3>
                        <div class="timeline-body">
                            <textarea class="form-control  <?=isset($errors['comment']) ? 'is-invalid': ''?>" id="comment" rows="2" name="comment"></textarea>
                            <?php if(isset($errors['comment'])):?>
                                <div class="invalid-feedback">
                                    <?=esc($errors['comment'])?>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="timeline-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Add comment</button>
                        </div>
                     </div>
                </div>
                <!-- END timeline item -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<?= $this->endSection() ?>