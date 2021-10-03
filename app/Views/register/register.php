<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url()?>/public/css/register.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/adminlte/plugins/daterangepicker/daterangepicker.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">

    <title>Register - Faculty and Employees Association</title>
  </head>
  <body>
    <?php $attributes = ['id' => 'regis'];?>
    <?= form_open_multipart('register', $attributes);?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <div class="card reg">
                    <div class="card-header">
                        <h3>Registration</h3>
                    </div>
                    <div class="card-body">
                        <?= view('register/personal_info2')?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex flex-row-reverse">
                            <!-- <input class="btn btn-primary" type="submit" value="Register"> -->
                            <button class="btn btn-primary" id="regi">Register</button>
                        </div>
                    </div>
                </div> <!--card-->
            </div> <!--d-flex-->
        </div> <!--col-md-12-->
      </div> <!--row-->
    </div> <!--container-->
    <?= form_close();?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url()?>/public/dist/adminlte/plugins/jquery/jquery.js"></script>
    <script src="<?= base_url()?>/public/dist/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url()?>/public/dist/bootstrap/js/bootstrap.min.js"></script>    
    <!-- InputMask -->
    <script src="<?= base_url()?>/public/dist/adminlte/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url()?>/public/dist/adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= base_url()?>/public/dist/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Select 2 -->
    <script src="<?= base_url();?>/public/dist/select2/js/select2.min.js"></script>
    <!-- Page scripts -->
    <script>
        $(function() {
          $('input[name="birthdate"]').daterangepicker({
              "locale": {
                  "format": "MMM DD,YYYY",
                  cancelLabel: 'Clear'
              },
              startDate: '01/01/2010',
              singleDatePicker: true,
              showDropdowns: true,
              minYear: 1960,
              // autoUpdateInput: false,
              maxYear: parseInt(moment().format('YYYY'),10)
          }, function(start, end, label) {
          });
          //Initialize Select2 Elements
          $('.select2').select2({
            theme: 'bootstrap4',
          })
          $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    
    <!-- file uploads para mapalitan agad file name once makaselect na ng file -->
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function (e)
        {
        var name = document.getElementById("image").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = name
        })
    </script>
    
    <!-- SweetAlert JS -->
    <script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
    <script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
    <!-- SweetAlert2 -->
    <script type="text/javascript">

    $(document).ready(function ()
    {
        $('#regi').click(function (e)
        {
        e.preventDefault();
        // console.log(id);

        Swal.fire({
            icon: 'question',
            text: 'An email instruction will be sent to you after you submit your information. Continue?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        })/*swal2*/.then((result) =>
        {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed)
            {
                document.getElementById("regis").submit();
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
  </body>
</html>