<?php
session_start();

// Database connection
$servername = "localhost";
$username = "your_use";
$password = "your_password";
$dbname = "your_db_name";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            header("Location: ../dashbord.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include"../head.php"?>
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
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
        <div class="container-form">
            <form action="" method="post" class="form">
            <h2>Login Form</h2>
                <div class="form-group" class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <input type="text" class="form-control"  id="username"  name='username' required>
                </div>
                <div class="form-group" class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control"  id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mb-3" style="margin-top:10px" value="Login">Login</button>
            </form>
            <form>
</body>
</html>
