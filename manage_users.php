<?php
require_once "header.php";

if(isset($_SESSION['loggedIn'])){
    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    // find all favourite films, ordered by their year of release (descending):
    $query = "SELECT * FROM users";

    // this query can return data ($result is an identifier):
    $result = mysqli_query($connection, $query);

    // how many rows of data come back?
    $n = mysqli_num_rows($result);

    // there should only be one row
    if ($n>0){
        echo '<div class="jumbotron" style="background-color:#F6F7DE; padding: 40px;">
                    <div>
                        <h1 class="display-3">Hello, '.$_SESSION['username'].'!</h1>
                        <h5>Manage users details and their accounts.</h5>
                    </div>
              </div>

        <div class="container" style="padding-top: 100px;">
             <div class="row" >
                <div class="table-responsive-sm table-responsive-md table-responsive-sm table-responsive-md table-responsive-lg table-responsive-lg">
                <table class="table">
                    <tr> <th scope="col">User Id</th><th scope="col">User Details</th> <th scope="col"> Contact Details </th><th scope="col"> Password </th> <th scope="col"> Address</th> <th scope="col"> Manage</th> </tr>
             ';

             
        for($i=0; $i<$n; $i++) {

        $row = mysqli_fetch_assoc($result);
            
        echo  '<tr> 
                        <th scope="row"> <p> '.$row['uid'].'</p> </th>
                        <td style="text-align:left">
                            <p> Username: '.$row['username'].'</p>
                            <p> First Name: '.$row['firstname'].'</p>
                            <p> Last Name: '.$row['lastname'].'</p>
                            <p> Age: '.$row['age'].'</p>
                        </td>
                            
                        <td>  
                            <p> Email: '.$row['email'].'</p>
                            <p> Phone: '.$row['phone'].'</p>
                         </td>

                         <td>  
                             <p> Password: </label> <p>'.$row['password'].'</p>
                         </td>
                         <td>  
                            <p> City: '.$row['city'].'</p>
                            <p> County: '.$row['county'].'</p>
                            <p> Country: '.$row['country'].'</p>
                         </td>

                         <td class="p-5">

                                <!-- Buttons-->

                                        <!-- Edit Button form -->
                                        <form method="POST" action="edit_user.php">
                                            <input type="hidden" name="uid" value="'.$row['uid'].'"/>
                                            <input type="hidden" name="username" value="'.$row['username'].'"/>
                                            <input type="hidden" name="firstname" value="'.$row['firstname'].'"/>
                                            <input type="hidden" name="lastname" value="'.$row['lastname'].'"/>
                                            <input type="hidden" name="age" value="'.$row['age'].'"/>
                                            <input type="hidden" name="email" value="'.$row['email'].'"/>
                                            <input type="hidden" name="phone" value="'.$row['phone'].'"/>
                                            <input type="hidden" name="password" value="'.$row['password'].'"/>
                                            <input type="hidden" name="city" value="'.$row['city'].'"/>
                                            <input type="hidden" name="county" value="'.$row['county'].'"/>
                                            <input type="hidden" name="country" value="'.$row['country'].'"/>
                                            <button type="submit" class="btn btn-secondary">Edit</button>
                                        </form>

                                        <!-- Delete Button trigger modal -->
                                        <button type="button" style="margin:10px"class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['uid'].'">Delete</button>
                                        <!--  Modal Delete -->  <!--  -->
                                        <div class="modal fade" id="deleteModal'.$row['uid'].'" aria-hidden="true" aria-labelledby="deleteModalLabel'.$row['uid'].'" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="deletetoggleLabel">Delete Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <p> Are you sure you want to delete this post? <br> "'.$row['uid'].'" Deleted posts cannot be accessed</p>
                                                </div>
                                                <form method="POST" action="delete-user.php">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" value="'.$row['uid'].'" name="delete">Delete</button>
                                                </div>
                                                </form>
                                             </div>
                                            </div>
                                        </div>
                         </td>

                    </tr>
               ';
}
        echo <<<_END
        
        </table>
        </div>
        </div>
        </div>
_END;
    }

    // if anything else happens indicate a problem
    else {
        echo "<div class='text-center fw-bold p-4'> No Record found.<br> </div>";
    }
}
else {
    echo "You must be logged in to see this page";
}

require_once "footer.php";

?>