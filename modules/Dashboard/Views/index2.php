<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?= esc($title)?></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div><!-- /.col -->
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
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Users</span>
        <span class="info-box-number">
					<?= esc($userCount)?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-danger elevation-1"><i class="ion ion-document"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Files</span>
        <span class="info-box-number">
					<?= esc($fileCount)?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-success elevation-1"><i class="ion ion-document"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Active Elections</span>
        <span class="info-box-number">
					<?= esc($activeElections['count'])?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-comments"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Discussions</span>
        <span class="info-box-number">
					<?= esc($discussions)?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>

<div class="card">
	<div class="card-header">
		<h5 class="card-title">Elections Report</h5>
		<div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
	</div>
	<div class="card-body">
		<div class="row">
            <div class="col-md-2">
                <p class="text-center"><strong>List of active elections</strong></p>
                <ol>
                    <?php foreach($activeElections['list'] as $elections):?>
                        <li><?= esc($elections['title'])?></li>
                    <?php endforeach;?>
                </ol>
            </div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h5 class="card-title">Files Report</h5>
		<div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
	</div>
	<div class="card-body">
		<div class="row">
      <div class="col-md-6">
        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
		</div>
	</div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-text-width"></i>
          Unstyled List
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <ul class="list-unstyled">
          <li>Lorem ipsum dolor sit amet</li>
          <li>Consectetur adipiscing elit</li>
          <li>Integer molestie lorem at massa</li>
          <li>Facilisis in pretium nisl aliquet</li>
          <li>Nulla volutpat aliquam velit
            <ul>
              <li>Phasellus iaculis neque</li>
              <li>Purus sodales ultricies</li>
              <li>Vestibulum laoreet porttitor sem</li>
              <li>Ac tristique libero volutpat at</li>
            </ul>
          </li>
          <li>Faucibus porta lacus fringilla vel</li>
          <li>Aenean sit amet erat nunc</li>
          <li>Eget porttitor lorem</li>
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<?= $this->endSection();?>

<?= $this->section('scripts') ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url();?>/dist/adminlte/plugins/chart.js/Chart.min.js"></script>
  <script>
      var serries = JSON.parse(`<?php echo $fileCategories; ?>`);
      console.log(serries);
      var data = serries,
          config = {
          data: data,
          xkey: 'name',
          ykeys: ['count'],
          labels: ['Files uploaded'],
          fillOpacity: 0.6,
          hideHover: 'auto',
          behaveLikeLine: true,
          resize: true,
          horizontal: true,
          pointFillColors:['#ffffff'],
          pointStrokeColors: ['black'],
          lineColors:['gray','red']
      };
      
      //for mories bar chart
      config.element = 'bar-chart';
      Morris.Bar(config);
      
      //for stacked bar chart
      config.element = 'stacked';
      config.stacked = true;
      Morris.Bar(config);
  </script>
  
  <script>
    var cat2 = JSON.parse(`<?php echo $fileCategories3; ?>`);  
    console.log(cat2);      
    var browsersChart = Morris.Donut({
      element: 'donut-chart',
      data: cat2,
      colors: ['#863dc5', '#e17dd8', '#330b6a', '#856c7d', '#856c7d', '#7c1c73', '#3c2451'],
      resize: true,
    });

    browsersChart.options.data.forEach(function(label, i) {
      var legendItem = $('<span></span>').text( label['label'] + " ( " +label['value'] + " )" ).prepend('<br><span>&nbsp;</span>');
      legendItem.find('span')
        .css('backgroundColor', browsersChart.options.colors[i])
        .css('width', '20px')
        .css('display', 'inline-block')
        .css('margin', '5px');
      $('#legend').append(legendItem)
    });
  </script>

  <!-- chartJS sample donut -->
  <script>
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Documents', 
          'Media',
          'Images', 
          'Others',
      ],
      datasets: [
        {
          data: [700,500,400,600],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
        }
      ]
    }
  </script>
<?= $this->endSection() ?>
