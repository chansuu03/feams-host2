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
    <div class="d-flex justify-content-between">
      <span class="mt-1">Payments</span>
      <a class="btn btn-primary btn-sm" href="<?= base_url('payments/add')?>" role="button">Add Payment</a>
    </div>
  </div>
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
        <?php foreach($payments as $pay):?>
          <tr>
            <th><?= esc($ctr)?></th>
            <td><?= esc($pay['name'])?></td>
            <td><?= esc($pay['cost'])?></td>
            <td><?= esc($pay['amount'])?></td>
            <td>
              <a href="<?= base_url('public/uploads/payments')?>/<?= esc($pay['photo'])?>" target="_blank">View Proof</a>
            </td>
            <td>
              <?php
                  switch ($pay['is_approved']) {
                    case "0":
                      echo "Not approved";
                      break;
                    case "1":
                      echo "Approved";
                      break;
                    case "2":
                      echo "Waiting for approval";
                      break;
                  }
              ?>
            </td>
            <td>
              <?php if($pay['is_approved'] == '2'):?>
                <button type="button" class="btn btn-danger btn-sm del" value="<?= esc($pay['id'])?>"><i class="fas fa-trash"></i></button>
              <?php endif?>
            </td>
          </tr>
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
    $('#payments').DataTable({
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
    