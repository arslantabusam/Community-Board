<?php
require_once "header.php";


$show_signIn_form = false;
$wrong_detail_message = false;
$msg="";
$errors= "";

$title_err="";
$content_err="";

if(isset($_POST['title'])){
    // take copies of the credentials the user submitted:
   $title = $_POST['title'];
   $content = $_POST['content'];
 
 // connect directly to our database (notice 4th argument):
     $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 
   if(!$connection){
     die("Connection failed: " . $mysqli_connect_error);
   }
 
   //SERVER-SIDE VALIDATION 
   $title = sanitise($title, $connection);
   $content = sanitise($content, $connection);
   
   $title_errors = validateString($title, 3, 32);
   $content_errors = validateString($content, 5, 64);
 
   $errors = $title_errors . $content_errors;
   
   if($errors == ""){

     $date = date('Y-m-d H:i:s');
 
     if(isset($_SESSION['loggedIn'])){
         $query = "INSERT INTO posts(uid, title, created, content) VALUES('{$_SESSION['uid']}','$title', '$date', '$content')";
     }
     else {
         $query = "INSERT INTO posts(title, created, content) VALUES('$title', '$date', '$content')";
     }

     $result =  mysqli_query($connection, $query);
 
     if($result){
 
       // show a successful signin message:
       echo <<<_END
       <div class='text-center fw-bold p-4'> New Post Has Been Added.<br> </div>
       <div class="text-center"> <a href="create_post.php" class="text-primary">Click here </a>to add a new post </div>
     _END;
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
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl">
        <form method="POST" action="create_post.php">

                 <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto instruction">Create a new post!</p>
                </div>
_END;
              if($wrong_detail_message){
              echo <<<_END
                <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto text-danger">Too little characters. Please try again</p>
                </div>
_END; 
}
                echo <<<_END
                <!-- Title input -->
                <div class="form-outline mb-4">
                  <label class="form-label" id="title" for="title">Title</label>
                  <input type="text" name="title" class="form-control form-control-lg" required/>
                </div>

                <!-- Content input -->
                <div class="form-outline mb-1">
                  <label class="form-label" id="content" for="content">Description</label>
                  <textarea id="content"  name="content" rows="4" cols="50" name="content" class="form-control form-control-lg" required></textarea>
                  </div>
                
                  <!--
                  <div class="form-outline mb-1">
                  <label class="form-label" id="content" for="content">Image</label> <br>
                  <input type="file" name="img"/>
                    </textarea>
                  </div>
                  -->

                <!-- Post button -->
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-dark btn-lg" onclick="window.location.href='index.php';"
                    style="padding-left: 2.5rem; padding-right: 2.5rem; margin-bottom: 20px; background-color: #DECFAC; color:#000000E6;; border-color: #DECFAC;">Post</button>
_END;     
                  if(!isset($_SESSION['loggedIn'])){
                    echo <<<_END
                    <p class="small fw-bold mt-2 pt-1 mb-0">Want to edit your previous records? <br> Click here to <a href="sign_up.php"
                        class="text-primary">Register</a></p>
_END;
                  }
                    echo <<<_END
                </div>
              </form>
          </div>
    </div>
</div>
_END;
}

require_once "footer.php";
?>