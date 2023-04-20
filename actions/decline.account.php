<?php
session_start();
include_once('../config/db.connection.php');

	if(isset($_POST["decline_account"])) {
		$account_id = $_POST['decline_id'];
		try {
			$query = "DELETE FROM accounts WHERE account_id = ?";
    		$stmt = mysqli_prepare($connection, $query);
    		mysqli_stmt_bind_param($stmt, "i", $account_id);
    		mysqli_stmt_execute($stmt);

    		if(mysqli_stmt_affected_rows($stmt) > 0) {
            	$_SESSION['message'] = "Account <b>'".$_SESSION['acct_name']."'</b> deleted successfully!";
	        } else {
	            throw new Exception("Failed to delete an account: " . mysqli_stmt_error($stmt));
	        }

	        header("Location: ../exam.useraccounts.php");
	        exit();

		} catch(Exception $e) {
			echo "An error occured: " . $e->getMessage(); 
		}
	}