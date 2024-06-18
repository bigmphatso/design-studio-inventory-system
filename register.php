<?php 
    //including the database connection.
    include("db_connection.php");

    $errors = array('join_year' => '','type'=>'');

    //Initialising empty form variables.
    $join_year = '';
    $type= '';

    $overallfeedback = '';

    function validateForm($join_year,$type){

        //since the array $errors is defined outside the function it will generally work unless if we include keyword "global."
        global $errors;

        $statement = false;

        //regular expression for a name/string with whitespaces and characters[uppercase&lowercase].
        $reg_ex_name = '/^[a-zA-Z^\s]+$/';

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
        
        if(array_filter($errors)){
            $statement =false;
        }else{
            $statement =true;
        }

        return $statement;
    }

    if(isset($_POST['submit'])){
        $overallfeedback ='';

        $join_year = $_POST['join_year'];
        $type =$_POST['type'];

        $valid = validateForm($join_year,$type);
        echo 'Tili Mkati1.';
        if($valid === true){
            echo 'Tili Mkati2.';
            setcookie('join_year', '$join_year' , time()+120);
            setcookie('type', '$type' , time()+120);
            header("Location: registerStep2.php");
        }

        else{
            echo 'smthing is erronous.';
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
            <header>STEP 1</header>
            <span> <?php echo ($overallfeedback)?> </span>
            <hr>
        </div>

        <form action="register.php" method="post">
            <!-- type -->

            <div class="field_input">
                <label for="type">Type</label>
                <select id="type" name="type">

                    <option value="">Type of applicant</option>
                    <option value="student">Student</option>
                    <option value="employee">Employee</option>
                    <option value="external">External.</option>

                </select>
                <div class="feedback"><?php echo htmlspecialchars($errors['type']) ?></div>
            </div>

            <!-- year joined >= 2014 -->
            <div class="field_input">
                <label for="join_year">Year Joined University</label>
                <input type="number" id="join_year" name="join_year" value="<?php echo htmlspecialchars($join_year) ?>" >
                <p class="feedback"> <?php echo htmlspecialchars($errors['join_year']) ?> </p>
            </div>

            <!-- submission & redirection -->
            <div class="field_input">

                <button type="submit" name="submit"  class="button" >PROCEED TO STEP 2</button>
                <span>Already have an account? <a href="login.php">Login.</a> </span>
                
            </div>

        </form>

    </div>

</body>
</html>