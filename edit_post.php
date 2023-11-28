<?php
require_once "header.php";


$show_signIn_form = false;
$wrong_detail_message = false;
$errors= "";

$title_err="";
$content_err="";

if (isset($_SESSION['loggedIn']))
{
    if(isset($_POST['title'])){
        // take copies of the credentials the user submitted:
       $title = $_POST['title'];
       $content = $_POST['content'];
       $img = $_POST['image'];
       $postid = $_POST['postid'];
  
     // connect directly to our database (notice 4th argument):
         $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
     
       if(!$connection){
         die("Connection failed: " . $mysqli_connect_error);
       }
     
       //SERVER-SIDE VALIDATION 
       $title = sanitise($title, $connection);
       $content = sanitise($content, $connection);
       
       $title_errors = validateString($title, 3, 64);
       $content_errors = validateString($content, 5, 800);
     
       $errors = $title_errors . $content_errors;
       echo $title_errors;
       echo $title_errors;
       
       if($errors == ""){
    
         $date = date('Y-m-d H:i:s');
         $content = $content ."\nEdited: {$date}";

         $query = "UPDATE posts SET title = '{$title}', content='{$content}' WHERE postid = '{$postid}'";
    
         $result =  mysqli_query($connection, $query);
        
         if($result){
     
           // show a successful signin message:
           echo "<div class='text-center fw-bold p-4 display-6 p-3 mb-2 bg-secondary text-white'>This Post Has Been Updated. <br></div> <div class='text-center'> <a href='user_posts.php'>Click here</a> to view yours posts.</div>";
         } else {
             // show an unsuccessful signin message:
            echo <<<_END
             <!-- Instruction -->
             <div class="divider d-flex align-items-center my-4">
               <p class="text-center fw-bold mx-auto text-danger">Too little characters. Please try again</p>
             </div>
_END;
         }
          // we're finished with the database, close the connection:
          mysqli_close($connection);
       }
       else {
        echo "There are errors";
       }
     }
     else {
         echo "No request detected";
     }
}
else{
    echo "not logged in";
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