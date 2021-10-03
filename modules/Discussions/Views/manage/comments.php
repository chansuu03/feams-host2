<?= $this->extend('adminlte') ?>

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

 <!-- Timelime example  -->
<div class="row">
  <div class="col-md-12">
    <!-- The time line -->
    <div class="timeline">
      <?php foreach($comments as $comms):?>
        <!-- timeline item -->
        <div>
          <i class="fas fa-envelope bg-blue"></i>
          <div class="timeline-item">
            <span class="time"><i class="fas fa-clock"></i> <?= date('F d, Y h:ia', strtotime($comms['comment_date']))?></span>
            <h3 class="timeline-header"><a href="<?= base_url('user')?>/<?= esc($comms['username'])?>"><?= esc($comms['first_name'])?> <?= esc($comms['last_name'])?></a> commented</h3>
            <div class="timeline-body">
              <?= esc($comms['comment'], 'raw')?>
            </div>
            <div class="timeline-footer">
              <button type="button" class="btn btn-danger btn-sm del" value="<?= esc($comms['id'])?>">Delete</button>
            </div>
          </div>
        </div>
        <!-- END timeline item -->
      <?php endforeach;?>
    </div>
    <!-- /.col -->
  </div>
</div>
<!-- /.timeline -->

<?= $this->endSection() ?>

<?= $this->section('scripts');?>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">
  $(document).ready(function ()
  {
    $('.del').click(function (e)
    {
      e.preventDefault();
      var link = '<?= esc($threadData['link'])?>';
      var id = $(this).val();
      console.log(id);

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
            window.location = '/discussions/' + link + '/comment/delete/'+ id;
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