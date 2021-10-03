function alert_error(message){  
	 Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: message,
		  footer: '<a href>Why do I have this issue?</a>'
		}); 
} 

function alert_success(message){  
	 Swal.fire(
	  'Good job!',
	  message,
	  'success'
	);
} 

function alert_login_success(message){  
	 Swal.fire(
	  'Login Success!',
	  message,
	  'success'
	);
} 

function confirmDelete(url, id)
{
	Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!',
		  closeOnConfirm: false,
          closeOnCancel: false
		}).then((result) => {
		  if (result.value) {
		  	$.ajax({
	             url: url + id,
	             type: 'DELETE',
	             error: function() {
	               Swal.fire({
					  icon: 'error',
					  title: 'Oops...',
					  text: 'Something went wrong!',
					  footer: '<a href>Why do I have this issue?</a>'
					}); 
	             },
	             success: function(data) {
	             	   Swal.fire(
						  'Deleted!',
					      'Your file has been deleted.',
					      'success'
						).then((resultAgain)=>{
							if (resultAgain.value)
							{
	                  			$("#"+id).remove();
	                  			location.reload(fast);
							}
						});
	             }
	          });
		  }
	})
} 