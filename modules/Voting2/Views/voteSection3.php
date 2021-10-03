<html>
  <head>    
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url()?>/public/dist/select2/css/select2-bootstrap4.min.css">
  </head>
  <body>
    <form action="<?= base_url('votes/cast')?>" method="post" id="voting">
        <input type="hidden" value="<?= esc($election['id'])?>" name="election_id">
        <button class="btn btn-primary btn-sm justify-content-end cast">Cast Vote</button>
    </form>

    <!-- Select2 -->
    <script src="<?= base_url();?>/public/dist/select2/js/select2.min.js"></script>

    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
          theme: 'bootstrap4',
        })
      })
    </script>
    <!-- SweetAlert JS -->
    <script src="<?= base_url();?>/public/js/sweetalert.min.js"></script>
    <script src="<?= base_url();?>/public/js/sweetalert2.all.min.js"></script>
    <!-- SweetAlert2 -->
    <script type="text/javascript">

      $(document).ready(function ()
      {    
        $(function () {
          //Initialize Select2 Elements
          $('.select2').select2({
            theme: 'bootstrap4',
          })
        })
        
        $('.cast').click(function (e)
        {
          e.preventDefault();
          // console.log(id);

          Swal.fire({
            icon: 'question',
            text: 'Vote cannot be changed after its casted. Are you sure?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          })/*swal2*/.then((result) =>
          {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed)
            {
              document.getElementById("voting").submit();
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