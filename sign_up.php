<?php 

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registerin as a new user</title>
    <link rel="stylesheet" href="styles/user_interface.css">
    <!-- <link rel="stylesheet" href="index.css"> -->
</head>
<body>
    <div class="main_container">

        <div class="topper">
            <header>Registering as a new user</header>
            <br>
            <hr>
        </div>


        <form  action="process_register.php" method="post" id="form">

            <div class="field_input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
                <div class="feedback"></div>
            </div>

            <div class="field_input">
                <label for="program">Select your program</label>
                <select id="program" name="program" required>
                    
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
                <p class="feedback"></p>
            </div>

            <div class="field_input">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    
                    <option value="">select a gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="unknown">Rather Not Say.</option>

                </select>
                <div class="feedback"></div>
            </div>

            <div class="field_input">
                <label for="join_year">Year Joined University</label>
                <input type="number" id="join_year" name="join_year" min="2014" max="2024" required >
                <p class="feedback"></p>
            </div>

            <div class="field_input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <p class="feedback"></p>
            </div>

            <div class="field_input">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <p class="feedback"></p>
            </div>

            <div class="field_uber">

                <button type="submit" class="btn">Log In</button>
                <span>Already have an account? <a href="login.php">Login.</a> </span>
                
            </div>

        </form>

    </div>

</body>
<script src="js/sign_up.js"></script>
</html>