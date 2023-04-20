<?php 
session_start();
include_once('config/db.connection.php');
?>
<?php include_once('includes/header.php'); ?>
	
	<div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="register-content m-t-200">
        <?php include_once('includes/alert.message.php'); ?>
        <div class="card">
          <div class=" container" style="width: 100%!important;">
         	<p class="form-control" style="background: #F0FBFA;">
            ALL USERS ACCOUNT
          </p><hr/>
          <div id="account_table">
	          <table class="table table-hover table-striped table-bordered"> 
	            <thead>
	              <tr style="background: #DCDCDC;" >
	                                        <th scope="col">No.</th>
	                                        <th scope="col">Account name</th>
	                                        <th scope="col">Access Level</th>
	                                        <th scope="col">Username</th>
	                                        <th scope="col">Password</th>
	                                        <th scope="col" class="text-center">Action</th>
	                                    </tr>
	                                </thead>

	                                <tbody>
	                                    <!--FETCH ALL DATA FROM DATABASE-->
	                                    <?php
														$query = "SELECT * FROM accounts ORDER BY account_id DESC";
	                                       $result = mysqli_query($connection, $query);
	                                       if(!$result) { die('Query error: ' . mysqli_error($connection)); }   
	                                       //check data in row if exist or not
	                                       if(mysqli_num_rows($result) > 0) {
	                                          //fetch all data found
	                                          while($data = mysqli_fetch_assoc($result)) { 
	                                             ?>
	                                                <tr>
		                                                <td id="<?= $data['account_id']; ?>"><?= $data['account_id']; ?></td>
		                                                <td><?= $data['name']; ?></td>
		                                                <td><?= $data['access_level']; ?></td>
		                                                <td><?= $data['username']; ?></td>
		                                                <td><?= $data['password']; ?></td>
		                                                <td>
		                                                    <form action="actions/decline.account.php" method="POST">
		                                                        <button type="submit" class="btn-success btn btn-sm">
		                                                        Approve
		                                                        </button>

		                                                        <input type="hidden" name="decline_id" id="decline_id"
		                                                        value="<?= $data['account_id']; ?>" />

		                                                        <button type="submit" name="decline_account" class="decline btn-danger btn btn-sm">
		                                                        	Decline
		                                                        </button>
		                                                    </form>
		                                                </td> 
	                                            		</tr>
	                                          	<?php
	                                          }
	                                      	} else {
	                                          ?>
	                                          <tr><td colspan="6">No Record Found</td></tr>
	                                          <?php
	                                      	}
	                                    ?>
	                                </tbody>

	                                <tfoot>
	                                	<tr>
	                                		<th colspan="6" class="text-center">
	                                			<u><a href="exam.registration.php">Go to register account</a></u>
	                                		</th>
	                                	</tr>
	                                </tfoot>
	                            </table>
                            </div>
                            
                		</div>
                	</div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
		   $(document).on('click', '.decline', function(){ //check if button is click
		   	//if click pop up dialog box
		      if(confirm("Are you sure you want to decline this account?")) {
		      	//if user click ok, execute this block of code
		      	$tr = $(this).closest('tr');
		      	var data = $tr.children("td").map(function() {
						return $(this).text();
						// console.log(data);
						$('#decline_id').val(data[0]);

					}).get(); //get account id
					
		      } else {
		        return false; //no action will be perform
		      }
		   });
        </script>
	 



<?php include_once('includes/footer.php'); ?>