<?php
session_start();

// Hardcoded user credentials for demonstration
$valid_username = "admin";
$valid_password = "123"; // In a real application, use password hashing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION["username"] = $username;
        header("Location: cart.php"); // Redirect to dashboard
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include"head.php"?>
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

</style>
<body>
<?php include"navbar.php"?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
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
                <button type="submit" class="btn btn-primary mb-3" style="margin-top:10px">Login</button>
            </form>
            <form>
  <!-- <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
        </div> -->
</body>
</html>
