<?php
require_once('config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <style>
        .card {
            margin: 50px 30px;
        }
    </style>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
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
                                <span class="visually-hidden"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="search.php">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="searchprice.php">Search Price</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">Post</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    </div>
             </div>
        </nav>
            <div class="cardholder">
                <div class="card border-primary mb-3" style="max-width: 20rem;">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <p class="card-text">Email: <?php  echo  $_SESSION["user_email"] ?></p>
                        <p class="card-text">Name: <?php  echo  $_SESSION["user_fname"] ?> <?php  echo  $_SESSION["user_lname"] ?></p>
                    </div>
                </div>
            </div>
            <div class="jumbotron bg-white">
                <p class="lead"><p>
                <hr class="my-4">
                <form method="GET" action="profile.php">
                    <button type="submit" name="rental" value="rentals">User Rentals</button>
                    <button type="submit" name="properties" value="properties">User Properties</button>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET")
                    {
                        $rental = isset($_GET['rental']) ? $_GET['rental'] : '';
                        $properties = isset($_GET['properties']) ? $_GET['properties'] : '';

                        if (!empty($rental) || !empty($properties))
                        {
                            $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                            if (mysqli_connect_errno())
                            {
                                die(mysqli_connect_error());
                            }
                            $id = $_SESSION["user_id"];
                            if ($rental == "rentals")
                            {
                                $sql = "SELECT Property.title, Rental.start_date, Rental.end_date, Invoice.amount, Invoice.due_date
                                        FROM User
                                        INNER JOIN Renter
                                        ON User.id = Renter.user_id
                                        INNER JOIN Rental
                                        ON Renter.id = Rental.renter_id
                                        INNER JOIN Property
                                        ON Rental.property_id = Property.id
                                        INNER JOIN Invoice
                                        ON Rental.id = Invoice.rental_id
                                        WHERE User.id = $id";

                                ?>
                                <p>&nbsp;</p>
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-dark">
                                            <th scope="col">Title</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Due Date</th>
                                        </tr>
                                    </thead>
                                <?php

                                if ($result = mysqli_query($connection, $sql))
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['title'] ?></td>
                                            <td><?php echo $row['start_date'] ?></td>
                                            <td><?php echo $row['end_date'] ?></td>
                                            <td><?php echo $row['amount'] ?></td>
                                            <td><?php echo $row['due_date'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    // release the memory used by the result set
                                    mysqli_free_result($result);
                                }
                            } else {
                                $sql = "SELECT Property.title, Property.description, Property.short_term_cost_per_day, Property.long_term_cost_per_month
                                        FROM User
                                        INNER JOIN Host
                                        ON User.id = Host.user_id
                                        INNER JOIN Property
                                        ON Host.id = Property.host_id
                                        WHERE User.id = $id";

                                ?>
                                <p>&nbsp;</p>
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-dark">
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Short Term Price</th>
                                            <th scope="col">Long Term Cost</th>
                                        </tr>
                                    </thead>
                                <?php

                                if ($result = mysqli_query($connection, $sql))
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                            ?>
                                            <tr>
                                            <td><?php echo $row['title'] ?></td>
                                            <td><?php echo $row['description'] ?></td>
                                            <td><?php echo $row['short_term_cost_per_day'] ?></td>
                                            <td><?php echo $row['long_term_cost_per_month'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    // release the memory used by the result set
                                    mysqli_free_result($result);
                                }
                            }
                    } // end if (isset)
                } // end if ($_SERVER)
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>