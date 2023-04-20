<?php 
session_start();
include_once('config/db.connection.php');

try {
	#=======DELETE EMPLOYEE RECORD===========
	if(isset($_GET['del_employee_id'])) {
		$deleteQuery = "DELETE FROM tbl_employees WHERE employee_no = ?";
		$stmt = mysqli_prepare($connection, $deleteQuery);
		mysqli_stmt_bind_param($stmt, "i", $_GET['del_employee_id']);
		if(mysqli_stmt_execute($stmt)) {
			$_SESSION['message'] = "Employee deleted successfully!";
		} else {
			throw new Exception("Failed to execute delete statement:" . mysqli_stmt_error($stmt));
		}
	}
} catch (Exception $e) {
	echo "An error occured: " . $e->getMessage();
}
?>

<?php include_once('includes/header.php'); ?>

	<section id="main-content">
		<div class="container">
			<div class="row">
				<div class="col-15"><br/><br/><br/><br/>
					<!-- success alert -->
					<?php include_once('includes/alert.message.php'); ?>
					<div class="card">
						<form method="POST">
							<div class="row">
								<div class="col-9">
									<input type="search" name="search" placeholder="Search..." class="form-control" />
								</div>
								<div class="col-3">
									<button type="submit" class="btn btn-secondary form-control">Search</button>
								</div>
							</div>
						</form><br/>
						<div class="card-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Employee Name</th>
										<th>Address</th>
										<th>Contact No.</th>
										<th>Birthday</th>
										<th>Gender</th>
										<th>Civil Status</th>
										<th class="text-center" colspan="2">
											<button type="button" onclick="window.location.href='employee.reg.php'" 
											class="btn btn-success btn-sm form-control border-0">
												Add new
											</button>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									#DISPLAY DATA IN TABLE
									if(isset($_POST['search'])) {
										$values = $_POST['search'];
										$query = "SELECT * FROM tbl_employees 
											WHERE employee_name LIKE '%$values%' 
											OR address LIKE '%$values%' 
											OR contact_no LIKE '%$values%'";
										$stmt = mysqli_prepare($connection, $query);
										mysqli_stmt_execute($stmt);
										$result = mysqli_stmt_get_result($stmt);
										//check data from result
										if(mysqli_num_rows($result) > 0) {
											while($data = mysqli_fetch_array($result)) {
												?>
												<tr>
													<td><?=$data['employee_no']?></td>
													<td><?=$data['employee_name']?></td>
													<td><?=$data['address']?></td>
													<td><?=$data['contact_no']?></td>
													<td><?=$data['birthday']?></td>
													<td><?=$data['gender']?></td>
													<td><?=$data['status']?></td>
													<td>
														<a href="employee.reg.php?get_employee_id=<?=$data['employee_no']?>" class="btn btn-warning btn-sm">
															Edit
														</a>
													</td>
													<td>
														<a href="employee.php?del_employee_id=<?=$data['employee_no']?>" class="btn btn-danger btn-sm">
															Delete
														</a>
													</td>
												</tr>
												<?php
											}
										} else {
											echo "No data found!";
										}
									} else {
										$fetchQuery = "SELECT * FROM tbl_employees";
										$stmt = mysqli_prepare($connection, $fetchQuery);
										mysqli_stmt_execute($stmt);
										$result = mysqli_stmt_get_result($stmt);
										//check data from result
										if(mysqli_num_rows($result) > 0) {
											while($data = mysqli_fetch_array($result)) { //fetch all data found
												?>
												<tr>
													<td><?=$data['employee_no']?></td>
													<td><?=$data['employee_name']?></td>
													<td><?=$data['address']?></td>
													<td><?=$data['contact_no']?></td>
													<td><?=$data['birthday']?></td>
													<td><?=$data['gender']?></td>
													<td><?=$data['status']?></td>
													<td>
														<a href="employee.reg.php?get_employee_id=<?=$data['employee_no']?>" class="btn btn-warning btn-sm">
															Edit
														</a>
													</td>
													<td>
														<a href="employee.php?del_employee_id=<?=$data['employee_no']?>" class="btn btn-danger btn-sm">
															Delete
														</a>
													</td>
												</tr>
												<?php
											}
										} else {
											echo "No data found!";
										}
									}
									?>	
								</tbody>
							</table>
						</div><!--card body-->
					</div><!--card-->
				</div><!--column-->
			</div><!--row-->
		</div><!--container-->
	</section>

<?php include_once('includes/footer.php'); ?>