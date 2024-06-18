<?php 
    require_once("db_connection.php");


    $request_email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $project_name = $_POST['project_name'];
    $urgency = $_POST['urgency'];
    $estimated_period = $_POST['estimated_period'];

    $document_header = 'PROCESSING';
    $document_info = 'The submitted form is underway processing.';
    $already_made_request_email = '';
    $re_try_directory = '';
    // $request_made;
    $request_details = '';
    $row = array();
    


    // making sure! all fields are with contents.
    if($request_email !== "" && $firstname !== "" && $lastname !== "" && $urgency !== "" && $estimated_period !== "")
    {
        
        //verify if a project of such name has already made a materials request.
        $check_sql = "SELECT * FROM request WHERE project_name = '$project_name'";
        $result = mysqli_query($conn, $check_sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            // while ($row = mysqli_fetch_assoc($result))
            $document_header = "<h2 class='error_occured_header'> Error occured! </h2>";
            $document_info = 'A materials request (similar project name) has already been made by another user.';
            
            $already_made_request_email=('Made by '.$row['email']);
            $re_try_directory = '<a href="request.php"> try with a different project name! </a>';
   
        }
        
        else{
            // Prepare SQL statement
            $sql = "INSERT INTO request (email,firstname,lastname,project_name,urgency,estimated_period)
            VALUES ('$request_email','$firstname','$lastname','$project_name','$urgency',$estimated_period)";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {   
                
                $document_header = "<h2 class='success_header'> Submission successful </h2>";
                $document_info = 'Await for approval for your request.';
            
                // displaying just-made request details.

                $request_details =
                "
                    <div class='div_request_details'>

                        <h3>Request Details</h3>
                        <h5>email 
                            <span>
                                <?php echo $request_email?>
                            </span>
                        </h5>

                    </div>

                ";



            }
        } 
    }
    else{
        echo("Fill all fields!");
        header("Location: request.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>processing request</title>
    <link rel="stylesheet" href="../styles/request.css">
</head>
<body>

<div class="main_container">

    <?php echo $document_header; ?>
    <p> <?php echo $document_info; ?> </p>
    <p> <?php echo $already_made_request_email; ?> </p>
    <?php echo $re_try_directory ?>

    <!--  Redirect back to the index.php page---- home page. -->

    <br>

    <div class="buttons_div">

        <a href="index.html"> 
            <button> Okay! </button>
        </a>

        <form method="post" action="request_details.php">

            <input hidden type="text" name="email"
                value="<?php echo $request_email?>"
            >
            <input hidden type="text" name="project_name"
                value="<?php echo $project_name;?>"
            >
            <button type='submit'>See Details</button>

        </form>

    </div>

</div>

<div class="background">
    <!-- here is the design studio background! -->
    <!-- add a form of interesting distraction! -->
</div>

    
</body>
</html>

    



