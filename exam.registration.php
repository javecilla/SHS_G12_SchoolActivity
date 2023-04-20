<?php
session_start();
include_once('config/db.connection.php');

	//check if button registered is set
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
		//retrieve and sanitize user inputs
		$accountName = mysqli_real_escape_string($connection, $_POST['acctname']);
		$accessLevel = mysqli_real_escape_string($connection, $_POST['acctlevel']);
      	$username = mysqli_real_escape_string($connection, strtolower($_POST['username']));
      	$password = mysqli_real_escape_string($connection, $_POST['password']);
      	$cpassword = $_POST['cpassword'];

      	//hash the entered password by user before it save in db
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

      	try {
      		//validate user input
      		if($password != $cpassword) {
      			$_SESSION['error_message'] = "Password and Confirm Password is NOT match!";
      			header("Location: exam.registration.php");
      			exit();
      		} else {
		        //validate user against database
		        $query = "INSERT INTO accounts (`name`, `access_level`, `username`, `password`) 
	        		VALUES (?, ?, ?, ?)";
	    		$stmt = mysqli_prepare($connection, $query); 
	    		mysqli_stmt_bind_param($stmt, "ssss", $accountName, $accessLevel, $username, $hashed_password);
	    		mysqli_stmt_execute($stmt); 

	    		if(mysqli_stmt_affected_rows($stmt) > 0) {
	    			//store user information to session
				    $accountID = mysqli_insert_id($connection);
				    $_SESSION['account_id'] = $accountID;
				    $_SESSION['acct_name'] = $accountName;

	    			$_SESSION['message'] ="Your account <b>'".$_SESSION['acct_name']."'</b> registered successfully!";
	    			header("Location: exam.useraccounts.php");
		        	exit();
	    		} else {
	    			throw new Exception("Failed to register: " . mysqli_stmt_error($stmt));
	    		}
    		}
	      	

	    } catch(Exception $e) {
	      	echo "An error occured: " . $e->getMessage();
	    }

        mysqli_stmt_close($stmt); //close all statment query action
        mysqli_close($connection); //close database connection
   
	}
?>
<?php include_once('includes/header.php'); ?>
		<style type="text/css">
            * {
                margin: 0;
                padding: 0;
            }
            body {
                overflow-x: hidden;
                user-select: none;
            }      
        </style>
		<div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="register-content">

                	<div class="card">
                        <div class=" container" style="width: 100%!important;">
                			<p class="form-control" style="background: #F0FBFA;" >
                                ACCOUNT REGISTRATION
                           </p><hr/>

                            <form action="exam.registration.php" method="POST">
                                <!--error message-->
                                <?php 
                                    if(isset($_SESSION['error_message'])) { ?>
                                    <p class="text-danger" style="position: absolute; left: 24%"><?=$_SESSION['error_message'];?></p>
                                <?php unset($_SESSION['error_message']); } ?> 
                                <br/>

                                <label class="label">Account Name: <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <input type="text" name="acctname" id="" placeholder="Enter account name"  
                                    class="form-control" autocomplete="on" required /><br/>
                                </div>

                                <label class="label">Access Level: <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                   <input list="role" name="acctlevel" class="form-control" placeholder="-- SELECT --" required > 
                                   <datalist id="role">
                                        <option value="Admin">Admin</option> 
                                        <option value="User">User</option> 
                                    </datalist>  
                                </div>


                                <label class="label">Username: <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <input type="text" name="username" id="" placeholder="Enter username"  
                                    class="form-control" autocomplete="on" required/><br/>
                                </div>

                                <label class="label">Password: <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <input type="password" name="password" id="" placeholder="Enter password"  
                                    class="form-control" autocomplete="on" required/><br/>
                                </div>

                                <label class="label">Confirm Password: <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <input type="password" name="cpassword" id="" placeholder="Confirm your password"  
                                    class="form-control" autocomplete="on" required/><br/>
                                </div>


                                <div class="action-group">
                                    <button type="submit" name="register" class="btn btn-success btn-flat pull-right">  Register
                                    </button><br/>
                                </div>
                              
                            </form>
                		</div>
                	</div>
                </div>
            </div>
        </div>


<?php include_once('includes/footer.php'); ?>