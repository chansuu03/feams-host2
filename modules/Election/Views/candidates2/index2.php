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
  <?php foreach($perm_id['perm_id'] as $perms):?>
    <?php if($perms == '27'):?>
      <div class="card-header">
        <a class="btn btn-primary float-right" href="<?= base_url('admin/candidates/add')?>" role="button">Add Candidate</a>
        <div class="float-left mr-2 mt-2">
            <label>Select Election</label>
        </div>
        <select class="form-control input-sm select2 w-25" id="election_id" name="election_id">
          <?php foreach($elections as $election):?>
            <option value="<?= esc($election['id'])?>"><?= esc($election['title'])?></option>
          <?php endforeach;?>
        </select>
      </div>
    <?php endif;?>
  <?php endforeach;?>
  <div class="card-body">
    <div id="table">
      <table class="table" id="candidates">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Position</th>
            <th scope="col">Photo</th>
            <?php $access = false;?>
            <?php foreach($perm_id['perm_id'] as $perms):?>
              <?php if($perms == '28'):?>
                <?php $access = true;?>
              <?php endif;?>
              <?php if($perms == '29'):?>
                <?php $access = true;?>
              <?php endif;?>
            <?php endforeach;?>
            <?php if($access):?>
              <th scope="col">Action</th>
            <?php endif;?>
          </tr>
        </thead>
        <tbody>
            <?php $ctr = 1?>
            <?php if(empty($candidates)): ?>
              <tr>
                <td colspan="5" class="text-center">No current candidates</td>
              </tr>
            <?php else: ?>
              <?php foreach($candidates as $candidate): ?>
                <tr>
                  <td><?=esc($ctr)?></td>
                  <td><?=esc($candidate['first_name'])?> <?=esc($candidate['last_name'])?></td>
                  <td><?=esc($candidate['name'])?></td>
                  <td>
                    <?php if(!empty($candidate['photo'])):?>
                      <a href="<?=base_url('uploads/candidates').'/'.esc($candidate['photo'])?>">View Candidate Photo</a>
                    <?php else:?>
                      <a href="<?=base_url('uploads/profile_pic').'/'.esc($candidate['profile_pic'])?>">View Candidate Photo</a>
                    <?php endif;?>
                  </td>
                  <?php foreach($perm_id['perm_id'] as $perms):?>
                      <?php if($perms == '25'):?>
                        <td>
                          <button type="button" value="<?= esc($candidate['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete candidate"><i class="fas fa-trash"></i></button>
                        </td>
                    <?php endif;?>
                  <?php endforeach;?>
                </tr>
                <?php $ctr++?>            
              <?php endforeach;?>
            <?php endif; ?>
        </tbody>
      </table>
    </div>
    <!-- <table class="table" id="candidates">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Position</th>
          <th scope="col">Photo</th>
          <th scope="col">Platform</th>
          <?php $access = false;?>
          <?php foreach($perm_id['perm_id'] as $perms):?>
            <?php if($perms == '28'):?>
              <?php $access = true;?>
            <?php endif;?>
            <?php if($perms == '29'):?>
              <?php $access = true;?>
            <?php endif;?>
          <?php endforeach;?>
          <?php if($access):?>
            <th scope="col">Action</th>
          <?php endif;?>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1?>
        <?php if(empty($candidates)): ?>
          <tr>
            <td colspan="6" class="text-center">No current candidates</td>
          </tr>
        <?php else: ?>
          <?php foreach($candidates as $candidate): ?>
            <?php $ctr++?>            
          <?php endforeach;?>
        <?php endif; ?>
      </tbody>
    </table> -->
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
    $('#candidates').DataTable({
      "responsive": true,
      "autoWidth": false,
      });
  });

  // Select on change
  $('#election_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('admin/candidates/election'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#table').html('Loading Table ...');
      },
      success: function (data) {
        $('#table').html(data);
      }
    })
  })
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
        text: 'Are you sure to delete candidate?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'candidates/delete/' + id;
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>
<?= $this->endSection();?>