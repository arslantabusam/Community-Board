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
    $query = "SELECT * FROM posts WHERE uid='{$_SESSION['uid']}'";

    // this query can return data ($result is an identifier):
    $result = mysqli_query($connection, $query);

    // how many rows of data come back?
    $n = mysqli_num_rows($result);

    // there should only be one row
    if ($n>0){
        echo <<<_END
          <div class="jumbotron" style="background-color:#F6F7DE; padding: 40px;">
              <div>
                  <h1 class="display-3">Hello, {$_SESSION['username']}!</h1>
                  <p>Here you can view, edit and delete your posts on Your Community online noticeboards.</p>
                  <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: #DECFAC; color:#000000E6;; border-color: #DECFAC;">Create a new post &raquo;</a></p>
                </div>
              <img src="images/editpic.png" height="100px" width="150px" style="text-align: right; float: right;"/>
          </div>


          <div class="container" style="padding-top: 100px;">
             <div class="row" >
                
_END;

        for($i=0; $i<$n; $i++) {

        $row = mysqli_fetch_assoc($result);
            
        echo  '<div class="col-md-4" style="padding-bottom:20px;">
              <h3> Title: '.$row['title'].'</h3>
              <p> Time: '.$row['created'].'</p>
              <P> Post id: '.$row['postid'].'</p>
              <p> Description: '.$row['content'].'</p>
              <div style="float: left; padding-bottom: 10px;">

                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal'.$row['postid'].'">
                      Edit
                  </button>

                  <!-- Modal -->
                  <div class="modal" id="editModal'.$row['postid'].'" tabindex="-1" aria-labelledby="editModalLabel'.$row['postid'].'" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel'.$row['postid'].'">Update Post</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <input type="text" value="'.$row['postid'].'" readonly/>
                              <form method="POST" action="edit_post.php">
                                <div class="mb-3">
                                  <label for="title" class="col-form-label">Title:</label>
                                  <input type="text" class="form-control" name="title" value="'.$row['title'].'" required>
                                </div>
                                <div class="mb-3">
                                  <label for="content" class="col-form-label">Description:</label>
                                  <textarea class="form-control" name="content" rows="4" cols="50" required>'.$row['content'].'</textarea>
                                </div>
                                <div class="mb-3">
                                  <label for="image" class="col-form-label">Image:</label>
                                  <input type="hidden" name="postid" value="'.$row['postid'].'"/>
                                  <input type="text" class="form-control" readonly name="image" value="'.$row['image'].'" required>
                                </div>
                                <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                  </div>


                  <!--  Modal Delete -->  <!--  -->
                  
                  <div class="modal fade" id="deleteModal'.$row['postid'].'" aria-hidden="true" aria-labelledby="deleteModalLabel'.$row['postid'].'" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deletetoggleLabel">Delete Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p> Are you sure you want to delete this post? <br> "'.$row['postid'].'" Deleted posts cannot be accessed</p>
                          </div>
                          <form method="POST" action="delete-posts.php">
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-danger" value="'.$row['postid'].'" name="delete">Delete</button>
                          </div>
                        </form>
                      </div>
                   </div>
                 </div>
                 <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['postid'].'">Delete</button>
              </div>';
            

          if($row['image'] != NULL){
            echo <<<_END
            <img src="{$row['image']}" width="400px" class='rounded mx-auto d-block img-fluid'/>
_END;
          }
          echo '</div>';
}
        echo <<<_END
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