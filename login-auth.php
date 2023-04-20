<?php 
   session_start();
   include_once('dbconnection.php');
   
   if(isset($_REQUEST['login'])){
   
      //Retrieve and get the submitted username and password
      $entered_username = mysqli_real_escape_string($connection, $_REQUEST['username']);
      $entered_password = mysqli_real_escape_string($connection, $_REQUEST['password']);

      // Check the login credentials
      $query = "SELECT * FROM tbl_accounts WHERE username = '$entered_username' ";
      $result = mysqli_query($connection, $query);

      //check if data submitted is exist in the database
      if (mysqli_num_rows($result) > 0)
      {
         //IF USERNAME EXIST/MATCH IN THE DATABASE THEN PROCEED TO THE NEXT CONDITION

         //fetch all row in the database table 'users'
         $row = mysqli_fetch_assoc($result);

         //check the entered password is match to the database  
         if ($entered_password === $row['password']){

            //if password is match to the databse, then redirect to the dashboard
            echo "<script>window.location.href= 'home.php'</script>";
            exit(0); 
         }
         else
         {
            //if it is not, then display error message
            $_SESSION['error_message'] = "Your <span><b>password</b></span> is incorrect! Please try again";
            echo "<script>window.location.href= 'login-page.php'</script>";
            exit(0);
         }
      }
      else
      {
         //IF USERNAME IS NOT MATCH/EXIST IN THE DATABASE THEN EXECUTE THIS STATEMENT
         $_SESSION['error_message'] = "Your <span><b>username</b></span> is incorrect! Please try again";
         echo "<script>window.location.href= 'login-page.php'</script>";
         exit(0);
      }

   }

//close connection

?>