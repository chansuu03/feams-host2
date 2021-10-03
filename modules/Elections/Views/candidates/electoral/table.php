<!-- </pre> -->
<table class="table" id="candidates">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Position</th>
      <th scope="col">Photo</th>
      <?php $access = false;?>
      <?php foreach($perm_id['perm_id'] as $perms):?>
        <?php if($perms == '28'):?>
          <?php $access = true;?>
        <?php endif;?>
        <?php if($perms == '29'):?>
          <?php $access = true;?>
        <?php endif;?>
      <?php endforeach;?>
      <?php if($access):?>
        <th scope="col">Action</th>
      <?php endif;?>
    </tr>
  </thead>
  <tbody>
      <?php $ctr = 1?>
      <?php if(empty($candidates)): ?>
        <tr>
          <td colspan="5" class="text-center">No current candidates</td>
        </tr>
      <?php else: ?>
        <?php foreach($candidates as $candidate): ?>
          <tr>
            <td><?=esc($ctr)?></td>
            <td><?=esc($candidate['first_name'])?> <?=esc($candidate['last_name'])?></td>
            <td><?=esc($candidate['name'])?></td>
            <td>
              <?php if(!empty($candidate['photo'])):?>
                <a href="<?=base_url('uploads/candidates').'/'.esc($candidate['photo'])?>">View Candidate Photo</a>
              <?php else:?>
                <a href="<?=base_url('uploads/profile_pic').'/'.esc($candidate['profile_pic'])?>">View Candidate Photo</a>
              <?php endif;?>
            </td>
            <?php foreach($perm_id['perm_id'] as $perms):?>
                <?php if($perms == '25'):?>
                  <td>
                    <button type="button" value="<?= esc($candidate['id'])?>" class="btn btn-danger btn-sm del" data-toggle="tooltip" data-placement="bottom" title="Delete candidate"><i class="fas fa-trash"></i></button>
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
    $('#candidates').DataTable({
      "responsive": true,
      "autoWidth": false,
       "retrieve": true,
      });
  });

  // Select on change
  $('#election_id').change(function(){
    $.ajax({
      url: "<?php echo base_url('admin/candidates2/election'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#perElec').html('Loading Table ...');
      },
      success: function (data) {
        $('#perElec').html(data);
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
    $('.del').click(function (e)
    {
      e.preventDefault();
      var id = $(this).val();
      console.log(id);

      Swal.fire({
        icon: 'question',
        title: 'Delete?',
        text: 'Are you sure to delete candidate?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'candidates/delete/' + id;
        }
        else if (result.isDenied)
        {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })//then
    });
  });
</script>