<?php 
    //including the database connection.
    include("db_connection.php");

    $errors = array('email' => '','password' => '');
    $user_email ='';
    $_COOKIE['user_email'] ='';
    $user_email='';
    setcookie('user_email', '' , time()+30);

    function validateForm($email,$password){

        //since the array $errors is defined outside the function it will generally work unless if we include keyword "global."
        
        global $errors;
        $statement = false;

        // verify email first
        if(!empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please enter a valid email';
            }  
        }  
        else{
            $errors['email'] = 'An email is required.';
        }  

        //verify password rn.
        if(empty($password)){
            $errors['password']= 'A password is required';
        }

        
        if(array_filter($errors)){
            $statement =false;
        }else{

            $statement =true;
            //cookie email shall remain actve for (defined) seconds based on device time.
            setcookie('user_email', $email , time()+30);
        }

        return $statement;
    }

    if(isset($_POST['submit'])){
        
        $overallfeedback ='';
        // echo htmlspecialchars() "you clicked the submit button!";

        $user_email = $_POST['email'];
        $user_password =$_POST['password'];

        $valid = validateForm($user_email,$user_password);

        //cookie user_email & input_error shall remain actve for (defined) seconds based on device time.
        setcookie('input_error', '' , time()+10 );

        if($valid === true){
            $login_sql = "SELECT * FROM users WHERE email = '$user_email' AND password='$user_password' ";
            $result = mysqli_query($conn, $login_sql);
            $row = mysqli_fetch_assoc($result);
            // Execute SQL statement
            if (is_array($row) && !empty($row)) {

                session_start();
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['type'] = $row['type'];

                $_COOKIE['input_error'] = '<p class="feedback success"> Successful Login. </p>';
                mysqli_free_result($result);
                mysqli_close($conn);
                header("Location: user/index.php");

            }
            else{
                $_COOKIE['input_error'] = '<p class="feedback failed"> Failed attempt (Invalid email or password) </p>' ; 
            }
        }

    }

    function check(){

        global $user_email;

        if(!($_COOKIE['user_email'])):
            return ($user_email);
        else:
            return $_COOKIE['user_email'];
        endif;

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

        <div class="topper">
            <header>Login</header>
            <br>
            <span> <?php echo (($_COOKIE['input_error']) ?? '' )?> </span>
            <hr>
        </div>

        <form action="login.php" method="post">

            <div class="field_input">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars(check())?>">
                <p class="feedback"> <?php echo htmlspecialchars($errors['email']) ?> </p>
            </div>

            <div class="field_input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <p class="feedback"> <?php  echo htmlspecialchars($errors['password']) ?></p>
            </div>

            <div class="field_input">

                <button type="submit" name="submit"  class="button" >Log In</button>
                <span>Don't have an account? <a href="register.php">Register.</a> </span>
                
            </div>

        </form>

    </div>

</body>
</html>