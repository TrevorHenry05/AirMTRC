<?php
session_start();
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Price</title>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="searchprice.php">Search Price</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    </div>
             </div>
        </nav>
            <div class="jumbotron bg-white">
                <p class="lead">Search by Price<p>
                <hr class="my-4">
                <form method="GET" action="searchprice.php">
                    <div class="form-group">
                        <label for="min-price">Minimum Price:</label>
                        <input type="number" class="form-control" id="min-price" name="min_price" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="max-price">Maximum Price:</label>
                        <input type="number" class="form-control" id="max-price" name="max_price" min="0" step="0.01">
                    </div>
                    <select name="type">
                        <option value="short" selected>Short Term</option>
                        <option value="long">Long Term</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET")
                {
                    $min = isset($_GET['min_price']) ? $_GET['min_price'] : '';
                    $max = isset($_GET['max_price']) ? $_GET['max_price'] : '';
                    $type = $_GET['type'];

                if (!empty($min) || !empty($max))
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
                    if($type == "short") {
                        if (!empty($min) && !empty($max))
                        {
                            $sql .= "short_term_cost_per_day >= $min AND short_term_cost_per_day <= $max";
                        }
                        else if (!empty($min))
                        {
                            $sql .= "short_term_cost_per_day >= $min";
                        }
                        else if (!empty($max))
                        {
                            $sql .= "short_term_cost_per_day <= $max";
                        }
                    } else {
                        if (!empty($min) && !empty($max))
                        {
                            $sql .= "long_term_cost_per_month >= $min AND long_term_cost_per_month <= $max";
                        }
                        else if (!empty($min))
                        {
                            $sql .= "long_term_cost_per_month >= $min";
                        }
                        else if (!empty($max))
                        {
                            $sql .= "long_term_cost_per_month <= $max";
                        }
                    }

                    if ($result = mysqli_query($connection, $sql))
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                ?>
                <tr onclick="location.href='rental.php?id=<?php echo $row['id'] ?>';">
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
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>