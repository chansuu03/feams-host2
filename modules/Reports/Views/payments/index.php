<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= esc($title)?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Reports</li>
            <li class="breadcrumb-item active">Login</li>
        </ol>
    </div><!-- /.col -->
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
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <span class="mt-1">All contributions</span>
      <button type="button" class="btn btn-primary align-self-end btn-sm" data-toggle="modal" data-target="#exampleModal">Generate PDF</button>
    </div>
  </div>
  <div class="card-body">
    <div id="table">
        <table class="table table-hover" id="payreports">
            <thead class="thead-light">
                <tr>
                <th scope="col" style="width: 10%">#</th>
                <th scope="col">Contribution Name</th>
                <th scope="col">Contributor</th>
                <th scope="col">Amount</th>
                <th scope="col">Date Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php $ctr = 1?>
                <?php foreach($allPayments as $payment):?>
                <tr>
                    <td><?= esc($ctr)?></td>
                    <td><?= esc($payment['name'])?></td>
                    <td><?= esc(ucwords(strtolower($payment['first_name'])))?> <?= esc(ucwords(strtolower($payment['last_name'])))?></td>
                    <td><?= esc($payment['amount'])?>.00</td>
                    <td><?= esc(date('F d,Y H:i:s', strtotime($payment['created_at'])))?></td>
                </tr>
                <?php $ctr++?>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
  </div>
</div>

<form action="<?= base_url('admin/reports/payments')?>" method="post">
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Generate PDF</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="formGroupExampleInput">Type of report</label>
            <select class="form-control" name="type" id="type">
              <option value="1">List of Contributions</option>
              <option value="2">Paid contributions</option>
              <option value="3">Not paid for the contributions</option>
            </select>
          </div>
          <div class="form-group" style="display:none;" id="contris">
            <label for="formGroupExampleInput">Select contribution</label>
            <select class="form-control" name="cont">
              <option value="" selected>Select...</option>
              <?php foreach($contributions as $contri):?>
                <option value="<?= esc($contri['id'])?>"><?= esc($contri['name'])?></option>
              <?php endforeach?>
            </select>
          </div>
          <div class="form-group ranges" id="ranges">
            <label for="formGroupExampleInput">Date range</label>
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;  
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
            <input type="hidden" name="start" id="start">
            <input type="hidden" name="end" id="end">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Generate PDF</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?= $this->endSection();?>

<?= $this->section('scripts') ?>

<script>
  document.getElementById('type').addEventListener('change', function () {
      var style = this.value == '3' ? 'block' : 'none';
      var datestyle = this.value == '3' ? 'none' : 'block';
      document.getElementById('contris').style.display = style;
      document.getElementById('ranges').style.display = datestyle;
  });
</script>

<script>
  // DataTables
  $(function () {
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate.format('YYYY-MM-DD'));
        document.getElementById('start').value = picker.startDate.format('YYYY-MM-DD');
        console.log(picker.endDate.format('YYYY-MM-DD'));
        document.getElementById('end').value = picker.endDate.format('YYYY-MM-DD');
    });
});
</script>
<?= $this->endSection() ?>
