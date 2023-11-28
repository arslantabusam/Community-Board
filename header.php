<?php

    // database connection details:
    require_once "credentials.php";

    require_once "helper.php";

    //set timezone correctly
    date_default_timezone_set('Europe/London');

    // start/restart the session
    session_start();
    
    echo <<< _END
        <!DOCTYPE html>
        <head> 
        <meta charset="utf-8">
        <title>Your Community</title>

        <link id="stylesheet" rel="stylesheet" href="css/custom.css"/> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        </head>
        <body onload=display_ct();>
_END;

    //if the user is logged in 
    if(isset($_SESSION['loggedIn'])){

        //if the user is an admin
        if(strtolower($_SESSION['username']) == "admin"){
            echo <<<_END
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #DECFAC; padding: 20px;">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="#">Your Community</a>
                    <div class="collapse navbar-collapse" id="navbarNav" style="padding-top:20px;">
                    <!-- Example single danger button -->
                        <div class="btn-group adminDropdown">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </button>
                            <ul class="dropdown-menu text-center adminDropdown" >
                                <li><a class="dropdown-item" href="manage_posts.php">Manage Posts</a></li>
                                <li><a class="dropdown-item" href="manage_users.php">Manage Users</a></li>
                            </ul>
                        </div>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="create_post.php">Create Post</a></li>
                            <li class="nav-item"><a class="nav-link" href="user_posts.php">Edit Your Posts</a></li>
                            <li class="nav-item">
                            </li>
                            <li class="nav-item"><a class="nav-link" href="sign_out.php">Sign out</a></li>
            _END; 
            require_once "nav_end.php";
        }

        //if the user is not admin but a simple user
        else {
            
            require_once "nav_start.php";
            echo <<<_END
                <li class="nav-item"><a class="nav-link" href="user_posts.php">Edit Your Posts</a></li>                
                <li class="nav-item"><a class="nav-link" href="sign_out.php">Sign out</a></li>
            _END;
            require_once "nav_end.php";
        }
    }
    //if the user is not logged in 
    else{
        require_once "nav_start.php";
        echo <<<_END
             <li class="nav-item"><a class="nav-link" href="sign_in.php">Sign in</a></li>
            <li class="nav-item"><a class="nav-link" href="sign_up.php">Sign up</a></li>
        _END;
        require_once "nav_end.php";
    }
?>