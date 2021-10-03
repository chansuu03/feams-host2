<?= $this->extend('temp') ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url();?>/public/css/login.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="<?= base_url();?>/login" method="post">
                        <img src= "<?= esc(base_url());?>/public/img/fealogo.png" alt="logo" style="height: 65px; margin-bottom: 50px; margin-left: 78px;">
                        <h6 class="text-center" style="padding-bottom: 20px; color: black; opacity: 0.5;">Welcome to FEA Management System</h6>
                            <div class="form-group">
                                <!-- <i class="fas fa-user" style="color: #616161;"></i>  --><label style="color: #616161;"></label><br>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group">
                                <!-- <i class="fas fa-lock" style="color: #616161;"></i>  --><label style="color: #616161;"></label><br>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                            </div>

                            <input type="submit" name="submit" class="btn btn-info btn-md login-btn" value="Submit">
                            <!--<div class="form-group" style="padding-top: 50px; font-size: 12px;">
                                <a href="#" class="text-info">Forgot Password?</a>
                                <!-- <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
                            <!-- </div> -->
                            <!-- <div id="register-link" class="text-right" style="padding-top: 47px; font-size: 12px;"> -->
                                <!-- <label for="remember-me" class="text-info remember-me"><span>Remember me</span>  <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
                                <!-- <input class="checkbox" type="checkbox" value="lsRememberMe" id="rememberMe"> <label for="rememberMe">Remember me</label> -->
                                
                            <!-- </div> -->
                    </form>
                    <div id="register-links" class="text-center" style="padding-top: 35px; font-size: 12px; <?php if(!empty(session()->getFlashdata('failMsg')) || !empty(session()->getFlashdata('successMsg'))) echo 'margin-top: -60px;'?>">
                        <label>Don't have an account?</label> <a href="<?= base_url('register');?>" class="text-info">Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notPaidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>You are not currently paid, please upload your proof of payment here if you are done paying.</p>
        <form action="<?= base_url('register/verify')?>" method="post" enctype="multipart/form-data">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="proof" name="proof" required>
            <label class="custom-file-label" for="customFile">Upload your proof here</label>
          </div>
          <input type="hidden" name="user_id" value="<?= session()->getFlashdata('user_id')?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>

<?php if(!empty(session()->getFlashdata('notPaid'))):?>
  <script type="text/javascript">
    $(window).on('load',function(){
        $('#notPaidModal').modal({
          show: true,
          focus: true,
        });
    });

    $('#notPaidModal').on('hidden.bs.modal', function (e) {
      window.location = '<?= base_url()?>/logout';
    })
  </script>
<?php endif;?>

<?php if(!empty(session()->getFlashdata('successMsg'))):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'success',
				title: 'Success!',
				text: '<?= session()->getFlashdata('successMsg');?>',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Okay'
			})/*swal2*/.then((result) =>
			{
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed)
				{
					Swal.close()
				}
			})//then
		};
	</script>
<?php elseif(!empty(session()->getFlashdata('failMsg'))):?>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'error',
				title: 'Error!',
				text: '<?= session()->getFlashdata('failMsg');?>',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Okay'
			})/*swal2*/.then((result) =>
			{
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed)
				{
					Swal.close()
				}
			})//then
		};
	</script>
<?php endif;?>


<script>
  function resetStyle() {
      document.getElementById("register-links").style.marginTop = "1px";
  }

  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var name = document.getElementById("proof").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = name
  })
</script>

<?= $this->endSection() ?>