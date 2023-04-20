<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN PAGE</title>

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

        input.user,
        input.pass {
            width: 320px;
            height: 30px;
            margin-bottom: 7px;
            padding-inline: 5px; 
            font-size: 14px; }

        label.username,
        label.password {
            font-size: 15px;
            font-weight: 550;
            margin-bottom: 1rem;}

        label.show{cursor: pointer;}

        input.show {
            cursor: pointer;
            accent-color: gray;}


        button.login-btn {
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
            button.login-btn:hover {
                opacity: 1;  }

         button.register-btn {
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

        <!--ERROR ALERT MESSAGE-->
        <?php 
            if(isset($_SESSION['error_message'])) { ?>
            <p style="color: red;"><?=$_SESSION['error_message'];?></p>
        <?php unset($_SESSION['error_message']); } ?>

        <br/>

        <form action="home.php" method="POST" oninvalid="false" autocomplete="off">

            <label for="birthday" class="username">Username: </label><br/>
            <input type="text" placeholder="Username" name="username" class="user" required/>
            <br/>

            <label for="password" class="password">Password:</label><br/>
            <input type="password" placeholder="Password" class="pass" id="passw" name="password" required />
            <br/>

            <label class="show">
                <input type="checkbox" class="show" onclick="show()" />
                Show
            </label>
            <br/>
            <br/>
            <button type="submit" name="login" class="login-btn">Login</button>
            <br/><hr/><br/>
            <button type="button" name="create" class="register-btn" 
            onclick="window.location.href='registration-page.php'">Create an account</button>
        </form>
    </div>
</body>
</html>

<script>
    //Hide and show password
    function show() {
        let userPass = document.getElementById("passw");
        if (userPass.type === "password") {
            userPass.type = "text";
        } else {
            userPass.type = "password";
        }
    }
</script>