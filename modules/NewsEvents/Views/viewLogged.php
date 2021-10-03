<!-- for logged in members -->

<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>/news">News</a></li>
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

<div class="container ml-3">
  <div class="row">
    <div class="col-md-7 ml-5">
      <div class="row justify-content-center">
        <img src="<?= base_url()?>/public/uploads/news/<?= esc($news['image'])?>" class="rounded img-fluid" alt="News image">
      </div>
      <div class="row justify-content-center mt-2">
        <div class="col">
          <?= esc($news['content'], 'raw')?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <h5 class="text-center">Other news</h5>
      <ul class="list-group list-group-flush">
        <?php foreach($otherNews as $others):?>
          <a href="<?= base_url();?>/news/<?= $others['id']?>" class="list-group-item list-group-item-action <?= $news['id'] == $others['id'] ? 'active' : ''?>"><?= $others['title']?></a>
        <?php endforeach?>
      </ul>
    </div>
  </div>
</div>
<!-- <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-9">
            <img src="<?= base_url()?>/public/uploads/news/<?= esc($news['image'])?>" class="rounded img-fluid" alt="News image">
        </div>
      </div>
      <br>
      <div class="row justify-content-center">
        <div class="col-md-6 text-left">
            <?= esc($news['content'], 'raw')?>
        </div>
      </div>
</div> -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>