<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/elections')?>">Elections</a></li>
            <li class="breadcrumb-item active"><?= esc($title)?></li>
        </ol>
    </div>
</div>
<?= $this->endSection();?>

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
    <table class="table" id="positions">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 10%;">#</th>
          <th scope="col" style="width: 30%;">Election Name</th>
          <th scope="col" style="width: 50%;">Positions</th>
          <?php foreach($perm_id['perm_id'] as $perms):?>
            <?php if($perms == '25'):?>
              <th scope="col" style="width: 10%;">Action</th>
            <?php endif;?>
          <?php endforeach;?>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1?>
        <?php if(empty($elections)): ?>
          <tr>
            <td colspan="3" class="text-center">No current elections</td>
          </tr>
        <?php else: ?>
          <?php foreach($elections as $election):?>
            <tr>
              <td><?= esc($ctr)?></td>
              <td><?= esc($election['title'])?></td>
              <td>
                <?php foreach($positions as $pos):?>
                  <?php if($pos['election_id'] == $election['id']):?>
                    <span class="badge badge-primary" style="font-size: 15px;"><?= esc($pos['position_name'])?></span>
                  <?php endif;?>
                <?php endforeach;?>
              </td>
              <td>
                <a class="btn btn-warning btn-sm" href="<?= base_url()?>/admin/positions/edit/<?= esc($election['id'])?>" role="button" data-toggle="tooltip" data-placement="bottom" title="Edit election position"><i class="fas fa-edit"></i></a>
              </td>
            </tr>
            <?php $ctr++;?>
          <?php endforeach;?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection();?>

<?= $this->section('scripts') ?>

<script>
  // BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  // DataTables
  $(function () {
    $('#positions').DataTable({
      "responsive": true,
      "autoWidth": false,
      });
  });
</script>

<?= $this->endSection();?>