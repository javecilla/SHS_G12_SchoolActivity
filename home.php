<?php 
   session_start();
   include_once('dbconnection.php');
   
   if(isset($_REQUEST['login'])){
   
      //Retrieve and get the submitted username and password
      $entered_username = mysqli_real_escape_string($connection, $_REQUEST['username']);
      $entered_password = mysqli_real_escape_string($connection, $_REQUEST['password']);

      // Check the login credentials
      $query = "SELECT * FROM tbl_accounts WHERE username ='$entered_username' ";
      $result = mysqli_query($connection, $query);

      //check if data submitted is exist in the database
      if (mysqli_num_rows($result) > 0)
      {
         //IF USERNAME EXIST/MATCH IN THE DATABASE THEN PROCEED TO THE NEXT CONDITION

         //fetch all row in the database table 'tbl_accounts'
         $row = mysqli_fetch_assoc($result);

         //check the entered password is match to the database  
         if ($entered_password === $row['password'])
         {

            $_SESSION['acctname'] = $row['acct_name'];
            $_SESSION['username'] = $entered_username;
            $_SESSION['acct_lvl'] = $row['acct_lvl'];

            //if entered password is match to the databse, then redirect to the home page
            echo "<script>
                     alert('Login succesfully');
                     window.location.href= 'home.php';
                  </script>
                  ";
            exit(0); 
         }
         else
         {
            //if is not match to the database, then display error message
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

?>

<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>HOME PAGE</title>
   </head>

   <body>

      <?php
         include_once('dbconnection.php');
         $user_name = $_SESSION['username'];

         $get_data = mysqli_query($connection, "SELECT * FROM tbl_accounts WHERE username ='$user_name'");
         $user_data = mysqli_fetch_assoc($get_data);

         $user = mysqli_num_rows($get_data);
         if($user == 0)
         {
            echo "<script>window.location.href='login-page.php'</script>";
         }             
      ?> 

      <input type="text" name="txtuser" id="txtusername" value="<?php echo $user_data['username']?>" />
      

      <h1>HOME PAGE</h1>
      <label>
         <h1><?php echo $user_data['acc_lvl']?></h1>
         <h4>WELCOME <?php echo $user_data['acct_name']?></h4>
      </label>

      <button type="button" onclick="window.location.href='login-page.php'">logout</button>
  
   </body>
</html>