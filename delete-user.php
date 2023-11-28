<?php

echo <<<_END
        <!DOCTYPE html>
        <head> 
            <meta charset="utf-8">
            <title>Your Community</title>

            <link id="stylesheet" rel="stylesheet" href="css/custom.css"/> 
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        </head>
_END;
require_once "header.php";
    if(isset($_POST['delete']))
    {
        $uid = $_POST['delete'];

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        
        // Attempt to connect. Return an error if not.
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        $query = "DELETE FROM users WHERE uid = '{$uid}'";
        $result = mysqli_query($connection,$query);


        if ($result)
        {
            // successfull
            echo "<div class='text-center fw-bold p-4 display-6 p-3 mb-2 bg-secondary text-white'>This User Has Been Deleted. <br></div> <div class='text-center'> <a href='manage_posts.php'>Click here</a> to manage all users.</div>";
        }
        else
        {    
            // show an unsuccessful signup message:
            echo "Update failed, please try again<br>";
        }
        mysqli_close($connection);
    }

    echo '</body>
<footer class="page-footer font-small footer"  style="background-color: #DECFAC; width: 100%;  position: absolute; bottom: 0;">
  <div class="footer-copyright text-center py-3">© 2022 Copyright: Arslan Tabusam
  </div>
<script src="js/custom.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</footer>';
?>