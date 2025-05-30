<?php
$servername = "localhost";
$username = "your_use";
$password = "your_password";
$dbname = "your_db_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check if passwords match
    if ($pass !== $confirm) {
        $message = "Passwords do not match!";
    } elseif (strlen($pass) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $user);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Username already taken.";
        } else {
            // Hash and insert new user
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $hashed_pass);

            if ($stmt->execute()) {
                $message = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<?php include"../head.php"?>
<head>
    <title>User Registration</title>
</head>
<style>
    .container-form{
        width: 100%;    
        min-height:80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form{
        padding:80px;
        border-radius: 15px;
        box-shadow: 1px 0px 5px 0px;
    }
    .fa-solid{
        position: relative;
        top:150px;
        left: 430px;
        font-size:30px;
        color:black;
        text-decoration:none;
    }
</style>
<body>
    <a href="../index.php" class="fa-solid fa-xmark"></a>
    <?php if ($message): ?>
        <p style="color: red;"><?= $message ?></p>
    <?php endif; ?>
    <div class="container-form">
        <form method="post" action="" class="form">
        <h2>Register</h2>
            <div class="form-group" class="mb-3">
                <label>Username:</label><br>
                <input type="text" name="username" required><br><br>
            </div>
            <div class="form-group" class="mb-3">
                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>
            </div>
            <div class="form-group" class="mb-3">
                <label>Confirm Password:</label><br>
                <input type="password" name="confirm_password" required><br><br>
            </div>
            <input type="submit" class="btn btn-primary" value="Register">
        </form>
    </div>
</body>
</html>
