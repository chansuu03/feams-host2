<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>/admin/payments">Payments</a></li>
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
  <!-- <div class="card-header">
    <div class="d-flex justify-content-between">
      <span class="mt-1">Payments</span>
      <a class="btn btn-primary btn-sm" href="<?= base_url('payments/add')?>" role="button">Add Payment</a>
    </div>
  </div> -->
  <div class="card-body">
    <table class="table table-hover" id="payments">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Subject</th>
          <th scope="col">Comment</th>
          <th scope="col">Added by</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($feedbacks as $fback):?>
          <tr>
            <td><?= esc($ctr)?></td>
            <td><?= esc($fback['subject'])?></td>
            <td><?= esc($fback['comment'])?></td>
            <td><?= esc($fback['first_name'])?> <?= esc($fback['last_name'])?></td>
          </tr>
          <?php $ctr++?>
        <?php endforeach?>
      </tbody>
    </table>
  </div>
  <div class="card-footer">
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
// BS4 tooltips
  $(function () {
    $('.upload').tooltip()
  })
  
  // DataTables
  $(function () {
    $('#payments').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });

  function isNumberKey(evt)
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
        return false;

    return true;
  }

  // document.querySelector('.custom-file-input').addEventListener('change', function (e) {
  //   var name = document.getElementById("photo").files[0].name;
  //   var nextSibling = e.target.nextElementSibling
  //   nextSibling.innerText = name
  // })
  $('#photo').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(cleanFileName);
  })
</script>

<script>
  $('#attachment').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(cleanFileName);
  })
</script>
<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script>
  $(document).ready(function ()
  {
    $('.sub').click(function (e)
    {
      e.preventDefault();
      var link = $(this).val();
      console.log(link);

      Swal.fire({
        icon: 'question',
        text: 'Pay for the contribution?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, upload it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          document.getElementById("payUpload").submit();
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>

<script type="text/javascript">

  <?php if(!empty(session()->getFlashdata('feedErrors'))):?>
    $('#feedbackModal').modal('show')
  <?php endif;?>

  function upPhoto(id, amt, name){
		document.getElementById('cont_id').value = id;
		document.getElementById('cont_name').placeholder = name;
		document.getElementById('modalAmt').value = amt;
	}

  function feedbackUser(userID) {
    document.getElementById('feedUserID').value = userID;
  }

  $(document).ready(function ()
  {
    $('.del').click(function (e)
    {
      e.preventDefault();
      var link = $(this).val();
      console.log(link);

      Swal.fire({
        icon: 'question',
        title: 'Delete?',
        text: 'Are you sure to remove payment?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'payments/delete/' + link;
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
    