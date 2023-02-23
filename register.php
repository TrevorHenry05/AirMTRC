<?php
require_once('config.php');
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$registerSuccess = false;
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Add your code for creating a new user account here
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if ( mysqli_connect_errno() )
    {
        die( mysqli_connect_error() );
    }
    // First, insert the user into the Users table
    $sql = "INSERT INTO User (Fname, Lname, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

    $stmt->execute();

    $user_id = mysqli_insert_id($connection);

    // Then, insert the new host into the Hosts table
    $sql = "INSERT INTO Host (user_id) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();


    $host_id = mysqli_insert_id($connection);

    // Finally, insert the new renter into the Renters table
    $sql = "INSERT INTO Renter (user_id) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();


    $renter_id = mysqli_insert_id($connection);
    // Set $registerSuccess to true if registration was successful
    $registerSuccess = true;
    // Redirect the user to the login page
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <?php if ($registerSuccess): ?>
            <div class="alert alert-success" role="alert">
                Registration successful! You can now <a href="login.php">log in</a> with your new account.
            </div>
            <?php else: ?>
            <div class="card mx-auto" style="max-width: 450px;">
                <div class="card-header">
                    <h2>Register</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="register.php">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" name="first_name" class="form-control" id="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" name="last_name" class="form-control" id="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <div class="card-footer">
                        Have an account? <a href="index.php">Login here</a>.
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>