<?php

    $feedbackFromInput='';
    session_start();
   // $_SESSION['failed']='';

    if(isset($_POST['email']) !== ""){
        include("db_connection.php");
                            
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];
                        
        $login_sql = "SELECT * FROM users WHERE email = '$user_email' AND password='$user_password' ";
        $result = mysqli_query($conn, $login_sql);
        $row = mysqli_fetch_assoc($result);
                        
        if (is_array($row) && !empty($row)) {
            $feedbackFromInput='<p class="success">Successful Login.</p>';
            $_SESSION['email']= $row['email'];
            $_SESSION['password']= $row['password'];
            $_SESSION['program']= $row['program'];
            $_SESSION['user_id']= $row['user_id'];
            $_SESSION['email']= $row['email'];

            header("Location: user/index.html");
        }
        else{
            //$_SESSION['failed']= '<p class="failed">previous input failed.try again</p>';
            $feedbackFromInput='<p class="failed">Failed login.</p>';
            // header("Location: login.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loggin in as a user</title>
    <link rel="stylesheet" href="styles/user_interface.css">
</head>
<body>
    <div class="main_container">

        <header>Loggin attempt</header>

        <hr>
        
            <div class="field_input">
                <?php echo $feedbackFromInput ?>
            </div> 

            <div class="field_input">
                <?php // session_destroy(); ?>
                <a href="login.php">
                    <button class="btn-failed"> Try again </button>
                </a>
            </div>

    </div>

</body>
</html>