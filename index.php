
<?php
session_start();
require_once('config.php');
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

$email = '';
$password = '';
$loginError = false;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the email and password from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password using the default algorithm
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare a SELECT statement to retrieve the user with the given email
    $stmt = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Check if a user with the given email was found
    if ($result->num_rows > 0) {

        // Get the user's data from the query result
        $row = $result->fetch_assoc();

        // Verify that the password matches the hash stored in the database
        if ($password == $row["password"]) {

            // Log in the user
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            $_SESSION["user_fname"] = $row["Fname"];
            $_SESSION["user_lname"] = $row["Lname"];

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit;

        } else {
            // Display an error message if the password is incorrect
            $error_message = "Invalid email or password.";
        }

    } else {
        // Display an error message if no user with the given email was found
        $error_message = "Invalid email or password.";
    }

    // Close the prepared statement
    $stmt->close();

}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login - AirMTRC</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                            <?php endif; ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            Don't have an account? <a href="register.php">Register now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>




