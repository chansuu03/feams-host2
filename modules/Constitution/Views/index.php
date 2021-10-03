<?= $this->extend('adminlte') ?>

<?= $this->section('page_header') ?>
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
<?php $ctr = 1;?>
<div class="card">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <?php foreach($consti as $const):?>
        <li class="nav-item">
          <a class="nav-link <?= $ctr == 1 ? 'active' : ''?>" href="#tab<?= $ctr?>" data-toggle="tab"><?= esc($const['area'])?></a>
        </li>
        <?php $ctr++;?>
      <?php endforeach;?>
    </ul>
  </div>
  <div class="card-body">
    <?php $ctr = 1;?>
    <div class="tab-content p-0">
      <?php foreach($consti as $const):?>
        <div class="tab-pane fade <?= $ctr == 1 ? 'show active' : ''?>" id="tab<?= $ctr?>">
          <?= esc($const['content'], 'raw')?>
          <?php if(session()->get('role') == '1'):?>
            <a class="btn btn-primary btn-sm mt-2" href="<?= base_url('constitution/edit')?>/<?= esc($const['id'], 'raw')?>" role="button">Edit <?= esc($const['area'], 'raw')?></a>
            <a class="btn btn-danger btn-sm mt-2" href="<?= base_url('constitution/delete')?>/<?= esc($const['id'], 'raw')?>" role="button">Delete <?= esc($const['area'], 'raw')?></a>
          <?php endif;?>
        </div>
        <?php $ctr++;?>
      <?php endforeach;?>
    </div>
  </div>
  <div class="card-footer">
    <?php if(session()->get('role') == '1'):?>
      <a class="btn btn-primary btn-sm" href="<?= base_url('constitution/add')?>" role="button">Link</a>
    <?php endif;?>
      <a class="btn btn-primary btn-sm" href="<?= base_url('constitution/print')?>" role="button">Generate PDF</a>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>
    