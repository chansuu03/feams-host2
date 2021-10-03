<div class="form-group"> <!-- Position -->
    <label for="position_id">Position</label>
    <select class="form-control select2 <?=isset($errors['position_id']) ? 'is-invalid': ''?>" id="position_id" name="position_id" <?= empty($positions) ? 'disabled' : ''?>>
    <option value=""><?= empty($positions) ? 'No added positions for this election' : 'Select...'?></option>
    <?php foreach($positions as $position):?>
        <option value="<?= esc($position['id'])?>"><?= esc($position['name'])?></option>
    <?php endforeach;?>
    </select>
    <?php if(isset($errors['position_id'])):?>
        <div class="invalid-feedback">
            <?=esc($errors['position_id'])?>
        </div>
    <?php endif;?>
</div>

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
      url: "<?php echo base_url('admin/candidates/elec'); ?>" + "/" + $(this).val(),
      beforeSend: function (f) {
        $('#positions').html('Loading Table ...');
      },
      success: function (data) {
        $('#positions').html(data);
      }
    })
  })
</script>