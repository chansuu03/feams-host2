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

<div class="container">
	<div class="row">
    <!-- News Start here -->
    <div class="col-md-8">
      <h3>Latest News</h3>
      <h5><?= esc($firstNews['title'])?></h5>
      <?= esc($firstNews['content'], 'raw')?>
    </div>
    <div class="col-md-4">
      <h3>More news</h3>
      <ul class="list-group list-group-flush">
        <?php foreach($news as $news):?>
          <a href="<?= base_url()?>/news/<?= esc($news['id'])?>" class="list-group-item list-group-item-action" style="background-color: transparent;"><?= esc($news['title'])?></a>
        <?php endforeach?>
      </ul>
    </div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>
    