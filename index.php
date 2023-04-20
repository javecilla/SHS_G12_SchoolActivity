<?php include('includes/header.php'); ?>

<section>
	
	<div class="card">
		<div class="row">

			<!-- <button class="btn btn-primary clickme">test</button> -->
			<button onclick="sweetAlert()">Try me!</button>
		</div>	
	</div>
		
</section>

<script>
	function sweetAlert(){
  (async () => {

  const { value: formValues } = await Swal.fire({
    title: 'Multiple inputs',
    html:
      '<input type="text" id="swal-input1" class="swal2-input">' +
      '<input type="password" id="swal-input2" class="swal2-input">',
    focusConfirm: false,
    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value
      ]
    }
  })

  if (formValues) {
    Swal.fire(JSON.stringify(formValues))
  }

  })()
}
	// $(document).ready(function() {
	// 	$('.clickme').on("click", function() {
	// 		swal(
	//     {
	//       title: "Sweet ajax request !!",
	//       text: "Submit to run ajax request !!",
	//       type: "info",
	//       showCancelButton: true,
	//       closeOnConfirm: false,
	//       showLoaderOnConfirm: true,
	//     },
	//     function () {
	//       setTimeout(function () {
	//         swal("Hey, your ajax request finished !!");
	//       }, 3000);
	//     }
	//   );
	// 	});
	// });


</script>


<?php include('includes/footer.php'); ?>