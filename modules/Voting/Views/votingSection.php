<form action="<?= base_url('voting/cast')?>" method="post" id="voting">
    <input type="hidden" value="<?= esc($election['id'])?>" name="election_id">
    <?php foreach($positions as $position):?>
        <div class="card">
            <div class="card-header">
                <?= esc($position['name'])?>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach($candidates as $candidate):?>
                      <?php if($candidate['position_id'] == $position['id']):?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="<?= esc($position['id'])?>" value="<?= esc($candidate['id'])?>">
                                        <label class="form-check-label" for="exampleRadios1">
                                            <?= esc($candidate['first_name'])?> <?= esc($candidate['last_name'])?>
                                        </label>
                                    </div>
                                    <?php if(!empty($candidate['photo'])):?>
                                        <img src="<?= base_url('uploads/candidates')?>/<?= esc($candidate['photo'])?>" alt="..." class="img-thumbnail" style="height: 200px; width: 200px;">
                                    <?php else:?>
                                        <img src="<?= base_url('uploads/profile_pic')?>/<?= esc($candidate['profile_pic'])?>" alt="..." class="img-thumbnail" style="height: 200px; width: 200px;">
                                    <?php endif;?>
                                </div>
                                <div class="col-md-6">
                                  <dl class="row">
                                    <dt class="col-md-3">Platform</dt>
                                      <dd class="col-md-9"><?= esc($candidate['platform'], 'raw')?></dd>
                                  </dl>
                                </div>
                            </div>
                            <!-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?= esc($position['id'])?>" value="<?= esc($candidate['id'])?>">
                                <label class="form-check-label" for="exampleRadios1">
                                    <?= esc($candidate['first_name'])?> <?= esc($candidate['last_name'])?>
                                </label>
                            </div>
                            <?php if(!empty($candidate['photo'])):?>
                                <img src="<?= base_url('uploads/candidates')?>/<?= esc($candidate['photo'])?>" alt="..." class="img-thumbnail" style="height: 200px; width: 200px;">
                            <?php else:?>
                                <img src="<?= base_url('uploads/profile_pic')?>/<?= esc($candidate['profile_pic'])?>" alt="..." class="img-thumbnail" style="height: 200px; width: 200px;">
                            <?php endif;?> -->
                        </li>
                      <?php endif;?>
                    <?php endforeach;?>
                    <li class="list-group-item">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="<?= esc($position['id'])?>" value="" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Abstain
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    <?php endforeach;?>
    <button class="btn btn-primary btn-sm justify-content-end cast">Cast Vote</button>
</form>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {
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
