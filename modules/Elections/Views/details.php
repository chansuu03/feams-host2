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

<div class="card">
  <div class="card-header ">
    <strong>Election Title: </strong><?= esc($election['title'])?>
  </div>
  <div class="card-body">
    <p class="card-text">
      Vote dates: <?= esc(date('F d,Y g:iA',strtotime($election['vote_start'])))?> - <?= esc(date('F d,Y g:iA',strtotime($election['vote_end'])))?>
    </p>

    <div class="row">
        <!-- Positions -->
        <div class="col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-handshake"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Positions</span>
                <span class="info-box-number"><?= esc($positionCount)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- Candidates -->
        <div class="col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Candidates</span>
                <span class="info-box-number"><?= esc($candidateCount)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- Total Votes -->
        <div class="col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-vote-yea"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Votes</span>
                <span class="info-box-number"><?= esc($voteCount)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    </div>
  </div>
  <?php if($election['status'] == 'Finished'):?>
    <div class="card-footer">
      <a class="btn btn-primary float-right" href="<?= base_url()?>/admin/elections/<?= esc($election['id'])?>/pdf" role="button" style="margin-right: 5px;">
        <i class="fas fa-download"></i> Generate PDF
      </a>
    </div>
  <?php endif;?>
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
    $('#election_details').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>
<?= $this->endSection();?>