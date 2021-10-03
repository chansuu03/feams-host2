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
    <a class="btn btn-primary float-right" href="<?= base_url('payments/admin/add')?>" role="button">Add Payment</a>
    <div class="float-left mr-2 mt-2">
        <label>Select Contribution</label>
    </div>
    <select class="form-control input-sm select2 w-25" id="contrib" name="contrib">
      <?php foreach($contri as $con):?>
        <option value="<?= esc($con['id'])?>"><?= esc($con['name'])?> - <?= esc($con['cost'])?> </option>
      <?php endforeach;?>
    </select>
  </div>
  <div class="card-body">
    <div id="table-pay">
      <table class="table table-hover" id="payments">
        <thead>
          <tr>
            <th scope="col" style="width: 8%;">#</th>
            <th scope="col" style="width: 35%;">Name</th>
            <th scope="col" style="width: 15%;">Amount</th>
            <th scope="col">Proof</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 15%;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $ctr = 1;?>
          <?php foreach($payments as $pay):?>
            <?php if($pay['contri_id'] == $contri[0]['id']):?>
              <tr>
                <th><?= esc($ctr)?></th>
                <td><?= esc($pay['first_name'])?> <?= esc($pay['last_name'])?></td>
                <td><?= esc($pay['amount'])?></td>
                <td><a href="<?= base_url('public/uploads/payments')?>/<?= esc($pay['photo'])?>" target="_blank">View Proof</a></td>
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
                    <button type="button" value="<?= esc($pay['id'])?>" class="btn btn-success btn-sm app" data-toggle="tooltip" data-placement="bottom" title="Approve Payment"><i class="fas fa-thumbs-up"></i></button>
                    <button type="button" value="<?= esc($pay['id'])?>" class="btn btn-danger btn-sm dec" data-toggle="tooltip" data-placement="bottom" title="Decline Payment"><i class="fas fa-thumbs-down"></i></button>
                  <?php endif?>
                </td>
              </tr>
            <?php endif;?>
          <?php endforeach?>
        </tbody>
      </table>
    </div>
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

  // Select on change
  $('#contrib').change(function(){
    $.ajax({
      url: "<?php echo base_url('payments/contri'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#table-pay').html('Loading Table ...');
      },
      success: function (data) {
        $('#table-pay').html(data);
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
    $('.dec').click(function (e)
    {
      e.preventDefault();
      var id = $(this).val();

      Swal.fire({
        icon: 'question',
        title: 'Decline?',
        text: 'Are you sure to decline payment?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, decline it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'payments/decline/' + id;
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>
<!-- SweetAlert2 -->
<script type="text/javascript">
  $(document).ready(function ()
  {
    $('.app').click(function (e)
    {
      e.preventDefault();
      var id = $(this).val();

      Swal.fire({
        icon: 'question',
        title: 'Approve?',
        text: 'Are you sure to approve payment?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'payments/approve/' + id;
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
    