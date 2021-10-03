<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">
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

<div class="col-sm-6">
    <div class="form-group row"> <!-- Elections -->
        <label for="staticEmail" class="col-sm-4 col-form-label">Select Election</label>
        <div class="col-sm-8">
            <select class="form-control select2 <?=isset($errors['election_id']) ? 'is-invalid': ''?>" id="election_id" name="election_id">
                <option value="">Select...</option>
                <?php foreach($elections as $election):?>
                <option value="<?= esc($election['id'])?>"><?= esc($election['title'])?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
</div>

<div id="elections" class="container">
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- Select2 -->
<script src="<?= base_url();?>/public/dist/select2/js/select2.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4',
    })
  })

  // Select on change
  $('#election_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('voting/elec'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#elections').html('Loading Table ...');
      },
      success: function (data) {
        $('#elections').html(data);
      },
      error: function(f) {
        $('#elections').html('Please select an election');
      }
    })
  })
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
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