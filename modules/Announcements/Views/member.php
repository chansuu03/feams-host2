<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a></li>
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

<div class="container">
  <div class="row">
    <!-- News Start here -->
    <div class="col-md-8">
      <h3>Latest Announcement</h3>
      <div class="mt-2">
        <?php foreach($announcements as $announce):?>
        <h5><?= esc($announce['title'])?></h5>
        <?= esc($announce['description'], 'raw')?>
          <?php break;?>
        <?php endforeach;?>
      </div>
    </div>
    <div class="col-md-4">
      <h3>Other announcements</h3>
      <ul class="list-group list-group-flush">
        <?php foreach($announcements as $announce):?>
          <a href="<?= base_url()?>/announcements/<?= esc($announce['link'])?>" class="list-group-item list-group-item-action" style="background-color: transparent;"><?= esc($announce['title'])?></a>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
</div>
<ul class="list-group">
</ul>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>
    