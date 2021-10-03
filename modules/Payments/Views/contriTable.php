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
            <button type="button" value="<?= esc($pay['id'])?>" class="btn btn-success btn-sm acc" data-toggle="tooltip" data-placement="bottom" title="Approve Payment"><i class="fas fa-thumbs-up"></i></button>
            <button type="button" value="<?= esc($pay['id'])?>" class="btn btn-danger btn-sm dec" data-toggle="tooltip" data-placement="bottom" title="Decline Payment"><i class="fas fa-thumbs-down"></i></button>
          <?php endif?>
        </td>
      </tr>
    <?php endforeach?>
  </tbody>
</table>

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
    $('.acc').click(function (e)
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