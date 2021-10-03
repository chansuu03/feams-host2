<?= $this->extend('adminlte') ?>

<?= $this->section('styles') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('page_header');?>
<div class="row mb-2">
    <div class="col-sm-6">
            <h1><?= esc($title)?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/elections')?>">Elections</a></li>
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

<div class="card">
  <div class="card-header ">
    <strong>Election Title: </strong><?= esc($election['title'])?>
  </div>
  <div class="card-body">
    <div class="row d-flex justify-content-between ml-1">
      <span class="card-text">
        Vote dates: <?= esc(date('F d,Y g:iA',strtotime($election['vote_start'])))?> - <?= esc(date('F d,Y g:iA',strtotime($election['vote_end'])))?>
      </span>
      <span class="card-text">
        Vote count: <?= esc($voteCount)?>
      </span>
    </div>

    <div class="row mt-3">
      <?php $people = array();?>
      <!-- Full-time -->
      <div class="col-md-4">
        <h4 class="text-center">Top 4 Full-time</h4>
        <ul class="list-group">
          <?php $ctr = 0; foreach($votes as $vote):?>
            <?php if($vote['type'] == '1' && $ctr != 4):?>
              <li class="list-group-item d-flex justify-content-between">
                <span><?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?></span>
                <span><?= esc($vote['voteCount'])?></span>
                <?php array_push($people, array('user_id' => $vote['user_id'], 'first_name' => $vote['first_name'], 'last_name' => $vote['last_name'],))?> 
              </li>
              <?php $ctr++;?>
            <?php endif;?>
          <?php endforeach?>
        </ul>
      </div>
      <!-- Part-time -->
      <div class="col-md-4">
        <h4 class="text-center">Top 4 Part-time</h4>
        <ul class="list-group">
          <?php $ctr = 0; foreach($votes as $vote):?>
            <?php if($vote['type'] == '2' && $ctr != 4):?>
              <li class="list-group-item d-flex justify-content-between">
                <span><?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?></span>
                <span><?= esc($vote['voteCount'])?></span>
                <?php array_push($people, array('user_id' => $vote['user_id'], 'first_name' => $vote['first_name'], 'last_name' => $vote['last_name'],))?>
              </li>
              <?php $ctr++;?>
            <?php endif;?>
          <?php endforeach?>
        </ul>
      </div>
      <!-- Admin -->
      <div class="col-md-4">
        <h4 class="text-center">Top 4 Admin</h4>
        <ul class="list-group">
          <?php $ctr = 0; foreach($votes as $vote):?>
            <?php if($vote['type'] == '3' && $ctr != 4):?>
              <li class="list-group-item d-flex justify-content-between">
                <span><?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?></span>
                <span><?= esc($vote['voteCount'])?></span>
                <?php array_push($people, array('user_id' => $vote['user_id'], 'first_name' => $vote['first_name'], 'last_name' => $vote['last_name'],))?>
              </li>
              <?php $ctr++;?>
            <?php endif;?>
          <?php endforeach?>
        </ul>
      </div>
    </div>
    <?php if($election['status'] == 'Finished'):?>
      <?php if(!$hasOfficers):?>
        <div class="row mt-2 ml-1">
          <h4 class="card-text">Election ended, choose the position alloted for the top 12</h4>
        </div>
        <!-- Positions -->
        <div class="container mt-2 mb-2">
          <form action="<?= base_url()?>/admin/elections/<?= $election['id']?>/set" method="post" id="elect">
            <div class="form-row">
              <!-- President -->
              <div class="form-group col">
                <label for="inputEmail4">President</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['pres']) ? 'is-invalid': ''?>" style="width: 100%;" name="pres">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['pres'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['pres'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- VP Internal -->
              <div class="form-group col">
                <label for="inputEmail4">VP Internal</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['vpint']) ? 'is-invalid': ''?>" style="width: 100%;" name="vpint">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['vpint'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['vpint'])?>
                  </div>
                <?php endif;?>
              </div>
              <!-- VP External -->
              <div class="form-group col">
                <label for="inputEmail4">VP External</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['vpext']) ? 'is-invalid': ''?>" style="width: 100%;" name="vpext">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['vpext'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['vpext'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- Secretary -->
              <div class="form-group col">
                <label for="inputEmail4">Secretary</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['sect']) ? 'is-invalid': ''?>" style="width: 100%;" name="sect">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['sect'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['sect'])?>
                  </div>
                <?php endif;?>
              </div>
              <!-- Assistant Secretary -->
              <div class="form-group col">
                <label for="inputEmail4">Assistant Secretary</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['assect']) ? 'is-invalid': ''?>" style="width: 100%;" name="assect">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['assect'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['assect'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- Treasurer -->
              <div class="form-group col">
                <label for="inputEmail4">Treasurer</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['treas']) ? 'is-invalid': ''?>" style="width: 100%;" name="treas">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['treas'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['treas'])?>
                  </div>
                <?php endif;?>
              </div>
              <!-- Assistant Treasurer -->
              <div class="form-group col">
                <label for="inputEmail4">Assistant Treasurer</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['astreas']) ? 'is-invalid': ''?>" style="width: 100%;" name="astreas">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['astreas'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['astreas'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- Auditor -->
              <div class="form-group col">
                <label for="inputEmail4">Auditor</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['audit']) ? 'is-invalid': ''?>" style="width: 100%;" name="audit">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['audit'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['audit'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- Business Manager -->
              <div class="form-group col">
                <label for="inputEmail4">Business Manager</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['busMan1']) ? 'is-invalid': ''?>" style="width: 100%;" name="busMan1">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['busMan1'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['busMan1'])?>
                  </div>
                <?php endif;?>
              </div>
              <!-- Business Manager -->
              <div class="form-group col">
                <label for="inputEmail4">Business Manager</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['busMan2']) ? 'is-invalid': ''?>" style="width: 100%;" name="busMan2">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['busMan2'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['busMan2'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="form-row">
              <!-- Public Relation Officer -->
              <div class="form-group col">
                <label for="inputEmail4">Public Relation Officer</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['pro1']) ? 'is-invalid': ''?>" style="width: 100%;" name="pro1">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['pro1'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['pro1'])?>
                  </div>
                <?php endif;?>
              </div>
              <!-- Public Relation Officer -->
              <div class="form-group col">
                <label for="inputEmail4">Public Relation Officer</label>
                <select class="form-control select2bs4 <?=!empty(session()->getFlashdata('errors')['pro2']) ? 'is-invalid': ''?>" style="width: 100%;" name="pro2">
                  <option selected="selected" value="">Choose one...</option>
                  <?php foreach($people as $pers):?>
                    <option value="<?= $pers['user_id']?>"><?= $pers['first_name']?> <?= $pers['last_name']?></option>
                  <?php endforeach?>
                </select>
                <?php if(!empty(session()->getFlashdata('errors')['pro2'])):?>
                  <div class="invalid-feedback">
                      <?=esc(session()->getFlashdata('errors')['pro2'])?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <button type="button" class="btn btn-primary" id="electBtn">Elect</button>
          </form>
        </div>
      <?php else:?>
        <!-- Elected officers -->
        <div class="row mt-2 ml-1">
          <h4 class="card-text">Elected officers</h4>
        </div>
        <div class="card">
          <div class="card-body">
            <table class="table table-hover table-striped" id="elected">
              <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Position</th>
                  <th scope="col">Name</th>
                  </tr>
              </thead>
              <tbody>
                <?php $ctr=1; foreach($officers as $officer):?>
                  <tr>
                    <td><?= esc($ctr)?></td>
                    <td>
                      <?php switch(esc($officer['position'])) {
                        case 'pres':
                          echo 'President';
                          break;
                        case 'vpint':
                          echo 'VP Internal';
                          break;
                        case 'vpext':
                          echo 'VP External';
                          break;
                        case 'sect':
                          echo 'Secretary';
                          break;
                        case 'assect':
                          echo 'Assistant Secretary';
                          break;
                        case 'treas':
                          echo 'Treasurer';
                          break;
                        case 'astreas':
                          echo 'Assistant Treasurer';
                          break;
                        case 'audit':
                          echo 'Auditor';
                          break;
                        case 'busMan1':
                          echo 'Business Manager';
                          break;
                        case 'busMan2':
                          echo 'Business Manager';
                          break;
                        case 'pro1':
                          echo 'Public Relations Officer';
                          break;
                        case 'pro2':
                          echo 'Public Relations Officer';
                          break;
                      }?>
                    </td>
                    <td><?= esc($officer['first_name'])?> <?= esc($officer['last_name'])?></td>
                    <?php $ctr++;?>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif?>
    <?php endif?>
    <!-- No Votes -->
    <div class="row mt-2 ml-1">
      <h4 class="card-text">Users who haven't voted</h4>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-hover table-striped" id="noVotes">
          <thead>
              <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              </tr>
          </thead>
          <tbody>
            <?php $ctr=1; foreach($noVotes as $user):?>
              <tr>
                <td><?= esc($ctr)?></td>
                <td><?= esc($user['first_name'])?></td>
                <td><?= esc($user['last_name'])?></td>
                <?php $ctr++;?>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php if($election['status'] == 'Finished'):?>
    <div class="card-footer">
      <a class="btn btn-primary float-right" href="<?= base_url()?>/admin/elections/<?= esc($election['id'])?>/pdf" role="button" style="margin-right: 5px;">
        <i class="fas fa-download"></i> Generate PDF
      </a>
    </div>
  <?php endif;?>
</div>

<?= $this->endSection();?>

<?= $this->section('scripts') ?>

<!-- Select2 -->
<script src="<?= base_url()?>/public/dist/adminlte/plugins/select2/js/select2.full.min.js"></script>
<script>
// BS4 tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    })
  })
  
  // DataTables
  $(function () {
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [ 5,10, 25, 50, 75, 100 ],
      });
  });
</script>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript">

  $(document).ready(function ()
  {    
    $('#electBtn').click(function (e)
    {
      e.preventDefault();
      // console.log(id);
      Swal.fire({
        icon: 'question',
        text: 'Are you sure for the candidates to be elected?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      })/*swal2*/.then((result) =>
      {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed)
        {
          document.getElementById("elect").submit();
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
<?= $this->endSection();?>