<?php 
    //including the database connection.
    include("db_connection.php");

    $errors = array('email' => '','firstname' => '','lastname' => '','password' => '','confirm_password' => '','gender' => '','join_year' => '','program' => '','type'=>'');

    //Initialising empty form variables.
    $email ='';
    $firstname ='';
    $lastname ='';
    $password = '';
    $confirm_password = '';
    $gender = '';
    $join_year = '';
    $program ='';
    $type= '';

    $overallfeedback = '';

    function validateForm($firstname,$lastname,$email,$password,$confirm_password,$gender,$join_year,$program,$type){

        //since the array $errors is defined outside the function it will generally work unless if we include keyword "global."
        global $errors;

        $statement = false;

        //regular expression for a name/string with whitespaces and characters[uppercase&lowercase].
        $reg_ex_name = '/^[a-zA-Z^\s]+$/';

        //validating user first and last name!
        if(!empty($firstname)){
            if(!preg_match($reg_ex_name, $firstname))
            $errors['firstname'] = 'Only alphabetical characters are allowed.';   
        }
        else{
            $errors['firstname'] = 'A first name is required.';   
        }

        if(!empty($lastname)){
            if(!preg_match($reg_ex_name, $lastname))
            $errors['lastname'] = 'Only alphabetical characters are allowed.';   
        }
        else{
            $errors['lastname'] = 'A last name is required.';   
        }

        // validating email entered
        if(!empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please enter a valid email';
            }  
        }  
        else{
            $errors['email'] = 'An email is required.';
        }  

        //validating password for strength and match w '$confirm_password'
        if(!empty($password)){
            if(preg_match($reg_ex_name, $password)){
                $errors['password'] = 'Use a strong password please (a-z,0-9,!$%*&)';
            }    
        }

        else{
            $errors['password'] = 'A password is required.';   
        }

        if(!empty($confirm_password)){
            if(!($confirm_password === $password)){
                $errors['confirm_password']= "Passwords doesn't match!";
            }
        }
        else{
            $errors['confirm_password'] = 'Please confirm your password.';   
        }

        //validating gender for emptiness.

        if(empty($gender)){
            $errors['gender'] = 'Gender is required.';  
        }

        if(empty($type)){
            $errors['type'] = 'State whelther you are a student or employee or external';
        }

        //validating year joined university $join_year
        if(!empty($join_year)){
            if($join_year>2024){
                $errors['join_year'] = 'You can not join in the future. Who are you? Spirit!';   
            }
            elseif($join_year<2014){
                $errors['join_year'] = 'The university was opened in 2014';
            }
        }
        else{
            $errors['join_year'] = 'The year you joined the university is required.';   
        }
        
        if(empty($program)){
            $errors['program'] = 'A program of study is required.';   
        }

        if(array_filter($errors)){
            $statement =false;
        }else{
            $statement =true;
        }

        return $statement;
    }

    if(isset($_POST['submit'])){
        $overallfeedback ='';

        $email = $_POST['email'];
        $firstname =$_POST['firstname'];
        $lastname =$_POST['lastname'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $gender = $_POST['gender'];
        $join_year = $_POST['join_year'];
        $program = $_POST['program'];
        $type =$_POST['type'];

        $valid = validateForm($firstname,$lastname,$email,$password,$confirm_password,$gender,$join_year,$program,$type);

        if($valid === true){
            $check_sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $check_sql);
            $row = mysqli_fetch_assoc($result);
            
            if (mysqli_num_rows($result) > 0) {
                $overallfeedback = '<p class="feedback"> Email already in use. </p>' ; 
            }
            else{
                // Prepare SQL statement
                $sql = "INSERT INTO users (firstname,lastname,email,password,gender,join_year,program,type)
                        VALUES ('$firstname','$lastname','$email','$password','$gender','$join_year','$program','$type')";

                // Execute SQL statement
                if (mysqli_query($conn,$sql)) {   

                    $overallfeedback = '<p class="feedback success"> Successful submission.. </p>' ;
                    header("Location: successful_register.php");
                    mysqli_free_result($result);
                    mysqli_close($conn);

                }
                else{
                   echo 'An error occured '. mysqli_error($conn);
                }

            }

        }
        else{
            // echo 'smthing is erronous.';
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registering as a new user</title>
    <link rel="stylesheet" href="styles/user_interface.css">
</head>
<body>
    <div class="main_container">

        <div class="topper">
            <header>Registering as a new user</header>
            <br>
            <span> <?php echo ($overallfeedback)?> </span>
            <hr>
        </div>

        <form action="registerStep2.php" method="post">

            <!-- firstname -->
            <div class="field_input">
                <label for="firstname">First name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname) ?>">
                <p class="feedback"> <?php echo htmlspecialchars($errors['firstname']) ?> </p>
            </div>

            <!-- lastname -->
            <div class="field_input">
                <label for="lastname">Last name</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname) ?>">
                <p class="feedback"> <?php echo htmlspecialchars($errors['lastname']) ?> </p>
            </div>

            <!-- Email -->
            <div class="field_input">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
                <p class="feedback"> <?php echo htmlspecialchars($errors['email']) ?> </p>
            </div>

            <!-- gender -->

            <div class="field_input">
                <label for="gender">Gender</label>
                <select id="gender" name="gender">

                    <option value="">select a gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="unknown">Rather Not Say.</option>

                </select>
                <div class="feedback"><?php echo htmlspecialchars($errors['gender']) ?></div>
            </div>

            <!-- type -->

            <div class="field_input">
                <label for="type">Type</label>
                <input type="text" value=" <?php echo $_COOKIE['type']; ?>" readonly>
            </div>

            <?php if(($_COOKIE['type']) === 'student') { ?>
                <!-- program -->

                <?php echo ('                <div class="field_input">
                    <label for="program">Select your program</label>
                    <select id="program" name="program">
                        
                        <option value="">select a program</option>
                        <option value="cis">Computer System and Security</option>
                        <option value="bit">Business Information Technology</option>
                        <option value="che">Chemical Engineering</option>
                        <option value="bam">African Musicology</option>
                        <option value="txe">Textural Engineering</option>
                        <option value="ss">Sports science</option>
                        <option value="imv">Immunology</option>
                        <option value="imb">Microbiology</option>
                        <option value="fst">Food science</option>
                        <option value="msc">Mathematical Science</option>
                        <option value="esc">Earth Science</option>
                        <option value="mec">Meteorology and Climate Change</option>
                        <option value="gis">Geo-Information & Earth Observation Science</option>
                        <option value="drm">Disaster Risk Management</option>
                        <option value="petr">Petroleum Goe-Science(Oil and Gas)</option>
                        <option value="wqm">Water Quality Management</option>
                        <option value="cec">Cultural Economy</option>

                    </select>
                    <p class="feedback"> <?php echo htmlspecialchars($errors["program"]) ?> </p>
                </div>') ?>

            <?php }elseif((($_COOKIE['type']) === 'external' || ($_COOKIE['type']) === 'employee')) { ?>
                <input type="text" value=" <?php echo 'unapplicable' ?>" readonly> 

            <?php  }else{
                $overallfeedback = '<p class="feedback"> Cookies timed Out! </p>' ; 
                header("Location: register.php");
                }
            ?>

            <!-- year joined >= 2014 -->
            <div class="field_input">
                <label for="join_year">Year Joined University</label>
                <input type="number" id="join_year" name="join_year" value="<?php echo htmlspecialchars($join_year) ?>" >
                <p class="feedback"> <?php echo htmlspecialchars($errors['join_year']) ?> </p>
            </div>


            <!-- password -->
            <div class="field_input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
                <p class="feedback"> <?php  echo htmlspecialchars($errors['password']) ?></p>
            </div>

            <!-- confirm password -->
            <div class="field_input">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password) ?>">
                <p class="feedback"> <?php  echo htmlspecialchars($errors['confirm_password']) ?></p>
            </div>

            <!-- submission & redirection -->
            <div class="field_input">

                <button type="submit" name="submit"  class="button" >Register</button>
                <span>Already have an account? <a href="login.php">Login.</a> </span>
                
            </div>

        </form>

    </div>

</body>
</html>