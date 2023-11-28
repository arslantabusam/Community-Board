<?php
require_once "header.php";
    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }


    // find all favourite films, ordered by their year of release (descending):
    $query = "SELECT * FROM posts";

    // this query can return data ($result is an identifier):
    $result = mysqli_query($connection, $query);

    // how many rows of data come back?
    $n = mysqli_num_rows($result);

    // there should only be one row
    if ($n>0){
        $author = '';  
                //Welcome line heading, changes depending on whether the user is logged in or not
                if(isset($_SESSION['loggedIn'])){
                echo <<<_END
                    <div class="jumbotron" style="background-color:#E8DDC5; padding: 40px;">
                        <table>
                            <tr>
                                <td>
                                    <h1 class="display-3">Hello, {$_SESSION['username']}!</h1>
                                    <p>View all the posts pubblished on this website.</p>
                                    <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: #C9AD7F; color:#000000E6;; border-color: #C9AD7F;">Create a new post &raquo;</a></p>
                                </td>
                                <td style="text-align: right;">
                                    <img src="images/pen.png" class="rounded-float-right col-sm-6 col-md-6 col-lg-4 img-fluid" height="250px" width="250px"/>
                                </td>
                            </tr>
                        </table>
                </div>
        _END;
                }
                else{
                    echo <<<_END
                    <div class="jumbotron" style="background-color:#E8DDC5; padding: 40px;">
                        <div>
                            <h4 class="display-3">Welcome to Your Community Noticeboard!</h4>
                            <h6>You are not logged in, please <a href="sign_in.php"> log in</a> or <a href="sign_up.php">sign up</a> to take record of your posts.</h6>
                            <p><a class="btn btn-dark btn-lg" href="create_post.php" role="button" style="margin-top: 1rem; background-color: #C9AD7F; color:#000000E6;; border-color: #C9AD7F;">Create a new post &raquo;</a></p>
                        </div>
                </div>
        _END;
                }
                
                echo '<div class="container" style="padding-top: 40px; padding-bottom: 30px"> 
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-5 col-md-3">
                                <form action="index.php" method="POST">
                                <select name="order" class="form-select form-select-sm form-select-padding-y-sm input-padding-y" aria-label="selectForm">
                                    <option selected>Sort</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                                
                            <div class="col-5 col-md-3">
                                <button type="submit" name="sort" class="btn btn-secondary btn-sm">Sort</button>
                                   </form>
                            </div>
                        </div>';
                        
            
                if(isset($_POST['sort'])){
                    if($_POST['order'] == 'asc'){
                        $query = "SELECT * FROM posts ORDER BY created ASC";
                        $result = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT firstname, lastname FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['firstname'] . ' ' . $name_row['lastname'];
                            }
                            else {
                                $author = "Anonymous";
                            }
                            echo <<<_END
                            <hr>
                                <div class="row">
                                    <div class="col-8"><h3> Title: {$row['title']}</h3><p> Time: {$row['created']}</p> <p> Author: {$author}</p> <p> Description: {$row['content']}</p></div>
                                    <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                                </div> 
 _END;
                        } 
                        echo '</div>';
                    }

                    elseif($_POST['order'] == 'desc'){
                        $query = "SELECT * FROM posts ORDER BY created DESC";
                        $result = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT firstname, lastname FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['firstname'] . ' ' . $name_row['lastname'];
                            }
                            else {
                                $author = "Anonymous";
                            }
                            echo <<<_END
                            <hr>
                                <div class="row">
                                    <div class="col-8"><h3> Title: {$row['title']}</h3><p> Time: {$row['created']}</p><p> Author: {$author}</p><p> Description: {$row['content']}</p></div>
                                    <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                                </div> 
 _END;
                        } 
                        echo '</div>';
                    }
                    else{
                        while($row = mysqli_fetch_assoc($result)){ 
                            if(isset($row['uid'])){
                                $name_query = "SELECT firstname, lastname FROM users WHERE uid = '{$row['uid']}'";
                                $name_result = mysqli_query($connection, $name_query);
                                $name_row = mysqli_fetch_assoc($name_result);
                                $author = $name_row['firstname'] . ' ' . $name_row['lastname'];
                            }
                            else {
                                $author = "Anonymous";
                            }
                            echo <<<_END
                            <hr>
                                <div class="row">
                                    <div class="col-8"><h3> Title: {$row['title']}</h3><p> Time: {$row['created']}</p><p> Author: {$author}</p><p> Description: {$row['content']}</p></div>
                                    <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                                </div> 
        _END;
                        } 
                        echo '</div>';
                    }
            }
            else{
                while($row = mysqli_fetch_assoc($result)){ 
                    if(isset($row['uid'])){
                        $name_query = "SELECT firstname, lastname FROM users WHERE uid = '{$row['uid']}'";
                        $name_result = mysqli_query($connection, $name_query);
                        $name_row = mysqli_fetch_assoc($name_result);
                        $author = $name_row['firstname'] . ' ' . $name_row['lastname'];
                    }
                    else {
                        $author = "Anonymous";
                    }
                    echo <<<_END
                    <hr>
                        <div class="row">
                            <div class="col-8"><h3> Title: {$row['title']}</h3><p> Time: {$row['created']}</p> <p> Author: {$author}</p><p> Description: {$row['content']}</p></div>
                            <div class="col-4"><img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid' /></div>
                        </div> 
_END;
                } 
                echo '</div>';
            }
        }
    // if anything else happens indicate a problem
    else {
        echo "<div class='text-center fw-bold p-4'> No Record found.<br> </div>";
    }

require_once "footer.php";
?>