<table class="table" id="positions">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Position Name</th>
      <th scope="col">Max candidates</th>
      <?php foreach($perm_id['perm_id'] as $perms):?>
        <?php if($perms == '25'):?>
          <th scope="col" style="width: 10%;">Action</th>
        <?php endif;?>
      <?php endforeach;?>
    </tr>
  </thead>
  <tbody>
      <?php $ctr = 1?>
      <?php if(empty($positions)): ?>
        <tr>
          <td colspan="4" class="text-center">No current positions</td>
        </tr>
      <?php else: ?>
        <?php foreach($positions as $position): ?>
          <tr>
            <td><?=esc($ctr)?></td>
            <td><?=esc($position['name'])?></td>
            <td><?=esc($position['max_candidate'])?></td>
            <?php foreach($perm_id['perm_id'] as $perms):?>
                <?php if($perms == '25'):?>
                  <td>
                    <button type="button" value="<?= esc($position['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete position"><i class="fas fa-trash"></i></button>
                  </td>
              <?php endif;?>
            <?php endforeach;?>
          </tr>
          <?php $ctr++?>            
        <?php endforeach;?>
      <?php endif; ?>
  </tbody>
</table>

<script>
  // BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
  // DataTables
  $(function () {
    $('#positions').DataTable({
      "responsive": true,
      "autoWidth": false,
       "retrieve": true,
      });
  });

  // Select on change
  $('#election_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('admin/positions/elec'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#table').html('Loading Table ...');
      },
      success: function (data) {
        $('#table').html(data);
      }
    })
  })
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
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
        text: 'Are you sure to delete position?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'positions/delete/' + id;
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>