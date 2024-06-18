<?php 
    //including the database connection.
    include("db_connection.php");
    include("header.php");
    session_start();

    $errors = array('email' => '','firstname' => '','lastname' => '','project_name' => '','urgency' => '','estimated_period' => '');


    // setting cookies(lasting for an approximaion of 60seconds)for variables in he document
    
    setcookie('project_name', '' , time()+60);
    setcookie('urgency', '' , time()+60);

    //Initialising empty form variables.
    $email ='';
    $firstname = '';
    $lastname = '';
    $project_name = '';
    $urgency = '';
    $estimated_period ='';

    $overallfeedback = '';

    function validateForm($email,$firstname,$lastname,$project_name,$urgency,$estimated_period){

        //since the array $errors is defined outside the function it will generally work unless if we include keyword "global."
        
        global $errors;
        $statement = false;

        //regular expression for a name/string with whitespaces and characters[uppercase&lowercase].
        $reg_ex_name = '/^[a-zA-Z^\s]+$/';

        // verify email first
        if(!empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please enter a valid email';
            }  
        }  
        else{
            $errors['email'] = 'An email is required.';
        }  

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

        if(!empty($project_name)){
            if(!preg_match($reg_ex_name, $project_name))
            $errors['project_name'] = 'Only alphabetical characters are allowed.';   
        }
        else{
            $errors['project_name'] = 'You need a project name or suggest one.';   
        }

        if(!empty($urgency)){
            if(!(is_string($urgency))){
                $errors['urgency'] = 'Should a string value.';   
            }
        }
        else{
            $errors['urgency'] = 'Fill the urgency is required.';   
        }
        
        if(empty($estimated_period)){
            $errors['estimated_period'] = 'Approximate estimated period for your project.';   
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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $project_name = $_POST['project_name'];
        $urgency = $_POST['urgency'];
        $estimated_period = $_POST['estimated_period'];

        $valid = validateForm($email,$firstname,$lastname,$project_name,$urgency,$estimated_period);

        if($valid === true){
            $check_sql = "SELECT * FROM request WHERE project_name = '$project_name'";
            $result = mysqli_query($conn, $check_sql);
            $row = mysqli_fetch_assoc($result);
            
            if (mysqli_num_rows($result) > 0) {
                $overallfeedback = '<p class="feedback failed"> Already existing project name. </p>' ; 
            }
            else{
                // Prepare SQL statement
                $sql = "INSERT INTO request (email,firstname,lastname,project_name,urgency,estimated_period)
                VALUES ('$email','$firstname','$lastname','$project_name','$urgency','$estimated_period')";

                // Execute SQL statement
                if (mysqli_query($conn,$sql)) {   

                    $overallfeedback = '<p class="feedback success"> Successful submission.. </p>' ;
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    header("Location: successful_submission.php");

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Making a materials request.</title>

    <style>
        html{
            background-color:rgb(227, 227, 227);
        }
        .all-container{
            display:flex;
            flex-direction:column;
            padding: 10px 50px ;
            margin:50px;
        }
        h1{
            text-align:center;
        }

        form{
            display:grid;
            grid-template-columns:1fr 1fr 1fr;
        }

        .input_div{
            display: flex;
            flex-direction:column;
            margin-top:30px;
            margin-right:12px;
        }

        .input_div input , .input_div select{
            border-radius: 9px;
            border: 2px solid rgb(0, 20, 96);
            padding:3px;
            outline: red;

        }
        .input_div button{
            margin-top:15px;
        }

        .feedback{
            font-size: 11px;
            color: rgb(228, 14, 14);
        }
        .success{
            color: green;
        }
        .error{
            color: darkred;
        }


    </style>

    <link rel="stylesheet" href="../styles/request.css">

</head>
<body>
<div class="all-container">

    <!-- Main -->
    <h1>MAKE A REQUEST.</h1>
    <p>You can only make your requests via your own email</p>
 
    <main class="main-container">
    
        <div class="input_div">
            <?php echo $overallfeedback ?>
        </div>   

        <form method="post" action="request.php">

            <div class="input_div">
                <!-- <label for="email">Email</label>   -->
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['user_email']?>" readonly hidden>
                <!-- <p class="feedback"> <?php // echo $errors['email']?> </p> -->
            </div>

            <div class="input_div">
                <!-- <label for="firstname">First name</label>   -->
                <input type="text" id="firstname" name="firstname" value="<?php echo $_SESSION['firstname']?>" readonly hidden>
                <!-- <p class="feedback"> <?php //echo $errors['firstname']?> </p> -->
            </div>

            <div class="input_div">
                <!-- <label for="lastname">Last Name</label>   -->
                <input type="text" id="lastname" name="lastname" value="<?php echo $_SESSION['lastname']?>" readonly hidden>
                <!-- <p class="feedback"> <?php // echo $errors['lastname']?> </p> -->
            </div>
            
            <div class="input_div">
                <label for="project_name">Project Name</label>  
                <input type="text" id="project_name" name="project_name" value="<?php echo $project_name?>">
                <p class="feedback"> <?php echo $errors['project_name']?> </p>
            </div>

            <div class="input_div">
                <label for="urgency">Urgency</label>  
                <select class="" id="urgency" name="urgency" value="<?php echo $urgency?>">

                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high" >High</option>


                </select>
                <p class="feedback"> <?php echo $errors['urgency']?> </p>
            </div>

            <div class="input_div">
                <label for="estimated_period">Estimated Length</label>  
                <select id="estimated_period" name="estimated_period" value="<?php //echo $estimated_period?>">
                    <option value="" selected>Unknown</option>
                    <option value="4 weeks">A Month.</option>
                    <option value="8 weeks">Two (2) Months.</option>
                    <option value="6 months">Half a year.</option>
                    <option value="12 months">Approxiamtely over a year.</option>
                    <option value="Unspecified." >Unspecified.</option>

                </select>
                <p class="feedback"> <?php echo $errors['estimated_period']?> </p>
            </div> 

            <div class="input_div">
                <button type="submit" name="submit"  class="button" >Submit.</button>
                <button type="clear" class="btn-reset">Clear</button>
                <p> 
                    <a href="info.html"> I don't undertand how to fill this form. <em> help! </em> </a>  
                </p>
            </div>


        </form>
        
    </main>
    <!-- End Main -->

</div>

<!-- <script>
    function validateForm() {
        var firstName = document.getElementById("first_name").value;
        var lastName = document.getElementById("last_name").value;
        var estimated_period = document.getElementById("estimated_period").value;
        var email = document.getElementById("email").value;
        var licenseNumber = document.getElementById("license_number").value;
        var salary = document.getElementById("salary").value;

        // Validate first name and last name
        var nameRegex = /^[a-zA-Z]+$/;
        if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
            alert("First name and last name must contain only letters and cannot be empty.");
            return false;
        }

        // Validate phone number
        if (estimated_period.length !== 9 || isNaN(estimated_period)) {
            alert("Phone number must contain exactly 9 digits and cannot be empty.");
            return false;
        }

        // Validate email
        var emailRegex = /\S+@\S+\.\S+/;
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Validate license number
        if (licenseNumber.length !== 9 || isNaN(licenseNumber)) {
            alert("License number must contain exactly 9 digits and cannot be empty.");
            return false;
        }

        // Validate salary
        if (salary < 1000 || salary > 100000 || isNaN(salary)) {
            alert("Salary must be a number between 1000 and 100000.");
            return false;
        }

        return true; // Form is valid
    }
</script> -->
</body>

</html>
