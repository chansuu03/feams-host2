<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">

  <style>
    .required:after {
        content:" *";
        color: red;
    }
   </style>
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('discussions');?>">Discussions</a></li>
            <li class="breadcrumb-item active"><?= esc($threadData['subject'])?></li>
        </ol>
    </div>
</div>
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
                                <h3 class="timeline-header"><a href="<?= base_url()?>/user/<?= esc($comment['username'])?>"><?= esc($comment['first_name'])?> <?= esc($comment['last_name'])?></a> commented</h3>
                                <div class="timeline-body">
                                    <?= $comment['comment']?>
                                </div>
                                <?php $access = false;?>
                                <?php foreach($perm_id['perm_id'] as $perms):?>
                                    <?php if($perms == '36' || $comment['user_id'] == session()->get('user_id')):?>
                                        <?php if(!$access):?>
                                            <div class="timeline-footer">
                                                <p hidden id="link" value=""><?= esc($threadData['link'])?></p>
                                                <button type="button" class="btn btn-danger btn-sm del" value="<?= esc($comment['id'])?>">Delete</button>
                                            </div>
                                            <?php $access = true;?>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endforeach;?>
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
                            <textarea class="form-control  <?=isset($errors['comment']) ? 'is-invalid': ''?> comment" id="comment" rows="2" name="comment"></textarea>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                When using image upload, make sure image file won't exceed 100kb.
                            </small>
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

<script>
    $('.comment').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            [ 'insert', [ 'link', 'picture'] ],
        ]
    });
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">
//   function clicked(link, id) {
//     Swal.fire({
//         icon: 'question',
//         title: 'Delete?',
//         text: 'Are you sure to delete comment?',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//     }).then((result) =>
//     {
//       /* Read more about isConfirmed, isDenied below */
//       if (result.isConfirmed)
//       {
//         window.location = '/delete/' + id;
//       }
//       else if (result.isDenied)
//       {
//         Swal.fire('Changes are not saved', '', 'info')
//       }
//     });
//   }

  $(document).ready(function ()
  {
    $('.del').click(function (e)
    {
      e.preventDefault();
      var link = $('#link').text();
      var id = $(this).val();
      console.log(link);

      Swal.fire({
        icon: 'question',
        title: 'Delete?',
        text: 'Are you sure to delete comment?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
            window.location = '<?= base_url()?>/discuss/'+ link +'/comment/delete/' + id;
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