<?php
require_once('config.php');
session_start();
$startdate = '';
$enddate = '';
$type = '';
$numdays = 0;

if (isset($_GET['id'])) {
    $_SESSION['pid'] = $_GET['id'];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startdate = $_POST['start_date'];
    $enddate = $_POST['end_date'];
    $type = $_POST['rental_type'];
    $numdays = $_POST['num_days'];

    $newsdate = date_format(date_create($startdate), "y-m-d");
    $newedate = date_format(date_create($enddate), "y-m-d");

    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }

    $id = $_SESSION["user_id"];

    $sqlrent = "SELECT R.id AS renter FROM User U INNER JOIN Renter R ON U.id = R.user_id WHERE U.id = $id";
    $result = mysqli_query($connection, $sqlrent);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Retrieve the renter ID from the query result
        $row = mysqli_fetch_assoc($result);
        $rent_id = $row["renter"];
        $property_id = $_SESSION['pid'];

        $sql = "INSERT INTO Rental (start_date, end_date, property_id, renter_id, type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssiis", $newsdate, $newedate, $property_id, $rent_id, $type);

        $stmt->execute();

        $rental_id = mysqli_insert_id($connection);

        if ($type === "short-term") {
            $sql = "SELECT short_term_cost_per_day FROM Property WHERE id = $property_id";
            $result2 = mysqli_query($connection, $sql);
            $arow = mysqli_fetch_assoc($result2);
            $perday = $arow["short_term_cost_per_day"];
            $amount = $numdays * $perday;
        } else {
            $sql = "SELECT long_term_cost_per_month FROM Property WHERE id = $property_id";
            $result2 = mysqli_query($connection, $sql);
            $arow = mysqli_fetch_assoc($result2);
            $permonth = $arow["long_term_cost_per_month"];
            $amount = $numdays * $permonth;
        }



        $givenDate = new DateTime($newedate);

        $givenTimestamp = $givenDate->getTimestamp();

        $randomTimestamp = rand($givenTimestamp, $givenTimestamp + 365 * 24 * 60 * 60);

        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        $due_date = $randomDate->format('Y-m-d');

        $sql = "INSERT INTO Invoice (rental_id, amount, due_date) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("iis", $rental_id, $amount, $due_date);

        $stmt->execute();

    } else {
        // Handle the case where the query failed or did not return any results
        echo "Error: Unable to retrieve renter ID.";
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Rental Page</title>
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
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <h5 class="card-header bg-primary text-white">Rental Form</h5>
                        <div class="card-body">
                            <form method="POST" action="rental.php">
                                <div class="mb-3">
                                    <label for="num_days" class="form-label">Number of Days or Months:</label>
                                    <input type="number" id="num_days" name="num_days" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label"></label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label"></label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="rental_type" class="form-label"></label>
                                    <select id="rental_type" name="rental_type" class="form-select" required>
                                        <option value="">--Select--</option>
                                        <option value="short-term" selected>Short Term</option>
                                        <option value="long-term">Long Term</option>
                                    </select>
                                </div>

                                <div class="mb-3 text-center">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



