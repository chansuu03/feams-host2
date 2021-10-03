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
    <?php if($perms == '19'):?>
      <div class="card-header">
        <a class="btn btn-primary btn-sm float-right" href="<?= base_url('admin/elections/add')?>" role="button">Add Election</a>
      </div>
    <?php endif;?>
  <?php endforeach;?>
  <div class="card-body">
    <table class="table" id="elections">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
          <th scope="col">Status</th>
          <th scope="col">Date Created</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1?>
        <?php if(empty($elections)): ?>
          <tr>
            <td colspan="8" class="text-center">No current elections</td>
          </tr>
        <?php else: ?>
          <?php foreach($elections as $election): ?>
            <tr>
              <td><?=esc($ctr)?></td>
              <td><?=esc($election['title'])?></td>
              <td>
                <?php
                  $date = date_create(esc($election['vote_start']));
                  echo date_format($date, 'F d, Y g:ia');
                  ?>
              </td>
              <td>
                <?php
                  $date = date_create(esc($election['vote_end']));
                  echo date_format($date, 'F d, Y g:ia');
                  ?>
              </td>
              <td><?= esc($election['status'])?></td>
              <td>
                <?php
                  $date = date_create(esc($election['created_at']));
                  echo date_format($date, 'F d, Y g:ia');
                ?>
              <td>
                <?php foreach($perm_id['perm_id'] as $perms):?>
                  <?php if($perms == '18'):?>
                    <a class="btn btn-info btn-sm" href="<?=base_url('admin/elections/' . esc($election['id'], 'url'))?>" data-toggle="tooltip" data-placement="bottom" title="Election info"> <i class="fas fa-bars"></i> </a>
                  <?php elseif($perms == '20' && $election['status'] == 'Application'):?>
                    <a class="btn btn-warning btn-sm" href="<?=base_url('admin/elections/edit/' . esc($election['id'], 'url'))?>" data-toggle="tooltip" data-placement="bottom" title="Edit election"> <i class="fas fa-edit"></i> </a>
                  <?php elseif($perms == '21'):?>
                    <?php if($election['status'] != "Finished"):?>
                        <button type="button" value="<?= esc($election['id'])?>" class="btn btn-success btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Finish election"><i class="fas fa-check-circle"></i></button>
                    <?php endif;?>
                  <?php endif;?>
                <?php endforeach;?>
                <!-- <a class="btn btn-primary btn-sm" href="<?=base_url('admin/elections/edit/' . esc($election['id'], 'url'))?>"> <i class="fas fa-edit"></i> </a> -->
              </td>
            </tr>
            <?php $ctr++?>            
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
    $('#elections').DataTable({
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
        // title: 'Delete?',
        text: 'Are you sure to finish election?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, finish it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = '<?= base_url()?>/admin/elections/delete/' + link;
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>


<!-- SCRIPTS -->
<?php if(!empty(session()->getFlashdata('activeElec'))):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
	<script>
		window.onload = function() {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: '<?= session()->getFlashdata('activeElec')?>',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Okay'
			})/*swal2*/.then((result) =>
			{
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed)
				{
					Swal.close()
				}
			})//then
		};
	</script>
<?php endif;?>
<?= $this->endSection();?>