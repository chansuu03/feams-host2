<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
<div class="row mb-1">
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

<?php $reportAccess = false; 
  foreach($rolePermission as $permits) {
    if($permits['perm_mod'] == 'REPO') {
      $reportAccess = true; 
      break;
    }
  }?>


<div class="clearfix mb-3 mr-1">
  <a class="btn btn-primary float-right ml-1" href="<?= base_url('file_sharing/add')?>" role="button">Upload file</a>
  <?php if($reportAccess):?>
    <a class="btn btn-primary float-right" href="<?= base_url('file_sharing/generatePDF')?>" role="button">Generate PDF</a>
  <?php endif;?>
</div>

<?php 
  function readableBytes($bytes) {
      $i = floor(log($bytes) / log(1024));
      $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
  
      return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
  }

  $delete = false;
  $accessAdmin = false;
  foreach($perm_id['perm_id'] as $perms) {
      if($perms == '32') {
        $delete = true;
      } elseif($perms == '31') {
        $accessAdmin = true;
      }
  }
?>

<!-- Documents -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Documents</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">File Name</th>
          <th scope="col">Size</th>
          <?php if($accessAdmin):?>
            <th scope="col">Visibility</th>
          <?php endif;?>
          <th scope="col">Uploader</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($files as $file):?>
          <?php if($file['category'] === 'Documents'):?>
            <?php if($file['visibility'] === 'for all'):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>For all</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
            <?php if(($file['visibility'] === 'admin' && $accessAdmin) || ($file['visibility'] === 'admin' && $file['uploader'] == session()->get('user_id'))):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>Admin only</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
          <?php endif;?>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<!-- Media -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Media</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">File Name</th>
          <th scope="col">Size</th>
          <?php if($accessAdmin):?>
            <th scope="col">Visibility</th>
          <?php endif;?>
          <th scope="col">Uploader</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($files as $file):?>
          <?php if($file['category'] === 'Media'):?>
            <?php if($file['visibility'] === 'for all'):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>For all</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
            <?php if(($file['visibility'] === 'admin' && $accessAdmin) || ($file['visibility'] === 'admin' && $file['uploader'] == session()->get('user_id'))):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>Admin only</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
          <?php endif;?>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<!-- Images -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Images</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">File Name</th>
          <th scope="col">Size</th>
          <?php if($accessAdmin):?>
            <th scope="col">Visibility</th>
          <?php endif;?>
          <th scope="col">Uploader</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($files as $file):?>
          <?php if($file['category'] === 'Images'):?>
            <?php if($file['visibility'] === 'for all'):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>For all</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
            <?php if(($file['visibility'] === 'admin' && $accessAdmin) || ($file['visibility'] === 'admin' && $file['uploader'] == session()->get('user_id'))):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>Admin only</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
          <?php endif;?>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<!-- Others -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Others</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">File Name</th>
          <th scope="col">Size</th>
          <?php if($accessAdmin):?>
            <th scope="col">Visibility</th>
          <?php endif;?>
          <th scope="col">Uploader</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($files as $file):?>
          <?php if($file['category'] === 'Others'):?>
            <?php if($file['visibility'] === 'for all'):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>For all</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
            <?php if(($file['visibility'] === 'admin' && $accessAdmin) || ($file['visibility'] === 'admin' && $file['uploader'] == session()->get('user_id'))):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($file['file_name'])?></td>
                <td><?= esc(readableBytes($file['size']))?></td>
                <?php if($accessAdmin):?>
                  <td>Admin only</td>
                <?php endif;?>
                <td><?= esc($file['first_name']).' '.esc($file['last_name'])?></td>
                <td>
                  <!-- download -->
                  <a class="btn btn-success btn-sm" href="<?= base_url()?>/file_sharing/download/<?= esc($file['id'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a>
                  <!-- <a class="btn btn-success btn-sm" href="<?= base_url()?>/uploads/files/<?= esc($file['category'])?>/<?= esc($file['file_name'])?>" role="button"  data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fas fa-download"></i></a> -->
                  <?php if($delete || $file['uploader'] == session()->get('user_id')):?>
                    <button type="button" value="<?= esc($file['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                  <?php endif;?>
                </td>
              </tr>
            <?php endif;?>
          <?php endif;?>
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
    $('.table').DataTable({
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
          window.location = '<?= base_url()?>/file_sharing/delete/' + id;
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