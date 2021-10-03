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

<div class="clearfix mb-.25">
    <a class="btn btn-primary btn-sm float-right" href="<?= base_url('files/add')?>" role="button">Upload file</a>
</div><br>

<?php 
  function readableBytes($bytes) {
      $i = floor(log($bytes) / log(1024));
      $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
  
      return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
  }
?>

<?php if(empty($categories)):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'No file categories set, please contact page administrator',
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
<?php else:?>
  <?php foreach($categories as $category):?>
    <div class="card">
      <div class="card-header">
        <?= esc($category['name'])?>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">File Name</th>
              <th scope="col">Uploader</th>
              <th scope="col">Size</th>
              <th scope="col" style="width: 10%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $ctr = 1;?>
            <?php foreach($files as $file):?>
              <?php if($file['category_id'] == $category['id']):?>
                <tr>
                  <td><?= esc($ctr)?></td>
                  <td><a href="<?= base_url()?>/uploads/files/<?= esc($file['name'])?>" download><?= esc($file['name'])?></a></td>
                  <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                  <td><?=esc(readableBytes($file['size']))?></td>
                  <?php foreach($perm_id['perm_id'] as $perms):?>
                    <?php if($perms == '32'):?>
                      <?php if($file['uploader'] == session()->get('user_id')):?>
                        <td scope="row">
                            <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete category"><i class="fas fa-trash"></i></button>
                        </td>
                      <?php else:?>
                        <td scope="row">
                            download
                        </td>
                      <?php endif;?>
                    <?php endif;?>
                  <?php endforeach;?>
                </tr>
              <?php endif;?>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endforeach;?>
<?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
// BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  // DataTables
  $(function () {
    $('.table').DataTable({
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
        text: 'Are you sure to delete file?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'files/delete/' + id;
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