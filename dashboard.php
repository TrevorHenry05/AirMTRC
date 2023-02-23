<?php
require_once('config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>airMTRC</title>
        <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">Dashboard
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="search.php">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="searchprice.php">Search Price</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    </div>
             </div>
        </nav>
        <div class="jumbotron">
            <h1 class="display-3">Welcome to airMTRC</h1>
            <p class = "lead">Members: Trevor Henry (tjhenryschool@yahoo.com), Richard Le, Colton Wickens, and Masse Gashay</p>
            <p class="lead">You can use this web application to register, login, search for properties by city and/or state, view your rentals, and your properties<p>
            <hr class="my-4">
            <p>It uses MySQL DBMS and PHP to retrieve data from the database</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Thanks you for visiting!</a>
            </p>
        </div>
    </body>
</html>