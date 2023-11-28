<?php
require_once "header.php";

$show_signIn_form = false;
$wrong_detail_message = false;
$msg="";
$errors= "";

$username_err="";
$password_err="";

if (isset($_SESSION['loggedIn']))
{
    // user is already logged in, just display a message:
    echo "You are already logged in, please log out first<br>";
}
elseif(isset($_POST['username'])){
   // take copies of the credentials the user submitted:
  $username = $_POST['username'];
  $password = $_POST['password'];

// connect directly to our database (notice 4th argument):
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

  if(!$connection){
    die("Connection failed: " . $mysqli_connect_error);
  }

  //SERVER-SIDE VALIDATION 
  $username = sanitise($username, $connection);
  $password = sanitise($password, $connection);
  
  $username_errors = validateString($username, 3, 32);
  $password_errors = validateString($password, 4, 64);

  $errors = $username_errors . $password_errors;
  
  if($errors == ""){
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    $result =  mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    if($n >0){
      $row = mysqli_fetch_assoc($result);
      // set a session variable to record that this user has successfully logged in:
      $_SESSION['loggedIn'] = true;
      // and copy their username into the session data for use by our other scripts:
      $_SESSION['username'] = $username;
      $_SESSION['uid'] = $row['uid'];


      if(strtolower($_SESSION['username']) == 'admin'){
      // show a successful signin message:
     header("Location: manage_posts.php");
      }
      else {
        header("Location: user_posts.php");
      }

    } else {
      // no matching credentials found so redisplay the signin` form with a failure message:
        $show_signIn_form = true;
        // show an unsuccessful signin message:
        $wrong_detail_message = true;
    }
     // we're finished with the database, close the connection:
     mysqli_close($connection);
  }
  else {
    $show_signIn_form = true;
    $wrong_detail_message = true;
  }
}
else {
    $show_signIn_form = true;
}

if($show_signIn_form) {
echo <<<_END
  <!-- Log in form container  -->
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
            <h1>Your Community <br> notice<b style=" color: #9E7757;">board</b></h1>
            <img src="images/postit.jpg" class="img-fluid"
            alt="Post it logo" width="100px" height="100px">
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl">
              <form method="POST" action="sign_in.php">
_END;          

                if(!$wrong_detail_message){
                echo <<<_END
                 <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto">Please enter a username and password</p>
                </div>
_END;   
                }
                else {
                  echo <<<_END
                  <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4 text-center">
                  <p class="text-center fw-bold mx-auto link-danger">Wrong Details. Please try again</p>
                </div>
_END;
                }
                  echo <<<_END
                    <!-- Email input -->
                <div class="form-outline mb-4">
                  <label class="form-label" id="username" for="username">Username</label>
                  <input type="text" name="username" class="form-control form-control-lg"
                    placeholder="Enter your username" required/>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-1">
                  <label class="form-label" id="password" for="password">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg"
                    placeholder="Enter password" required/>
                
                </div>

                <!-- Log in button -->
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-dark btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: #DECFAC; color:#000000E6;; border-color: #DECFAC;">Login</button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="sign_up.php"
                      class="link-danger">Register</a></p>
                </div>
              </form>
          </div>
    </div>
</div>
_END;
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