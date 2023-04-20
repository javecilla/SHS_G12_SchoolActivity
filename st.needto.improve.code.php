<?php
			//initializations
			$servername = "localhost"; // database host
			$username = "root"; // database username
			$password = ""; // database password
			$dbname = "db_learners"; // database name
			// create connection
			$connection = new mysqli($servername, $username, $password, $dbname);
			// check connection
			if(!$connection) 
			{
				//if not connected show error message
				die("Connection failed: " . mysqli_connect_error());
			}
			#INSERT STUDENT DATA INTO DATABASE
			if(isset($_POST['register']))
			{
				//Get user input
				$entered_lrn = mysqli_real_escape_string($connection, $_POST['lrn']);
				$entered_lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
				$entered_firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
				$entered_middleName = mysqli_real_escape_string($connection, $_POST['middleName']);
				$entered_yearLevel = mysqli_real_escape_string($connection, $_POST['yearLevel']);
				$entered_trackStrand = mysqli_real_escape_string($connection, $_POST['trackStrand']);
				$entered_section = mysqli_real_escape_string($connection, $_POST['section']);
				#READ DATA IN DB
				$year_level = 1; //for data manipulation
				$strand = 1;
				$section = 1;
				//check data learner in db 
				$sql = "SELECT * FROM tbl_learners";
				$result = mysqli_query($connection, $sql);
				//fetch all learners data in database
				while($dbData = mysqli_fetch_assoc($result))
				{
					//check if entered dtaa  is equal to database row equipment name
					if($dbData['year_level'] == $_POST['yearLevel'] && $dbData['strand'] == $_POST['trackStrand'] && $dbData['section'] == $_POST['section'])
					{
						//if it is equal increment the the declared var = 0 into 1
						$year_level = $year_level + 1;
						$strand = $strand + 1;
						$section = $section + 1;
					}
				}
				//if data in db is grater than 5, execute this statement
				if($year_level >= 5 && $strand >= 5 && $section >= 5) 
				{
					echo '<script>
					alert("Failed to registered, No slots available!");
					window.location.href ="student.registration.php?register-limitmax=reach";
					history.go(-1);
					</script>';
					exit();
				}
				else //if so, insert the data into database
				{
					$query ="INSERT INTO tbl_learners(`lrn`, `last_name`, `first_name`, `middle_name`, `year_level`, `strand`, `section`) 
					VALUES ('$entered_lrn','$entered_lastName','$entered_firstName','$entered_middleName','$entered_yearLevel','$entered_trackStrand','$entered_section')";
					mysqli_query($connection, $query);
				}
			}
			
			//close database connection
			mysqli_close($connection);
		?>