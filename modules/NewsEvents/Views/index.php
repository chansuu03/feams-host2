<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?= esc($title)?></li>
        </ol>
    </div>
</div>
<?= $this->endSection() ?>

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

<div class="card">
  <?php foreach($perm_id['perm_id'] as $perms):?>
    <?php if($perms == '42'):?>
      <div class="card-header">
        <div class="float-right">
            <a class="btn btn-primary btn-sm" href="<?= base_url('admin/news/add')?>" role="button">Add News</a>
        </div>
      </div>
    <?php endif;?>
  <?php endforeach;?>
  <div class="card-body">
    <table class="table table-hover" id="news">
        <thead class="thead-light">
            <tr>
              <th scope="col" style="width: 5%">#</th>
              <th scope="col" style="width: 30%">Title</th>
              <th scope="col" style="width: 30%">Uploader</th>
              <th scope="col" style="width: 20%">Added at</th>
              <th scope="col" style="width: 15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $ctr = 1?>
            <?php foreach($news as $news):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><a href="<?= base_url()?>/news/<?= esc($news['id'])?>"><?= esc($news['title'])?></a></td>
                <td><?= esc($news['first_name'])?> <?= esc($news['last_name'])?></td>
                <td>
                  <?php
                    $date=date_create(esc($news['created_at']));
                    echo date_format($date,"F d,Y");
                  ?>
                </td>
                <td>
                  <!-- <a class="btn btn-info btn-sm" href="#" role="button">Link</a> -->
                  <?php foreach($perm_id['perm_id'] as $perms):?>
                    <?php if($perms == '43'):?>
                      <a class="btn btn-warning btn-sm" href="<?=base_url('admin/news/edit/' . esc($news['id'], 'url'))?>" data-toggle="tooltip" data-placement="bottom" title="Edit News"> <i class="fas fa-edit"></i> </a>
                    <?php elseif($perms == '44'):?>
                      <button type="button" value="<?= esc($news['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete News"><i class="fas fa-trash"></i></button>
                    <?php endif;?>
                  <?php endforeach;?>
                </td>
              </tr>
              <?php $ctr++?>
            <?php endforeach?>
        </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
// BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  // DataTables
  $(function () {
    $('#news').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {
    $('.del').click(function (e)
    {
      e.preventDefault();
      var link = $(this).val();
      console.log(link);

      Swal.fire({
        icon: 'question',
        title: 'Delete?',
        text: 'Are you sure to delete news?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = '<?= base_url()?>/admin/news/delete/' + link;
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
    