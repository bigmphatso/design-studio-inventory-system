<!-- database connection -->
<?php 
    // Create connection
    $conn = mysqli_connect("localhost", "root", "Mphatso", "inventory");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  
?>