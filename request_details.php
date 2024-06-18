<?php 
    require_once("db_connection.php");

    $request_email = $_POST['email'];
    $project_name = $_POST['project_name'];

    if($request_email !== "" && $project_name !== ""){

        $check_sql = "SELECT * FROM request WHERE email='$request_email' ";
        $result = mysqli_query($conn, $check_sql);
        $row = mysqli_fetch_assoc($result);
        
        if (mysqli_num_rows($result) > 0) {
            // echo("That nigga was found!");
        }
        else{
            echo ("Bitchass! Non-existent");
        }

    }
    else{
        echo "Fill all fields";
    }

    //urgency levels and their corresponding equivalence.
    $high='2 weeks';
    $medium='3 weeks';
    $low='6 weeks';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> see request details</title>
    <link rel="stylesheet" href="../styles/request.css">
</head>
<body>

    <div class="main_container">

        <h1>REQUEST DETAILS</h1>
        <p>Here are details for your recently made materials to the office of the <em>Design Studio</em> : </p>

        <br>

        <div class="detail_div">

            <p class="request_detail"> Email:
                <span class="exact_detail"> <?php echo $row['email']; ?> </span>
            </p>

        </div>
        
        <div class="detail_div">

            <p class="request_detail"> Applicant Name:
                <span class="exact_detail"> <?php echo ($row['firstname'] ." ". $row['lastname']); ?> </span>
            </p>

        </div>
        
        <div class="detail_div">

            <p class="request_detail"> Applied for Urgency:
                <span class="exact_detail"> <?php echo $row['urgency']; ?> </span>
            </p>
            <em> with this applied for level of urgency expect an approximation of
                <?php 
                    $urgency =  $row['urgency'];
                    if ($urgency === "low"){
                        echo($low);
                    }
                    else if($urgency === "medium"){
                        echo($medium);
                    }
                    else if($urgency === "high"){
                        echo($high);
                    }
                    else{
                        echo ('office announcal!');
                        // is even announcal a word?. hahah

                    }

                ?>
                for duly execution.
            </em>

        </div>
                
        <div class="detail_div">

            <p class="request_detail"> Applied for Urgency:
                <span class="exact_detail"> <?php echo $row['urgency']; ?> </span>
            </p>

        </div>

        <div>
            <a href="index.html"> 
                <button> Go Home </button>
            </a>
        </div>



        



    </div>

    

    
</body>
</html>