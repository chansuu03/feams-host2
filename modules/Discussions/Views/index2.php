<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('page_header');?>
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

<?php $manage = false;?>
<?php foreach($perm_id['perm_id'] as $perms):?>
  <?php if($perms == '35'):?>
    <?php $manage = true;?>
  <?php endif;?>
<?php endforeach;?>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <!-- for all discussion -->
      <div class="card" id="all">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <span class="<?= $manage ? 'mt-1' : ''?>">Discussions</span>
            <?php if($manage):?>
              <a class="btn btn-primary btn-sm float right" href="<?= base_url('discussions/manage')?>" role="button">Manage Discussions</a>
            <?php endif;?>
          </div>
        </div>
        <div class="card-body">
          <div class="text-right mb-3">
              <a class="btn btn-primary btn-sm float right" href="<?= base_url('discussions/add')?>/0" role="button">Add Thread</a>
          </div>
          <ul class="list-group">
            <?php foreach($allThreads as $thread):?>
              <li class="list-group-item">
                <div class="row justify-content-between">
                    <a href="<?= base_url()?>/discussions/<?= $thread['link']?>"><?= esc($thread['subject'])?></a>
                    <span>Date Posted: 
                    <?php
                        $date = date_create(esc($thread['created_at']));
                        echo date_format($date, 'F d, Y g:ia');
                    ?>
                    </span>
                </div>
                <div class="row justify-content-between">
                    <span><?= esc($thread['first_name'])?> <?= esc($thread['last_name'])?></span>
                    <?php $access = false;?>
                    <?php foreach($perm_id['perm_id'] as $perms):?>
                      <?php if($perms == '35' || $thread['creator'] == session()->get('user_id')):?>
                        <?php if(!$access):?>
                          <button type="button" value="<?= esc($thread['id'])?>" class="btn btn-danger btn-sm del">Delete</button>
                          <?php $access = true;?>
                        <?php endif;?>
                      <?php endif;?>
                    <?php endforeach;?>
                </div>
              </li>
            <?php endforeach;?>
          </ul>
        </div>
        <div class="card-footer">
          <?php if ($thread_pager) :?>
              <?php $pagi_path='discussions'; ?>
              <?php $thread_pager->setPath($pagi_path); ?>
              <?= $thread_pager->links('0', 'bs_pagination') ?>
          <?php endif ?>
        </div>
      </div>
      <!-- Per role discussion -->
      <div class="card" id="role">
          <div class="card-header">
            <?= esc($roles['role_name'])?> discussions
          </div>
          <div class="card-body">
            <div class="text-right mb-3">
                <a class="btn btn-primary btn-sm float right" href="<?= base_url('discussions/add')?>/<?= session()->get('role')?>" role="button">Add Thread</a>
            </div>
            <ul class="list-group">
                <?php foreach($threads as $thread):?>
                  <li class="list-group-item">
                    <div class="row justify-content-between">
                        <a href="<?= base_url()?>/discussions/<?= $thread['link']?>"><?= esc($thread['subject'])?></a>
                        <span>Date Posted: 
                        <?php
                            $date = date_create(esc($thread['created_at']));
                            echo date_format($date, 'F d, Y g:ia');
                        ?>
                        </span>
                    </div>
                    <div class="row justify-content-between">
                        <span><?= esc($thread['first_name'])?> <?= esc($thread['last_name'])?></span>
                        <?php $access = false;?>
                        <?php foreach($perm_id['perm_id'] as $perms):?>
                          <?php if($perms == '34' || $thread['creator'] == session()->get('user_id')):?>
                            <?php if(!$access):?>
                              <button type="button" value="<?= esc($thread['id'])?>" class="btn btn-danger btn-sm del">Delete</button>
                              <?php $access = true;?>
                            <?php endif;?>
                          <?php endif;?>
                        <?php endforeach;?>
                    </div>
                  </li>
                <?php endforeach;?>
            </ul>
          </div>
          <div class="card-footer">
            <?php if ($thread_pager) :?>
                <?php $pagi_path='discussions'; ?>
                <?php $thread_pager->setPath($pagi_path); ?>
                <?= $thread_pager->links(session()->get('role'), 'bs_pagination') ?>
            <?php endif ?>
          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <ul class="list-group list-group-flush">
          <a href="#all" class="list-group-item list-group-item-action">Discussions</a>
          <a href="#role" class="list-group-item list-group-item-action"><?= esc($roles['role_name'])?> discussions</a>
        </ul>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts')?>

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
        text: 'Are you sure to delete thread?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          window.location = 'discussions/delete/' + id;
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