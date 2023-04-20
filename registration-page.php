<?php 
session_start();
include_once('dbconnection.php');

    //REGISTER BUTTON FUNCTION
    if(isset($_POST["regbtn"])) {

        //Declaration   
        $account_name = $_POST['accname'];
        $access_level = $_POST['accesslevel'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['cpassword'];

        $enteredUsername = 0;

        $sql = "SELECT username FROM tbl_accounts";
        $getresult = mysqli_query($connection, $sql);

        //fetch all username in database
        while($uname_row = mysqli_fetch_assoc($getresult))
        {
            //check if entered username is equal to database uname_row [username]
            if($uname_row['username'] == $_POST['username'])
            {
                //if it is equal increment the the declared var enteredUsername = 0 into 1
                $enteredUsername = $enteredUsername + 1; //it will be enteredUsername=1
            }

        }

        //check if username is already exist or not
        if($enteredUsername == 0)
        {
            //IF USERNAME IS NOT ALREADY, EXIST THEN PROCEED TO NEXT STATEMENT

            //check if password is grather than length of 8
            if(strlen($password) > 8 && strlen($confirmPassword) > 8)
            {
                //IF PASSWORD IS GRATHER THAN 8, THEN PROCEED TO NEXT CONDITION

                //check entered password is match in confirrm password
                if($password == $confirmPassword)
                {   
                    //Let user input data in registration form stored into database
                    $sql = "INSERT INTO tbl_accounts (`acct_name`, `acc_lvl`, `username`, `password`) 
                    VALUES ('$account_name','$access_level','$username','$password')";

                    //check all query is inserted onto database
                    $result = $connection->query($sql);

                    //check all query is executed then popping up if sucess or not
                    if($result) {
                        echo '<script>
                            alert("Registered Successfully");
                            window.location.href = "'.$_SERVER['HTTP_REFERER'].';
                        </script>';
                    }
                    else 
                    {
                        $_SESSION['error_message'] = "Failed to create account. Something went wrong.";
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit(0);
                    }
                }
                else
                {
                    //IF PASSWORD IS NOT MATCH IN CONFIRM PASSWORD
                    $_SESSION['error_message'] = "New password and confirm password does not match.";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit(0);
                }
            }
            else
            {
                //IF PASSWORD IS LESSER THAN 8, THEN EXECUTE THIS STATEMENT
                $_SESSION['error_message'] = "Password is too short";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit(0);
            }
        }
        else
        {   
            //IF USER NAME IS ALREADY EXIST IN THE DATABASE THEN EXECUTE THIS STATEMENT
            $_SESSION['error_message'] = "Username is already is exist.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
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
    <title>REGISTRATION PAGE</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;}

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f3f3f3;}

        div.form-container {
            background: #fff !important;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 4px 6px 0 rgba(0, 0, 0, .5);}

        input.radio-btn,
        label.radio-btn {
            cursor: pointer;
            accent-color: gray;}

        input.account-name,
        input.username,
        input.password,
        input.confirm-password {
            width: 320px;
            height: 30px;
            margin-bottom: 7px;
            padding-inline: 5px; 
            font-size: 14px; }

        label.account-name,
        label.access-level,
        label.username,
        label.password,
        label.confirm-password {
            font-size: 15px;
            font-weight: 550;
            margin-bottom: 1rem;}

        button.register-btn {
            background: green;
            border: none;
            opacity: 0.8;
            color: #fff;
            width: 335px;
            height: 40px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 14px; 
            border-radius: 2px; }
            button.register-btn:hover {
                opacity: 1; }

         button.login-btn {
            background: transparent;
            border: 1px solid green;
            opacity: 0.8;
            color: green;
            width: 335px;
            height: 40px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 14px; 
            border-radius: 2px; }
            button.login-btn:hover {
                opacity: 1; } 

    </style>

</head>

<body>
    
    <div class="form-container" >
        <label>LOGIN YOUR ACCOUNT.</label>
        <br/><br/>
        <form action="" method="POST" oninvalid="false" autocomplete="off">

            <!--ERROR ALERT MESSAGE-->
            <?php 
                if(isset($_SESSION['error_message'])) { ?>
                <p style="color: red;"><?=$_SESSION['error_message'];?></p>
            <?php unset($_SESSION['error_message']); } ?>

            <label for="account-name" class="account-name">Account Name:<br/>
                 <input type="text" placeholder="Account name" name="accname" class="account-name" required />
            </label>

            <br/>
            <label for="access-level" class="access-level">Access level:</label>
            &nbsp;&nbsp;
            <label class="radio-btn">
                <input type="radio" onclick="admin()" id="a" class="radio-btn"/>
                 Admin
            </label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-btn">
                <input type="radio" onclick="user()" id="u" class="radio-btn"/>
                User
            </label>    
            <input type="text" name="accesslevel" id="accessLevel" style="display: none;" required />   
            <br/>

            <br/>
            <label for="username" class="username">Username: </label><br/>
            <input type="text" placeholder="Username" name="username" class="username" required/>
            <br/>
            <label for="password" class="password">Password:</label><br/>
            <input type="password" placeholder="Password" class="password" name="password" required />
            <br/>
            <label for="confirm-password" class="confirm-password">Confirm Password:</label><br/>
            <input type="password" placeholder="Password" class="confirm-password" name="cpassword"required />
            <br/>
            <br/>
            <button type="submit" name="regbtn" class="register-btn">Register</button>
            <br/><hr/><br/>
            <button type="button" name="login" class="login-btn" 
            onclick="window.location.href='login-page.php'">Login</button>

        </form>
    </div>
</body>
</html>

<script>
    function admin(){
        document.getElementById("u").checked = false;
        document.getElementById("accessLevel").value = "Admin";
    }
          
    function user(){
        document.getElementById("a").checked = false;
        document.getElementById("accessLevel").value = "User";
    }
</script>