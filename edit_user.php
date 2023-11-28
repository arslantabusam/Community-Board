<?php
require_once "header.php";


$show_signUp_form = false;
$errors= "";

$username_err="";
$password_err="";
$fname_rrr="";
$lname_err="";
$email_err="";
$age_err="";
$city_err="";
$county_err="";
$country_err="";
$phone_err="";

if(isset($_POST['update'])){
if (strtolower($_SESSION['username']) == 'admin')
{
    
   // take copies of the credentials the user submitted:
  $uid = $_POST['uid'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $age = $_POST['age'];
  $city = $_POST['city'];
  $county = $_POST['county'];
  $country = $_POST['country'];
  $phone = $_POST['phone'];

  // connect directly to our database (notice 4th argument):
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


  if(!$connection){
    die("Connection failed: " . $mysqli_connect_error);
  }

  //SERVER-SIDE VALIDATION 
  $username = sanitise($username, $connection);
  $password = sanitise($password, $connection);
  $firstname = sanitise($firstname , $connection);
  $lastname = sanitise($lastname, $connection);
  $email = sanitise($email, $connection);
  $city = sanitise($city, $connection);
  $county = sanitise($county, $connection);
  $country = sanitise($country, $connection);
  
  $username_errors = validateString($username, 3, 32);
  $password_errors = validateString($password, 4, 64);
  $firstname_errors = validateString($firstname, 1, 64);
  $lastname_errors = validateString($lastname, 1, 64);
  $email_errors = validateString($email, 3, 128);
  $age_errors = validateInt($age, 1, 150);
  $city_errors = validateString($city, 1, 32);
  $county_errors = validateString($county, 1, 40);
  $country_errors = validateString($country, 1, 60);
  $phone_errors = validateString($country, 4, 14);

  $errors = $username_errors . $password_errors . $firstname_errors . $lastname_errors . $email_errors . $age_errors . $city_errors .  $county_errors .  $country_errors .  $phone_errors;
  
  if($errors == ""){
    $query = "UPDATE users SET username = '{$username}', password = '{$password}', firstname = '{$firstname}', lastname = '{$lastname}', email = '{$email}', age = '{$age}', city = '{$city}', county = '{$county}', country = '{$country}', phone = '{$phone}'  WHERE uid = '{$uid}'";
    
    $result =  mysqli_query($connection, $query);

    if($result){
        // show a successful signup message:
        echo "<div class='text-center fw-bold p-4 display-6 p-3 mb-2 bg-secondary text-white'>{$username} Has Been Updated. <br></div> <div class='text-center'> <a href='manage_posts.php'>Click here</a> to manage all users.</div>";
    }
    else {
          // show the form:
            $show_signup_form = true;
            // show an unsuccessful signup message:
            $msg = "Could not update User's information, please try again<br>";
    }

     // we're finished with the database, close the connection:
     mysqli_close($connection);
  }
  else {
    echo "<b>Update Failed.";
    echo "<br><br></b>";
    $show_signup_form = true;
  }
}
}
else {
    $show_signUp_form = true;
}

if($show_signUp_form){
  echo '<!-- Log in form container  -->
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
            <h1>Your Community <br> notice<b style=" color: #9E7757;">board</b></h1>
            <img src="images/postit.jpg" class="img-fluid  list-inline"
            alt="Post it logo" width="100px" height="100px">
        </div>

        <div class="col-7 col-sm-6  col-md-5 col-lg-4 col-lg-4 offset-xl">
              <form method="POST" action="edit_user.php">

                 <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto">Update Details</p>
                </div>

                <!-- Username input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="uid" for="uid">Uid</label>
                  <input type="text" name="uid" value="'.$_POST['uid'].'" class="form-control form-control-md" maxlength="3" required/>
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" id="username" for="username">Username</label>
                  <input type="text" name="username" value="'.$_POST['username'].'" class="form-control form-control-md" maxlength="32" required/>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-3">
                <label class="form-label" id="password" for="form3Example4">Password</label>
                  <input type="text" name="password" value="'.$_POST['password'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>
                
                <!-- First name input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="firstname" for="firstname">First name</label>
                  <input type="text" name="firstname" value="'.$_POST['firstname'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>

                <!-- Last Name input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="lastname" for="lastname">Last name</label>
                  <input type="text" name="lastname" value="'.$_POST['lastname'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>

                <!-- Email input -->
                <div class="input-outline mb-3">
                <label class="form-label" id="email" for="email">Email</label>
                  <input type="email" name="email" value="'.$_POST['email'].'" class="form-control form-control-md" maxlength="128" required/>
                </div>

                <!-- Age input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="age" for="age">Age</label>
                  <input type="number" name="age" class="form-control form-control-md" value="'.$_POST['age'].'" min="0" max="150" required/>
                </div>

                <!-- City input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="city" for="city">City</label>
                  <input type="text" name="city" class="form-control form-control-md" value="'.$_POST['city'].'" maxlength="32" required/>
                </div>

                <!-- County input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="county" for="county">County</label>
                  <input type="text" name="county" class="form-control form-control-md" value="'.$_POST['county'].'" maxlength="40" required/>
                </div>

                <!-- Country input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="country" for="country">Country</label>
                  <input type="text" name="country" class="form-control form-control-md" value="'.$_POST['country'].'" maxlength="60" required/>
                </div>
                
                <!-- Phone input -->
                <div class="form-outline mb-4">
                <label class="form-label" id="phone" for="phone">Phone</label>
                  <input type="number" name="phone" class="form-control form-control-md" value="'.$_POST['phone'].'" minlength="4" maxlength="24" required/>
                </div>
                
                <!-- Log in button -->
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" name="update" class="btn btn-dark btn-lg" style="margin-bottom: 2em; background-color: #DECFAC; color:#000000E6;; border-color: #DECFAC;">Update</button>
                </div>
              </form>
          </div>
    </div>
</div>';
}
require_once "footer.php";
?>