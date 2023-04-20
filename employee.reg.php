<?php
session_start();
include_once('config/db.connection.php');

if(isset($_POST['saveBtn'])) {
	//retrieve data
	$id = mysqli_real_escape_string($connection, $_POST['employee_no']);
	$name = mysqli_real_escape_string($connection, $_POST['employeeName']);
	$address = mysqli_real_escape_string($connection, $_POST['address']);
	$contactNo = mysqli_real_escape_string($connection, $_POST['contactNo']);
	$birthday = mysqli_real_escape_string($connection, $_POST['birthday']);
	$gender = mysqli_real_escape_string($connection, $_POST['gender']);
	$status = mysqli_real_escape_string($connection, $_POST['status']);

	try {
		#=======UPDATE EMPLOYEE RECORD===========
		if(isset($_GET['get_employee_id'])) {
			$updateQuery = "UPDATE tbl_employees SET employee_name = ?, address = ?, contact_no = ?, birthday = ?, gender = ?, status = ? WHERE employee_no = ?";
			$stmt = mysqli_prepare($connection, $updateQuery);
			mysqli_stmt_bind_param($stmt, "ssssssi", $name, $address, $contactNo, $birthday, $gender, $status, $_GET['get_employee_id']);
			mysqli_stmt_execute($stmt);
			//display success message
			$_SESSION['message'] = "Employee record updated successfully!";
			header('location: employee.php'); //redirect to employee data table
			exit();
		} 
		#=======ADD NEW EMPLOYEE RECORD===========
		else {
			$insertQuery = "INSERT INTO tbl_employees (employee_no, employee_name, address, contact_no, birthday, gender, status) 
			VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = mysqli_prepare($connection, $insertQuery);
			mysqli_stmt_bind_param($stmt, "issssss", $id, $name, $address, $contactNo, $birthday, $gender, $status);
			mysqli_stmt_execute($stmt);
			//display success message
			$_SESSION['message'] = "New employee record added successfully!";
			header('location: employee.php'); //redirect to the same page
			exit();
		}		
	} catch (Exception $e) {
		echo "An error occured: " . $e->getMessage();
	}
}
?>
	
<?php include_once('includes/header.php'); ?>

	<section id="main-content">
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-5 "><br/><br/><br/><br/>
					<!-- success alert -->
					<?php include_once('includes/alert.message.php'); ?>
					<div class="card mt-20">
						<div class="card-title pt-2">
							<p class="title form-control" id="title">#REGISTER NEW EMPLOYEE</p><hr/>
						</div>
						<div class="card-body">
							<form method="POST" action="">
								<div class="form-group">
									<?php
									$countEmployee = 1; //default id/no is 1
									$query = "SELECT employee_name FROM tbl_employees ORDER BY employee_no ASC";
                  $stmt = mysqli_prepare($connection, $query);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  while($row = mysqli_fetch_assoc($result)) {
                  	if($countEmployee != 0) { //true
                  		$countEmployee  += 1; //increment
                  	}
                  }
									?>
									<!-- employee no --> 
									<label for="employee-no">Employee no:</label>
									<input type="number" name="employee_no" id="employeeNo"  value="<?=$countEmployee?>" class="form-control" readonly/>
									
									<!-- employee name -->
									<label for="employee-name">Employee Name:</label>
									<input type="text" class="form-control mb-2" name="employeeName" id="employeeName"
									placeholder="Enter employee name" required />
									<!-- address -->
									<label for="address">Address:</label>
									<input type="text" class="form-control mb-2" name="address" id="address" 
									placeholder="Enter address" required />

									<!-- contact no. -->
									<label for="contact-number">Contact Number:</label>
									<input type="text" class="form-control mb-3" name="contactNo" id="contactNo" 
										placeholder="Enter contact number" required />

									<!-- birthday -->
									<label for="birthday">Birthday:</label>
									<input type="date" class="form-control mb-3" name="birthday" id="birthday" 
										placeholder="Enter your birthday" required />

									<!-- gender -->
									<label for="gender">Gender:</label>
									<label onclick="male()">
										<input type="radio" id="male"  /> Male
									</label>
									<label onclick="female()">
										<input type="radio" id="female"  /> 
										 Female
									</label><br/>
									<input type="hidden" name="gender" id="gender"/>

									<!-- civil status -->
									<label for="status">Civil Status:</label>
									<input type="text" name="status" id="status" placeholder="--SELECT STATUS--" class="form-control"
									list="status"/>
									<datalist id="status">
										<option value="Single">Single</option>
										<option value="Married">Married</option>
										<option value="Widowed">Widowed</option>
										<option value="Seperated">Seperated</option>
									</datalist>
									<br/>

									<!-- action button -->						
									<button type="submit" id="firstBtn" class="btn btn-success form-control mb-3" name="saveBtn">Save Employee</button> 
									<button type="button" id="secondbtn" onclick="window.location.href='employee.php'" 
									class="btn btn-primary form-control border-0">
										Go to employee table list
									</button><br/><br/>
								</div><!--end form group-->
							</form>
							<?php
							#FETCH DATA OF EMPLOYEE WHEN BTN GET DATA IS SET
							if(isset($_GET['get_employee_id']) && !empty($_GET['get_employee_id'])) {
								$fetchQuery = "SELECT * FROM tbl_employees WHERE employee_no = ?";
								$stmt = mysqli_prepare($connection, $fetchQuery);
								mysqli_stmt_bind_param($stmt, "i", $_GET['get_employee_id']);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								$row = mysqli_fetch_assoc($result);
							}
								?>
									<script>
										//display data
										var gender = "<?=$row['gender']?>";
										document.getElementById('employeeNo').value = "<?=$row['employee_no']?>";
										document.getElementById('employeeName').value = "<?=$row['employee_name']?>";
										document.getElementById('address').value = "<?=$row['address']?>";
										document.getElementById('contactNo').value = "<?=$row['contact_no']?>";
										document.getElementById('birthday').value = "<?=$row['birthday']?>";
										if(gender === 'Male') {
											document.getElementById('male').checked = true;
										} else {
											document.getElementById('female').checked = true;
										}
										document.getElementById('status').value = "<?=$row['status']?>";
										
										//restyle element
										document.getElementById('title').innerHTML = "#UPDATE EMPLOYEE";
										document.getElementById('firstBtn').innerHTML = "Update";
										document.getElementById('secondbtn').innerHTML = "Cancel";
									</script>
								<?php
							?>
						</div><!--card body-->
					</div><!--card-->
				</div><!--column-->
			</div><!--row-->
		</div><!--container-->
	</section><!--end content-->
	<script>
		function male() {
			document.getElementById("female").checked = false;
    	document.getElementById("gender").value = "Male";
		}
		function female(){
	    document.getElementById("male").checked = false;
	    document.getElementById("gender").value = "Female";
  	}	
	</script>

<?php include_once('includes/footer.php'); ?>