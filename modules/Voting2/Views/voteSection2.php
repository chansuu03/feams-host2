<form action="<?= base_url('votes2/cast')?>" method="post" id="voting">
    <input type="hidden" value="<?= esc($election['id'])?>" name="election_id">
    <div class="card">
      <div class="card-body">
        <div class="form-group"> <!-- Full time  -->
          <label for="regular">Full-time Employees</label>
          <select class="form-control selectMulti <?=isset($errors['regular']) ? 'is-invalid': ''?>" multiple="multiple" id="regular" name="regular[]" data-placeholder="Select employee/s" required>
            <option value="">Select...</option>
            <?php foreach($users as $user):?>
              <?php if($user['type'] == '1'):?>
                <option value="<?= esc($user['id'])?>"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></option>
              <?php endif?>
            <?php endforeach;?>
          </select>
        </div>
        <div class="form-group"> <!-- Part time -->
          <label for="regular">Part-time Employees</label>
          <select class="form-control selectMulti <?=isset($errors['part-time']) ? 'is-invalid': ''?>" multiple="multiple" id="part-time" name="part-time[]" data-placeholder="Select employee/s" required>
            <option value="">Select...</option>
            <?php foreach($users as $user):?>
              <?php if($user['type'] == '2'):?>
                <option value="<?= esc($user['id'])?>"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></option>
              <?php endif?>
            <?php endforeach;?>
          </select>
        </div>
        <div class="form-group"> <!-- Admin -->
          <label for="regular">Admin Employees</label>
          <select class="form-control selectMulti <?=isset($errors['admin']) ? 'is-invalid': ''?>" multiple="multiple" id="admin" name="admin[]" data-placeholder="Select employee/s" required>
            <option value="">Select...</option>
            <?php foreach($users as $user):?>
              <?php if($user['type'] == '3'):?>
                <option value="<?= esc($user['id'])?>"><?= esc($user['first_name'])?> <?= esc($user['last_name'])?></option>
              <?php endif?>
            <?php endforeach;?>
          </select>
        </div>
        <small>4 employees should be selected per type of employee.</small>
      </div>
    </div>
    <button class="btn btn-primary btn-sm justify-content-end cast">Cast Vote</button>
</form>

<!-- Select2 -->
<script src="<?= base_url();?>/public/dist/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {    
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2({
        theme: 'bootstrap4',
      })
      $('.selectMulti').select2({
        theme: 'bootstrap4',
        maximumSelectionLength: 4,
      })
    })
    
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
