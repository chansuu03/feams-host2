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
                        <?php if(!empty(session()->getFlashdata('failMsg'))):?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('failMsg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php elseif(!empty(session()->getFlashdata('successMsg'))):?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('successMsg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php elseif(!empty(session()->get('failMsg'))):?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->get('failMsg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php elseif(!empty(session()->get('successMsg'))):?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->get('successMsg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif;?>
                            <div class="form-group">
                                <!-- <i class="fas fa-user" style="color: #616161;"></i>  --><label style="color: #616161;"></label><br>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group">
                                <!-- <i class="fas fa-lock" style="color: #616161;"></i>  --><label style="color: #616161;"></label><br>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                            </div>

                            <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- SweetAlert JS -->
<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>

<?php if(!empty(session()->getFlashdata('sweetalertfail'))):?>
	<!-- SweetAlert JS -->
	<script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
	<script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
	<script>
		window.onload = function() {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'There\'s an error accessing the page, please try again',
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
        console.log('bobo');
        document.getElementById("register-links").style.marginTop = "1px";
    }
</script>

<?= $this->endSection() ?>