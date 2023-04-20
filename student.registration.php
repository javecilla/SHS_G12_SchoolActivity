<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
	</head>

	<body>
		<?php
			//Load database credentials from a dbConfiguration folder->db_learners.config file
			$config = parse_ini_file('dbConfiguration/db_learners.config.ini');

			//Create a new mysqli object and connect to the database
			$dbconnection = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

			//Check for connection errors
			if ($dbconnection->connect_error) 
			{
			    die("Connection failed: " . $dbconnection->connect_error);
			}

			//Insert student data into database
			if (isset($_POST['register'])) 
			{		   
			   //Check if maximum slots for the specified year level, strand, and section have been reached
			   $statement = $dbconnection->prepare("SELECT COUNT(*) AS count FROM tbl_learners WHERE year_level = ? AND strand = ? AND section = ?");
			   $statement->bind_param("sss", $_POST['yearLevel'], $_POST['trackStrand'], $_POST['section']);
			   $statement->execute();
				$result = $statement->get_result();
				$row = $result->fetch_assoc();

			   $count = $row['count'];
			   //check if data in db from the specified year level, strand, and section have been reached 5 maximum slots
			   if ($count >= 5) 
			   {
			   	#if so, display error message and redirect to previous page
			      echo '<script>
			         alert("Failed to register, no slots available!");
			         window.location.href = "'.$_SERVER['HTTP_REFERER'].'";
			      </script>';
			      exit();
			  	} 
			  	else //if so, data inputed by user from the specified yearlevel, strand, and section have been not reached 5 maximum slots
			  	{
			  		#exucute this statement

				  	//Prepare a statement to insert the data
				   $statement = $dbconnection->prepare("INSERT INTO tbl_learners(lrn, last_name, first_name, middle_name, year_level, strand, section) 
				      VALUES (?, ?, ?, ?, ?, ?, ?)");
				   //Bind parameters to the statement
				   $statement->bind_param("sssssss", $_POST['lrn'], $_POST['lastName'], $_POST['firstName'], $_POST['middleName'], $_POST['yearLevel'], $_POST['trackStrand'], $_POST['section']);
				   //Execute the statement
				   $statement->execute();
				   //Check for errors from execution of statement
				   if ($statement->error) 
				   {
				      echo "Error: " . $statement->error;
				      exit();
				   }
				   else //if so, statement successfully executed
				   {
				   	#Display success message and redirect to previous page
				   	echo '<script>
			         alert("Registered Successfully!");
			         window.location.href = "'.$_SERVER['HTTP_REFERER'].'";
			      </script>';
			      exit();
				   }
			  	}
			}
			// Close the database connection
			$dbconnection->close();
		?>

		<div class="container">
			<form action="student.registration.php" method="POST" autocomplete="off" class="registration-form">
				<label>Student Registration System</label>

				<div class="input-form-control">
					<input type="number" placeholder="LRN" class="input-lrn" name="lrn" required /><br/>

					<small>Learner's Name</small><br/>
					<input type="text" placeholder="Last Name" class="input-last-name" name="lastName" required />
					<input type="text" placeholder="First Name" class="input-first-name" name="firstName" required />
					<input type="text" placeholder="Middle Name" class="input-middle-name" name="middleName" required />
				</div>

				<div class="selection-form-control">
					<div class="year-level-container">
						<input list="year-level" name="yearLevel" placeholder="Year/Level" required />
						<datalist id="year-level">
							<option value="Grade 11">Grade 11</option>
							<option value="Grade 12">Grade 12</option>
						</datalist>
					</div>

					<div class="track-strand-container">
						<input list="track-strand" name="trackStrand" placeholder="Track/Strand" required />
						<datalist id="track-strand">
							<option value="ABM">ABM</option>
							<option value="GAS">GAS</option>
							<option value="HUMSS">HUMSS</option>
							<option value="STEM">STEM</option>
							<option value="TVL-HE">TVL-HE</option>
							<option value="TVL-ICT">TVL-ICT</option>
						</datalist>
					</div>

					<div class="section-container">
						<input list="section" name="section" placeholder="Section" required />
						<datalist id="section">
							<option value="A">A</option>
							<option value="B">B</option>
						</datalist>
					</div>

					<button type="submit" name="register">Register</button>

				</div><!--form-control-->

			</form>
		</div><!--container-->
	</body>
</html>