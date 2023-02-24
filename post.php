<?php
session_start();
require_once('config.php');

$title = '';
$description = '';
$address = '';
$city = '';
$state = '';
$country = '';
$perday = 0;
$permonth = 0;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $address = $_POST['streetaddress'];
    $city = $_POST['city'];
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $country = $_POST['country'];
    $perday = $_POST['day'];
    $permonth = $_POST['month'];

    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if ( mysqli_connect_errno() )
    {
        die( mysqli_connect_error() );
    }

    $id = $_SESSION["user_id"];

    $sqlhost = "SELECT H.id AS host FROM User U INNER JOIN Host H ON U.id = H.user_id WHERE U.id = $id";
    $result = mysqli_query($connection, $sqlhost);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Retrieve the host ID from the query result
        $row = mysqli_fetch_assoc($result);
        $host_id = $row["host"];

        if(!empty($state)) {
            $sql = "INSERT INTO Property (title, description, address, city, state, country, host_id, short_term_cost_per_day, long_term_cost_per_month) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssssiii", $title, $description, $address, $city, $state, $country, $host_id, $perday, $permonth);

            $stmt->execute();
        } else {
            $sql = "INSERT INTO Property (title, description, address, city, country, host_id, short_term_cost_per_day, long_term_cost_per_month) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssssii", $title, $description, $address, $city, $country, $host_id, $perday, $permonth);

            $stmt->execute();
        }
    } else {
        // Handle the case where the query failed or did not return any results
        echo "Error: Unable to retrieve host ID.";
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Form</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <a class="nav-link" href="dashboard.php">Dashboard
                                <span class="visually-hidden"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="search.php">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="searchprice.php">Search Price</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="post.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <form  method="POST" action="post.php">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name = "title" placeholder="Enter title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name = "description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="street_address">Street Address</label>
                    <input type="text" class="form-control" id="street_address" name = "streetaddress" placeholder="Enter street address" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name = "city" placeholder="Enter city" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name = "state" placeholder="Enter state">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name = "country" placeholder="Enter country" required>
                </div>
                <div class="form-group">
                    <label for="cost_per_day">Cost per Day</label>
                    <input type="text" class="form-control" id="cost_per_day" name = "day" placeholder="Enter cost per day" required>
                </div>
                <div class="form-group">
                    <label for="cost_per_month">Cost per Month</label>
                    <input type="text" class="form-control" id="cost_per_month" name = "month" placeholder="Enter cost per month" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>