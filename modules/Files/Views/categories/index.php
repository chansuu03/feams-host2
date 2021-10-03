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
    <?php if($perms == '1'):?>
      <div class="card-header">
        <div class="float-right">
            <a class="btn btn-primary btn-sm" href="<?= base_url('files/categories/add')?>" role="button">Add File Category</a>
        </div>
      </div>
    <?php endif;?>
  <?php endforeach;?>
  <div class="card-body">
    <table class="table table-hover" id="file_category">
        <thead class="thead-light">
            <tr>
              <th scope="col" style="width: 10%">#</th>
              <th scope="col" style="width: 35%">Category Name</th>
              <th scope="col" style="width: 35%">Date Created</th>
              <?php foreach($perm_id['perm_id'] as $perms):?>
                  <?php if($perms == '33'):?>
                    <th scope="col" style="width: 10%">Actions</th>
                  <?php endif;?>
              <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
            <?php $ctr = 1?>
            <?php foreach($categories as $category):?>
            <tr>
                <th><?= esc($ctr)?></th>
                <td><?= esc($category['name'])?></td>
                <td scope="row">
                  <?php
                    $date = date_create(esc($category['created_at']));
                    echo esc(date_format($date, 'F d, Y H:i'));
                  ?>
                </td>
                <?php foreach($perm_id['perm_id'] as $perms):?>
                  <?php if($perms == '33'):?>
                    <td scope="row">
                        <!-- <a class="btn btn-info btn-sm" href="<?= base_url()?>/files/categories/edit/<?= esc($category['id'])?>" role="button" data-toggle="tooltip" data-placement="bottom" title="Edit category"><i class="fa fa-edit" aria-hidden="true"></i></a> -->
                        <button type="button" value="<?= esc($category['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete category"><i class="fas fa-trash"></i></button>
                    </td>
                  <?php endif;?>
                <?php endforeach;?>
                <?php $ctr++;?>
            </tr>                
            <?php endforeach;?>
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
    $('#file_category').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>

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
      var id = $(this).val();
      console.log(id);

      Swal.fire({
        icon: 'question',
        title: 'Delete?',
        text: 'Are you sure to delete category?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'categories/delete/' + id;
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
    