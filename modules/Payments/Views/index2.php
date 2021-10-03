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
          <th scope="col" style="width: 35%;">Contribution</th>
          <th scope="col">Cost</th>
          <th scope="col" style="width: 15%;">Amount Paid</th>
          <th scope="col">Proof</th>
          <th scope="col">Status</th>
          <th scope="col" style="width: 10%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 1;?>
        <?php foreach($contri as $conts):?>
          <tr>
            <th><?= esc($ctr)?></th>
            <td><?= esc($conts['name'])?></td>
            <td><?= esc($conts['cost'])?></td>
            <td>
              <?php
                $amount = 0;
                foreach($payments as $pay) {
                  if($pay['contri_id'] == $conts['id']) {
                    $amount += $pay['amount'];
                  }
                }
                echo esc($amount);
              ?>
            </td>
            <td>
              <?php if($amount != 0):?>
                <?php foreach($payments as $pay):?>
                    <?php if($pay['contri_id'] == $conts['id']):?>
                      <a href="<?= base_url('public/uploads/payments')?>/<?= esc($pay['photo'])?>" target="_blank">View Proof</a>
                      <?php break;?>
                    <?php endif?>
                <?php endforeach;?>
              <?php endif;?>
            </td>
            <td>
              <?php $hasPaid = false; foreach($payments as $pay) {
                if($pay['contri_id'] == $conts['id']) {
                  if($pay['is_approved'] == '0') {
                    echo "Not approved";
                    $hasPaid = true;
                    break;
                  } elseif($pay['is_approved'] == '1') {
                    echo "Approved";
                    $hasPaid = true;
                    break;
                  } elseif($pay['is_approved'] == '2') {
                    echo "Waiting for approval";
                    $hasPaid = true;
                    break;
                  }
                }
              }?>
              <?= !$hasPaid ? 'Not paid': ''?>
            </td>
            <td>
              <?php if($amount == 0):?>
                <button type="button" class="btn btn-primary btn-sm upload" data-toggle="modal" data-target="#uploadPhotoModal" data-placement="top" title="Upload proof" onclick="upPhoto(<?= esc($conts['id'])?>, <?= esc($conts['cost'])?>, '<?= esc($conts['name'])?>')"><i class="fas fa-file-invoice"></i></button>
              <?php endif;?>
            </td>
          </tr>
          <?php $ctr++;?>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#feedbackModal" onclick="feedbackUser(<?=session()->get('user_id')?>)"><i class="fas fa-comment-dots"></i> Send Feedback</button>
    </div>
  </div>
</div>

<!-- Feedback modal -->
<?= view('Modules\Payments\Views\feedbackmodal')?>

<form id="payUpload" action="<?= base_url('payments')?>/<?= $edit ? 'edit/'.esc($id): 'add'?>" method="post" enctype="multipart/form-data">
  <!-- Modal -->
  <div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload photo for payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="contri_id" id="cont_id">
            <input type="hidden" name="amount" id="modalAmt">
            <fieldset disabled>     
              <div class="form-group">
                <label for="cont_name">Contribution to be paid</label>
                <input type="text" id="cont_name" class="form-control" placeholder="">
              </div>
            </fieldset>
            <div class="form-group"> <!-- Photo -->
                <label for="photo">Photo</label>
                <div class="custom-file"> 
                    <input type="file" class="custom-file-input <?=isset($errors['photo']) ? 'is-invalid': ''?>" id="photo" name="photo">
                    <label class="custom-file-label" for="photo">Upload photo as proof of payment</label>
                </div>
                <?php if(isset($errors['photo'])):?>
                    <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                        <?=esc($errors['photo'])?>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <div class="modal-footer">
          <input class="btn btn-primary sub" type="submit" value="Submit">
        </div>
      </div>
    </div>
  </div>
</form>

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
    