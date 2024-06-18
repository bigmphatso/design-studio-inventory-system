<?php 
    require_once("db_connection.php");
    include('header.php');
    //echo 'this is project:'.$project_name;
    // starting a session to access $_SESSION[] indeces
    session_start();

    $counter=1;

    if(isset($_SESSION['user_email'])){
        $user_email = $_SESSION['user_email'];
            
        //this just used as a example to see if it works it will later be fixed for an effective real time use.
        //now that project request has been made ___ get the id for such record and use it for successful_submission.php file
        $sql = "SELECT * FROM request WHERE email = '$user_email' ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);
        $requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if (!(mysqli_num_rows($result) > 0)) {
            echo" <div class='non_existing_record'>
            <p class='detail'> Sorry! No request were made. </p>
            </div>"; 
        }
        else{

        }

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
    <!-- <link rel="stylesheet" href="../styles/request.css"> -->
    <link rel="stylesheet" href="../styles/grid.css">
</head>
<body>

    <h3>

        <div class="header_block_box">
            <span class='box_header'>EMAIL</span>
            <p class='header_detail'> <?php echo $_SESSION['user_email']?> </p>

            <span class='box_header'>APPLICANT NAME</span> 
            <p class='header_detail' > <?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?> </p>
        </div>

    </h3>

    <div class="box_container">

        <?php foreach($requests as $request) { ?>

        <div class="main_box">

            <div class=block_box>
                <h3>Request 
                    <!-- PHP code for numbering the requests made 1 - infinity -->
                    <?php echo $counter; $counter++;  ?>
                </h3>
            </div>

            <div class="block_box">
                <span class='box_headers'>PROJECT DETAILS</span>
                <p class='detail' > <?php echo $request['project_name']?> projected to last for <?php echo $request['estimated_period']?></p>
            </div>

            <div class="block_box">
                <span class='box_headers'>REQUEST MADE</span>
                <span class='box_sub_headers'> <em> (Date and time) </em> </span>
                <p class='detail' > <?php echo $request['created_at']?></p>
            </div>


        </div>
        
        <?php }?> 
    </div>

   
</body>
</html>