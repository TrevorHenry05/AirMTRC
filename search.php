<?php
session_start();
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search</title>
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
                        <li class="nav-item active">
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
            <div class="jumbotron bg-white">
                <p class="lead">Search by Location<p>
                <hr class="my-4">
                <form method="GET" action="search.php">
                    <select name="city">
                        <option value="">Select a City</option>
                        <?php
                        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                        if (mysqli_connect_errno())
                        {
                            die(mysqli_connect_error());
                        }
                        $sql = "SELECT DISTINCT city FROM Property";
                        if ($result = mysqli_query($connection, $sql))
                        {
                            // loop through the data
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo '<option value="' . $row['city'] . '">';
                                echo $row['city'];
                                echo "</option>";
                            }
                            // release the memory used by the result set
                            mysqli_free_result($result);
                        }
                    ?>
                </select>

                <select name="state">
                    <option value="">Select a State</option>
                    <?php
                    $sql = "SELECT DISTINCT state FROM Property";
                    if ($result = mysqli_query($connection, $sql))
                    {
                        // loop through the data
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo '<option value="' . $row['state'] . '">';
                            echo $row['state'];
                            echo "</option>";
                        }
                        // release the memory used by the result set
                        mysqli_free_result($result);
                    }
                    mysqli_close($connection);
                    ?>
                </select>
                <button type="submit">Search</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET")
            {
                $city = isset($_GET['city']) ? $_GET['city'] : '';
                $state = isset($_GET['state']) ? $_GET['state'] : '';

                if (!empty($city) || !empty($state))
                {
            ?>
            <p>&nbsp;</p>
            <table class="table table-hover">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">State</th>
                        <th scope="col">Country</th>
                        <th scope="col">Per Day</th>
                        <th scope="col">Per Month</th>
                    </tr>
                </thead>
                <?php
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                    if (mysqli_connect_errno())
                    {
                        die(mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM Property WHERE ";
                    if (!empty($city) && !empty($state))
                    {
                        $sql .= "city = '$city' AND state = '$state'";
                    }
                    else if (!empty($city))
                    {
                        $sql .= "city = '$city'";
                    }
                    else if (!empty($state))
                    {
                        $sql .= "state = '$state'";
                    }

                    if ($result = mysqli_query($connection, $sql))
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                ?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['city'] ?></td>
                    <td><?php echo $row['state'] ?></td>
                    <td><?php echo $row['country'] ?></td>
                    <td><?php echo $row['short_term_cost_per_day'] ?></td>
                    <td><?php echo $row['long_term_cost_per_month'] ?></td>
                </tr>
                <?php
                        }
                        // release the memory used by the result set
                        mysqli_free_result($result);
                    }
                }
            }
                ?>
            </table>
            </form>
        </div>
    </body>
</html>