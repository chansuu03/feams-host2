<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content_header');?>
<div class="col-sm-6">
  <h1 class="m-0 text-dark">Voting</h1>
</div><!-- /.col -->
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item active">Voting</li>
  </ol>
</div><!-- /.col -->
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
<?php if(!empty(session()->getFlashdata('firstVoter'))):?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('firstVoter');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif;?>

<?php if($voted):?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    You have voted, please wait for the results.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?= view('Modules\Voting\Views\results')?>
<?php elseif(!empty($first_voter)):?>
  <?= view('Modules\Voting\Views\results')?>
<?php else:?>
<form action="<?= base_url('voting')?>" method="post" enctype="multipart/form-data" id="voting">
    <input type="hidden" name="election_id" value="<?= esc($elecID)?>">
    <?php if(!empty($positions)):?>
        <?php foreach($positions as $position):?>
            <div class="card">
                <div class="card-header">
                    <?= esc($position['name'])?>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach($candidates as $candidate):?>
                          <?php if($candidate['position_id'] == $position['id']):?>
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?= esc($position['id'])?>" value="<?= esc($candidate['id'])?>">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <?= esc($candidate['first_name'])?> <?= esc($candidate['last_name'])?>
                                    </label>
                                </div>
                            </li>
                          <?php endif;?>
                        <?php endforeach;?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?= esc($position['id'])?>" value="" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Abstain
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <!-- <button type="submit" class="btn btn-primary btn-sm float-right cast">Cast Vote</button> -->
    <button class="btn btn-primary btn-sm float-right cast">Cast Vote</button>
</form>
<?php endif;?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {
    $('.cast').click(function (e)
    {
      e.preventDefault();
      // console.log(id);

      Swal.fire({
        icon: 'question',
        text: 'Vote cannot be changed after its casted. Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          document.getElementById("voting").submit();
          // window.location = 'announcements/delete/' + id;
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