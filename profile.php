<?php 
    require_once("db_connection.php");
    include('header.php');
    //echo 'this is project:'.$project_name;
    // starting a session to access $_SESSION[] indeces
    session_start();

    $counter=1;
    $no_requests ='';

    if(isset($_SESSION['user_email'])){
        $user_email = $_SESSION['user_email'];
            
        //this just used as a example to see if it works it will later be fixed for an effective real time use.
        //now that project request has been made ___ get the id for such record and use it for successful_submission.php file
        $sql = "SELECT * FROM request WHERE email = '$user_email' ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);
        $requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if (!(mysqli_num_rows($result) > 0)) {
            $no_requests =" <div class='non_existing_record'>
            <p class='detail'> Sorry! No requests were made. </p>
            <p class='detail'> <a href='request.php'> <button> Make a request </button> </a> </p>
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
    <title>user profile</title>
    <!-- <link rel="stylesheet" href="../styles/request.css"> -->
    <link rel="stylesheet" href="../styles/grid.css">
    <!-- user profile styling -->
    <style>

        .main_container,.right,.left{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            background-color:white;
        }

        .profile{
            display: grid;
            grid-template-columns: 3fr 1fr;
            border-radius:25px;
            box-shadow: 1px 2px 4px rgb(99, 99, 99);

            margin-top:10px;
            padding:50px 15px;

        }

        .profile .right{
            background-color: rgb(115, 179, 210);
            border-radius:15px;
            padding: 50px;
        }

        .user_image ,.user_image img{
            display:flex;
            background-color:rgb(35, 141, 153);
            border-radius:50%;
            width:120px;
            height:120px;
            min-width: 50px;
            min-height: 50px;
            /* border-style:none; */
        }

    </style>
</head>
<body>
    <div class="main_container">

        <div class="profile">

            <div class="left">

                <h3>
                <div class=block_box>

                    <h3>Your recent requests</h3>

                </div>
            
                </h3>

                <?php echo $no_requests?>
            
                <div class="box_container">
            
                    <?php foreach($requests as $request) { ?>

                    <div class="main_box">
            
                        <div class="block_box">

                            <!-- <span class='box_headers'>PROJECT DETAILS</span> -->
                            <p class='detail'>
                                <!-- PHP code for numbering the requests made 1 - infinity -->
                                <span class='numbering'> <?php echo $counter." . "; $counter++;  ?> </span>
                                <?php echo $request['project_name']?> projected to last for <?php echo $request['estimated_period']?>

                            </p>

                        </div>
            
                        <div class="block_box">
                            <span class='box_headers'>REQUEST MADE</span>
                            <!-- <span class='box_sub_headers'> <em> (Date and time) </em> </span> -->
                            <p class='detail' > <?php echo $request['created_at']?></p>
                        </div>
            
            
                    </div>

                    <?php }?> 
                </div>
                
            </div>

            <div class="right">

                <div class="user_image">
                    <!-- src="<?php // echo (realpath($user_image) ?? $default_user_image)  ?>" -->
                    <img src="../img/4.jpg" alt="User image here">
                </div>

                <br>
                <h3>User Profile</h3>

                <div class="header_block_box">
                    <span class='box_header'>EMAIL</span>
                    <p class='header_detail'> <?php echo $_SESSION['user_email']?> </p>
                </div>

                <div class="header_block_box">             
                    <span class='box_header'>FULL NAME</span> 
                    <p class='header_detail' > <?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?> </p>
                </div>

                <div class="header_block_box"> 
                    <span class='box_header'>TYPE</span> 
                    <p class='header_detail' > <?php echo $_SESSION['type']?> </p>
                </div>

            </div>
        </div>


    </div>

</body>
</html>