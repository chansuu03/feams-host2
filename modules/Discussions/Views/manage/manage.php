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
  <div class="card-header">
    <div class="float-left mr-2 mt-2">
        <label>Select Role</label>
    </div>
    <select class="form-control input-sm select2 w-25" id="role_id" name="role_id">
        <option value="0">For all discussions</option>
      <?php foreach($roles as $role):?>
        <option value="<?= esc($role['id'])?>"><?= esc($role['role_name'])?></option>
      <?php endforeach;?>">
    </select>
  </div>
  <div class="card-body">
    <div id="table">
      <table class="table table-hover" id="discussions">
          <thead class="thead-light">
              <tr>
                <th scope="col" style="width: 10%">#</th>
                <th scope="col" style="width: 30%">Title</th>
                <th scope="col" style="width: 25%">Creator</th>
                <th scope="col" style="width: 20%">Created at</th>
                <th scope="col" style="width: 20%">Action</th>
              </tr>
          </thead>
          <tbody>
              <?php $ctr = 1?>
              <?php foreach($threads as $thread):?>
                <tr>
                  <th><?= esc($ctr)?></th>
                  <td><?= esc($thread['subject'])?></td>
                  <td><?= esc($thread['first_name'])?> <?= esc($thread['last_name'])?></td>
                  <td><?= esc(date('F d,Y', strtotime($thread['created_at'])))?></td>
                  <td class="d-flex justify-content-center">
                    <a class="btn btn-info btn-sm" href="<?= base_url('discussions/manage')?>/<?= esc($thread['link'])?>" role="button" data-toggle="tooltip" data-placement="bottom" title="View discussion"><i class="fas fa-bars"></i></a>
                  </td>
                </tr>
                <?php $ctr++;?>
              <?php endforeach?>
          </tbody>
      </table>
    </div>
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
    $('#discussions').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });

  // Select on change
  $('#role_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('discussions/manage/role'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#table').html('Loading Table ...');
      },
      success: function (data) {
        $('#table').html(data);
      }
    })
  })
</script>

<?= $this->endSection() ?>
    