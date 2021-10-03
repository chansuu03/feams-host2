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
  <div class="card-body">
    <table class="table table-hover" id="roles">
        <thead class="thead-light">
            <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col" style="width: 30%">Role Name</th>
            <th scope="col" style="width: 45%">Permissions</th>
            <?php foreach($perm_id['perm_id'] as $perms):?>
              <?php if($perms == '9'):?>
                <th scope="col" style="width: 15%">Actions</th>
                <?php $actions = true;?>
              <?php endif;?>
            <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
            <?php $ctr = 1?>
            <?php foreach($roles as $role): ?>
                <tr>
                    <th scope="row"><?= esc($ctr)?></th>
                    <td><?= esc($role['role_name'])?></td>
                    <td>
                      <?php foreach($role_permissions as $role_permission):?>
                        <?php if($role_permission['id'] == $role['id']):?>
                          <span class="badge badge-info" style="font-size: 15px;"><?= esc($role_permission['desc'])?></span>
                        <?php endif;?>
                      <?php endforeach;?>
                    </td>
                    <?php if(isset($actions) && $role['id'] != '1'):?>
                      <td>
                          <a class="btn btn-primary btn-sm" href="<?= base_url('admin/permissions/edit/')?>/<?= esc($role['id'])?>" role="button">Edit</a>
                      </td>
                    <?php endif;?>
                </tr>
                <?php $ctr++?>            
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
    $('#roles').DataTable({
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
        text: 'Are you sure to delete role?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'roles/delete/' + id;
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
    